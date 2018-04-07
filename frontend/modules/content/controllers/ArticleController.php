<?php
namespace frontend\modules\content\controllers;
use frontend\models\BackendUser;
use frontend\controllers\BaseController;
use frontend\models\Article;
use frontend\models\Comment;
use frontend\models\Favorite;
use frontend\models\Collect;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\LinkPager;
use yii\caching\DbDependency;

class ArticleController extends BaseController
{

    /**
     * 行为控制vip专题的访问权
     */

    /**
     * 文章内容页
     */
    public function actionView(){
        $id = (int) Yii::$app->request->get('id');
        if($id <= 0){
            throw new BadRequestHttpException('请求参数错误。');
        }

        $cache = Yii::$app->cache;
        $article = $cache->get(['article', $id]);
        if ($article === false){
            //获取文章信息
            $article = Article::getDetail($id);
            if (empty($article))
                throw new NotFoundHttpException('没有相关数据。');

            //设置缓存
            $dependency = new DbDependency(['sql'=>"select created_at from {{article}} where id=" . $id]);
            $cache->set(['article', $id], $article, 3600, $dependency);
        }


        //如果是登录用户判断是否已喜欢
        $article['favorite'] = false;
        $article['collect'] = false;
        if (!Yii::$app->user->isGuest){
            $article['favorite'] = Favorite::isExists($article['id'],Yii::$app->user->getId());
            $article['collect'] = Collect::isExists($article['id'],Yii::$app->user->getId());
        }



        //获取上一篇和下一篇
        $prevAndNext = Article::getPreviousAndNext($article['id'],$article['subject_id']);



        //获取用户详情
        $user = BackendUser::getAuthor($article['created_by']);


        //获取评论
        $ret = self::getComments($article['id'],100);
        $comments = $ret['comments'];
        $pagination = $ret['pagination'];
        $commentNum = $ret['commentNum'];


        //添加阅读次数
        $article->updateCounters(['visited'=>1]);

        $visible = [
            'vipArticle' => $article['subject']['type'] === 1,
            'isLogin' => !Yii::$app->user->isGuest,
            'vipUser' => Yii::$app->user->isGuest ? false : Yii::$app->user->identity->isvip,

        ];



        $this->view->title = $article['title'];
        $this->view->params['description'] = $article['brief'];
        return $this->render('view',[
            'article' => $article,
            'user'=>$user,
            'prevAndNext' => $prevAndNext,
            'comments' => $comments,
            'pagination' => $pagination,
            'commentNum' => $commentNum,
            'visible' => $visible,
        ]);
    }


    /**
     * ajax 添加喜欢
     */
    public function actionAjaxFavorite(){
        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            //获取文章id
            $aid = (int)Yii::$app->request->get('aid');
            if ($aid <= 0)
                throw new BadRequestHttpException('请求参数错误。');

            //判断是否登陆
            if (Yii::$app->user->isGuest){
                return ['errcode'=>0, 'message'=>'请先登录，再做此操作。'];
            }

            //判断是否已经添加喜欢
            $uid = Yii::$app->user->getId();
            if (Favorite::isExists($aid, $uid)){
                return ['errcode'=>0, 'message'=>'已经添加喜欢，不要重复提交。'];
            }

            //保存数据
            $favorite = new Favorite();
            $favorite->article_id = $aid;
            $favorite->user_id = $uid;

            if($favorite->save()){
                //添加成功
                return ['errcode'=>0, 'message'=>'添加喜欢成功。'];
            }
            return ['errcode'=>1, 'message'=>'添加喜欢失败，请重试。'];


        }
        return false;
    }

    /**
     * ajax 添加收藏
     */
    public function actionAjaxCollect(){
        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            //获取文章id
            $aid = (int)Yii::$app->request->get('aid');
            if ($aid <= 0)
                throw new BadRequestHttpException('请求参数错误。');

            //判断是否登陆
            if (Yii::$app->user->isGuest){
                return ['errcode'=>0, 'message'=>'请先登录，再做此操作。'];
            }

            //判断是否已经添加喜欢
            $uid = Yii::$app->user->getId();
            if (Collect::isExists($aid, $uid)){
                return ['errcode'=>0, 'message'=>'已经添加收藏，不要重复提交。'];
            }

            //保存数据
            $favorite = new Collect();
            $favorite->article_id = $aid;
            $favorite->user_id = $uid;

            if($favorite->save()){
                //添加成功
                return ['errcode'=>0, 'message'=>'添加收藏成功。'];
            }
            return ['errcode'=>1, 'message'=>'添加收藏失败，请重试。'];


        }
        return false;
    }


    /**
     * 获取评论与回复数据
     * @param int $aid #文章id
     * @param bool $onlyData #是否只返回数据 默认false
     * @param int $page #分页数据的页码 从0开始表示第一页
     * @return array #评论数据 和 分页
     */
    public static function getComments($aid, $page = 0 ,$onlyData = false){
        $ret = Comment::getComments($aid, $page);

        //判断是否只需要数据
        if ($onlyData){
            return $ret['comments'];
        }
        return $ret;
    }

    /**
     * Ajax 请求评论数据（分页数据）
     */
    public function actionAjaxGetComments(){

        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            //接收分页数据
            $page = (int)Yii::$app->request->get('page');
            $aid = (int)Yii::$app->request->get('aid');

            if ($page < 0 || $aid <= 0)
                throw new BadRequestHttpException('传递参数错误');

            //获取数据
            $comments = Self::getComments($aid, $page, false);
            if (empty($comments))
                return ['errcode'=>1, 'message'=>'没有数据。'];

            //返回数据
            //如果没有头像使用默认头像
            foreach($comments['comments'] as $k => &$v){
                if(empty($v['user']['photo'])){
                    $v['user']['photo'] = Yii::$app->params['userPhoto'];
                }

                $v['created_at'] = date('Y-m-d H:i:s');
                foreach ($v['replys'] as &$r){
                    $r['created_at'] = date('Y-m-d H:i:s');
                }

            }
            return [
                'errcode' => 0,
                'data' => $comments['comments'],
                'pager'=> LinkPager::widget([
                    'pagination' => $comments['pagination'],
                    'nextPageLabel' => false,
                    'prevPageLabel' => false,
                ])
            ];

        }
        return false;
    }



}