<?php
namespace frontend\models;
use backend\models\User;

class BackendUser extends User
{
    //获取作者详细信息
    public static function getAuthor($author_id){
        return self::findOne($author_id);
    }
}