<?php
namespace console\controllers;
use yii\console\Controller;

/**
 * 初始化后台权限
 */
class InitPermissionController extends Controller
{
    //初始化权限
    public function actionPermission(){
        $transaction = \Yii::$app->getDb()->beginTransaction();
        try {
            //获取权限管理组件
            $auth = \Yii::$app->authManager;

            //添加管理权限和管理角色
            $this->addManagePermission($auth);

            //添加作者权限和作者角色
            $this->addAuthorPermission($auth);

            //让管理权限包含作者权限
            $this->adminAddAuthor($auth);

            //添加编辑删除自己文章的权限
            $this->addUpdateOwnPost($auth);



            $transaction->commit();
        } catch(\Exception $e) {

            $transaction->rollBack();
            throw $e;
        } catch(\Throwable $e) {

            $transaction->rollBack();
            throw $e;
        }





        /*1 $admin  = $auth->createPermission('admin');
        $admin->description = '网站管理权限。';
        $auth->add($admin);

        //所有路由
        $all = $auth->getPermission('/*');
        $auth->addChild($admin, $all);

        //创建管理员角色
        $adminRole = $auth->createRole('管理员');
        $auth->add($adminRole);

        //把网站管理权限分配给管理员角色
        $auth->addChild($adminRole, $admin);*/

        /*2 //创建作者权限
        $author  = $auth->createPermission('author');
        $author->description = '文章写作编辑权限。';
        $auth->add($author);

        //文章创建 查看路由
        $create = $auth->getPermission('/content/article/create');
        $index = $auth->getPermission('/content/article/index');
        $upload = $auth->getPermission('/content/article/upload');
        $view = $auth->getPermission('/content/article/view');
        $auth->addChild($author, $create);
        $auth->addChild($author, $index);
        $auth->addChild($author, $upload);
        $auth->addChild($author, $view);
        //专题查看
        $subject_index = $auth->getPermission('/content/subject/index');
        $subject_view = $auth->getPermission('/content/subject/view');
        $auth->addChild($author, $subject_index);
        $auth->addChild($author, $subject_view);
        //标签查看
        $tag_index = $auth->getPermission('/content/tag/index');
        $tag_view = $auth->getPermission('/content/tag/view');
        $auth->addChild($author, $tag_index);
        $auth->addChild($author, $tag_view);

        //ajax操作
        $ajaxGetSubjects = $auth->getPermission('/content/subject/ajax-get-subjects');
        $ajaxGetTags = $auth->getPermission('/content/tag/ajax-get-tags');
        $auth->addChild($author, $ajaxGetSubjects);
        $auth->addChild($author, $ajaxGetTags);

        //创建作者角色
        $authorRole = $auth->createRole('作者');
        $auth->add($authorRole);

        //把作者权限分配给作者角色
        $auth->addChild($authorRole, $author);*/

        /*3//吧作者权限分配给管理员
        $auth->addChild($admin, $author);*/

    }


    /**
     * 添加管理员权限和角色
     * @param object $auth
     */
    public function addManagePermission($auth){
        $admin  = $auth->createPermission('admin');
        $admin->description = '网站管理权限。';
        $auth->add($admin);

        //所有路由
        $all = $auth->getPermission('/*');
        $auth->addChild($admin, $all);

        //创建管理员角色
        $adminRole = $auth->createRole('管理员');
        $auth->add($adminRole);

        //把网站管理权限分配给管理员角色
        $auth->addChild($adminRole, $admin);
    }

    /**
     * 添加作者权限 和作者角色
     * @param object $auth
     */
    public function addAuthorPermission($auth){
        //创建作者权限
        $author  = $auth->createPermission('author');
        $author->description = '文章写作编辑权限。';
        $auth->add($author);

        //文章创建 查看路由
        $create = $auth->getPermission('/content/article/create');
        $index = $auth->getPermission('/content/article/index');
        $upload = $auth->getPermission('/content/article/upload');
        $view = $auth->getPermission('/content/article/view');
        $auth->addChild($author, $create);
        $auth->addChild($author, $index);
        $auth->addChild($author, $upload);
        $auth->addChild($author, $view);
        //专题查看
        $subject_index = $auth->getPermission('/content/subject/index');
        $subject_view = $auth->getPermission('/content/subject/view');
        $auth->addChild($author, $subject_index);
        $auth->addChild($author, $subject_view);
        //标签查看
        $tag_index = $auth->getPermission('/content/tag/index');
        $tag_view = $auth->getPermission('/content/tag/view');
        $auth->addChild($author, $tag_index);
        $auth->addChild($author, $tag_view);

        //ajax操作
        $ajaxGetSubjects = $auth->getPermission('/content/subject/ajax-get-subjects');
        $ajaxGetTags = $auth->getPermission('/content/tag/ajax-get-tags');
        $auth->addChild($author, $ajaxGetSubjects);
        $auth->addChild($author, $ajaxGetTags);

        //创建作者角色
        $authorRole = $auth->createRole('作者');
        $auth->add($authorRole);

        //把作者权限分配给作者角色
        $auth->addChild($authorRole, $author);
    }


    /**
     * 把作者权限分配给管理权限
     * @param object $auth
     */
    public function adminAddAuthor($auth){
        $admin = $auth->getPermission('admin');
        $author = $auth->getPermission('author');


        $auth->addChild($admin, $author);
    }


    /**
     * 创建可编辑删除自己作品的权限 并分配给作者角色
     */
    public function addUpdateOwnPost($auth){
        // 添加规则
        $rule = new \common\rbac\AuthorRule();
        $auth->add($rule);

        // 添加 "updateAndDeleteOwnArticle" 权限并与规则关联
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = '更新和删除自己作品的权限。';
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);


        // "$updateOwnPost" 使用 "/content/article/update  和  /content/article/delete" 权限使用
        $updateArticle = $auth->getPermission('/content/article/update');
        $auth->addChild($updateOwnPost, $updateArticle);

        $deleteArticle = $auth->getPermission('/content/article/delete');
        $auth->addChild($updateOwnPost, $deleteArticle);

        // 允许 "authorRole" 更新自己的帖子
        $authorRole = $auth->getRole('作者');
        $auth->addChild($authorRole, $updateOwnPost);
    }
}