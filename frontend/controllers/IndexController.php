<?php
namespace frontend\controllers;

use frontend\models\Article;
use frontend\models\Subject;
use frontend\models\Friend;


class IndexController extends BaseController
{
    public $layout = 'layout';

    /**
     * 前台首页
     */
    public function actionIndex(){

        //获取首页专题列表
        $subjects = Subject::getActiveSubject();

        //获取首页精品文章 3个
        $bestArticle = Article::getIndexBest();

        //获取首页文章列表
        $articleData = Article::getArticle();

        //获取首页友情链接
        $friends = Friend::getFriends();
        //var_dump($friends);die;


        return $this->render('index',[
            'subjects' => $subjects,
            'bestArticle' => $bestArticle,
            'articles' => $articleData['articles'],
            'pagination' => $articleData['pagination'],
            'friends' => $friends,
        ]);
    }
}