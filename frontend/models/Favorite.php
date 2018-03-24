<?php
namespace frontend\models;
use yii\db\ActiveRecord;

class Favorite extends ActiveRecord
{
    //表名
    public static function tableName()
    {
        return "{{%favorite}}";
    }

    /**
     * 绑定事件
     */
    public function init ()
    {
        parent::init();
        $this->on(self::EVENT_AFTER_DELETE, [$this, 'onAfterDelete']);
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'onAfterInsert']);
    }

    /**
     * 添加收藏时更新文章收藏数
     * @param $event
     */
    public function onAfterInsert($event){
        Article::updateAllCounters(['favorite'=>1], ['id'=>$this->article_id]);
    }


    /**
     * 取消收藏时更新文章收藏数
     *
     * @param $event
     */
    public function onAfterDelete($event){
        Article::updateAllCounters(['favorite'=>-1], ['id'=>$this->article_id]);
    }

    /**
     * 判断用户是否已经添加文章喜欢
     * @param int $aid #文章id
     * @param int $uid #用户id
     * @return bool #存在返回true 否则返回false
     */
    public static function isExists($aid, $uid){
        return (bool)self::find()
            ->select('id')
            ->where(['article_id'=>$aid])
            ->andWhere(['user_id'=>$uid])
            ->scalar();
    }

}