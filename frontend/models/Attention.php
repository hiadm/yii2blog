<?php
namespace frontend\models;
use yii\db\ActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class Attention extends ActiveRecord
{
    //表名
    public static function tableName()
    {
        return "{{%attention}}";
    }

    //行为
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => null
            ],
        ];
    }

    //保存数据
    public function store($subject_id){
        $user_id = Yii::$app->user->getId();
        //检测是否存在
        if (self::isExists($subject_id, $user_id))
            return true;

        //保存数据
        $this->subject_id = $subject_id;
        $this->user_id = $user_id;

        return $this->save();
    }

    //检测当前用户是否已经关注了该专题
    public static function isExists($subject_id, $user_id){

        $ret = self::find()
            ->where(['and', ['subject_id'=>$subject_id], ['user_id'=>$user_id]])
            ->one();
        return (bool)$ret;
    }

    //获取当前用户关注的专题id集合
    public static function getAttention(){
        $user_id = Yii::$app->user->getId();

        $ret = self::find()
            ->where(['user_id'=>$user_id])
            ->select(['subject_id'])
            ->asArray()
            ->column();
        return $ret;
    }

    /**
     * 获取专题关注个数
     */
    public static function getAttentionNum($subject_id){
        return self::find()
            ->where(['subject_id'=>$subject_id])
            ->count();
    }


}