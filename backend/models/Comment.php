<?php

namespace backend\models;

use Yii;

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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'article_id', 'likes', 'created_at'], 'integer'],
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
            'content' => '评论内容',
            'likes' => '喜欢',
            'created_at' => '收藏时间',
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
}
