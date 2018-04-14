<?php
namespace frontend\models;
use yii\data\Pagination;
use yii\helpers\Html;

class SearchArticle extends Article
{

    public static function search($words)
    {
        $query = article::find()
            ->where(['like', 'title', $words])
            ->andWhere(['isrecycle'=>0]);

        $countQuery = clone $query;
        $count = $countQuery->count();

        $pagination = new Pagination(['totalCount' => $count,'pageSize'=>15]);

        $articles = $query
            ->with('user','subject')
            ->select(['{{%article}}.id','title','brief','favorite','collect','visited','created_at','smallimg','created_by','subject_id'])
            ->offset($pagination->offset)
            ->limit($pagination->limit)

            ->asArray()
            ->orderBy(['created_at'=>SORT_DESC])
            ->all();


        return [
            'articles' => $articles,
            'pagination' => $pagination,
        ];


    }
}