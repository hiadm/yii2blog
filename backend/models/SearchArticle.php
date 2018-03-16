<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Article;

/**
 * SearchArticle represents the model behind the search form of `backend\models\Article`.
 */
class SearchArticle extends Article
{
    public $subject;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'favorite', 'collect', 'visited', 'content_id', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['title', 'brief', 'smallimg', 'bigimg', 'type', 'isbest', 'isdraft', 'isrecycle','subject'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {


        $query = Article::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $isdraft = (int)(empty($params['isdraft'])?'':$params['isdraft']);
        $isrecycle = (int)(empty($params['isrecycle'])?'':$params['isrecycle']);
        $isall = (int)(empty($params['isall'])?'':$params['isall']);
        if(!$isall){
            if ($isdraft === 1){
                $query->andFilterWhere([
                    'isdraft' => 1,
                ]);
            }
            if ($isrecycle === 1){
                $query->andFilterWhere([
                    'isrecycle' => 1,
                ]);
            }
        }

        $subject_id = Subject::find()
            ->select(['id'])
            ->where(['name' => $this->subject])
            ->scalar();
        if($subject_id){
            $query->andFilterWhere([
                'subject_id' => $subject_id,
            ]);
        }




        // grid filtering conditions
        $query->andFilterWhere([
            //'id' => $this->id,
            //'favorite' => $this->favorite,
            //'collect' => $this->collect,
            //'visited' => $this->visited,
            //'subject_id' => $this->subject_id,
            //'content_id' => $this->content_id,
            //'created_by' => $this->created_by,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
        ]);

        $query
            //->andFilterWhere(['like', 'title', $this->title])
            //->andFilterWhere(['like', 'brief', $this->brief])
            //->andFilterWhere(['like', 'smallimg', $this->smallimg])
            //->andFilterWhere(['like', 'bigimg', $this->bigimg])
            ->andFilterWhere(['type' => $this->type])
            ->andFilterWhere(['isbest'=>$this->isbest])
            //->andFilterWhere(['like', 'isdraft', $this->isdraft])
            //->andFilterWhere(['like', 'isrecycle', $this->isrecycle])
        ;

        return $dataProvider;
    }
}
