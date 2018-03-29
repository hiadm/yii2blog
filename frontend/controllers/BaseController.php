<?php
namespace frontend\controllers;
use frontend\models\Seo;
use yii\web\Controller;
use Yii;
use yii\caching\DbDependency;

class BaseController extends Controller
{
    public function init()
    {
        parent::init();



        //站点基本信息
        $dependency = new DbDependency();
        $dependency->sql = "select updated_at from {{%seo}} where id=1";

        $cache = Yii::$app->cache;
        $siteInfo = $cache->getOrSet('siteInfo', function () {
            return Seo::getSiteInfo();
        }, 7200, $dependency);




        //默认头像
        $userPhoto = Yii::$app->params['userPhoto'];
        $this->view->params['userPhoto'] = $userPhoto;
        //站点信息
        $this->view->params['siteInfo'] = $siteInfo;
    }
}