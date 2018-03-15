<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Tag;

/**
 * SearchTag represents the model behind the search form of `backend\models\Tag`.
 */
class SearchTag extends Tag
{
    public $subject;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject'], 'safe'],
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
        $query = Tag::find();

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


        //获取去专题id
        $subject_id = Subject::find()
            ->select(['id'])
            ->where(['name'=>$this->subject])
            ->scalar();

        if (!$subject_id){
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            //'id' => $this->id,
            'subject_id' => $subject_id,
            //'created_by' => $this->created_by,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
        ]);

        //$query->andFilterWhere(['subject_id', $subject_id]);

        return $dataProvider;
    }
}
