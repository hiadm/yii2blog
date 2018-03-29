<?php
namespace frontend\models;
use backend\models\Friend as BackendFriend;

class Friend extends BackendFriend
{
    public static function getFriends(){
        return self::find()
            ->limit(35)
            ->orderBy(['sort'=>SORT_ASC,'id'=>SORT_DESC])
            ->asArray()
            ->all();

    }
}