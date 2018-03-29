<?php
namespace frontend\models;
use backend\models\Seo as backendSeo;

class Seo extends backendSeo
{
    public static function getSiteInfo(){
        $ret = self::findOne(1)->toArray();

        //反序列化
        return self::unserializeArr($ret);
    }


    /**
     * 把序列化的快速通道 关注我 转为数组
     */
    public static function unserializeArr($arr){
        $arr['fastchannel'] = unserialize($arr['fastchannel']);
        $arr['followme'] = unserialize($arr['followme']);

        return $arr;
    }
}