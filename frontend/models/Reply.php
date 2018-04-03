<?php
namespace frontend\models;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\models\User;
use backend\models\Reply as ReplyModel;

class Reply extends ReplyModel
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => null,
            ],
        ];
    }



    /**
     * 检测提交时间是否在安全时间
     * 即距上次回复2分钟之外
     */
    public static function canCommit($aid, $cid){
        return !(bool)self::find()
            ->where(['article_id' => $aid])
            ->andWhere(['comment_id' => $cid])
            ->andWhere(['>=', 'created_at', time()-120])
            ->count();
    }

}