<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property string $id 主键
 * @property string $user_id 用户id
 * @property string $article_id 文章id
 * @property string $content 评论内容
 * @property int $likes 喜欢
 * @property string $created_at 收藏时间
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => null,
            ],
        ];
    }

    //定义关联
    public function getReplys(){
        return $this->hasMany(Reply::className(), ['comment_id'=>'id'])
            ->with('user')
            ->orderBy(['created_at'=>SORT_ASC]);
    }
    public function getUser(){
        return $this->hasOne(User::className(), ['id'=>'user_id'])->select(['username','id','photo']);
    }


    /**
     * 检测用户是否刚刚评论过（2分钟之内）
     * @param int $uid #用户id
     * @return bool #可提交返回true 否则false
     */
    public static function canCommit($uid){
        return  !self::find()
            ->where(['user_id'=>$uid])
            ->andWhere(['>=', 'created_at', time()-120])
            ->count();
    }

    /**
     * 获取指定文章的所有评论和回复
     * @param int $article_id #文章id
     * @return array #所有评论和回复 或 空数组
     */
    /*public static function getComments1($article_id){
        $ret = self::find()
            ->with('replys')
            ->with('user')
            ->where(['article_id'=>$article_id])
            ->asArray()
            ->orderBy(['created_at'=>SORT_DESC])
            //->createCommand()->getSql();
            ->all();
        return $ret;

    }*/
    public static function getComments($article_id, $page){
        $query = self::find()->where(['article_id'=>$article_id]);

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count,'pageSize'=>5]);
        if ($page !== 0 && $page < $count)
            //$pagination->offset = $page * $pagination->limit;
            $pagination->setPage($page);


        $comments = self::find()
            ->with('replys')
            ->with('user')
            ->where(['article_id'=>$article_id])
            ->asArray()
            ->orderBy(['created_at'=>SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        //$ret['pagination'] = $pagination;
        return [
            'comments' => $comments,
            'pagination' => $pagination,
            'commentNum' => $count,
        ];

    }



}
