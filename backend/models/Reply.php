<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%reply}}".
 *
 * @property string $id 主键
 * @property string $user_id 用户id
 * @property string $article_id 文章id
 * @property string $comment_id 评论id
 * @property string $content 回复内容
 * @property string $created_at 收藏时间
 */
class Reply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%reply}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'article_id', 'comment_id', 'created_at'], 'integer'],
            [['content'], 'required'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'user_id' => '用户id',
            'article_id' => '文章id',
            'comment_id' => '评论id',
            'content' => '回复内容',
            'created_at' => '收藏时间',
        ];
    }

    //定义关联
    public function getUser(){
        return $this->hasOne(User::className(), ['id'=>'user_id'])->select(['username','id','photo']);
    }
}
