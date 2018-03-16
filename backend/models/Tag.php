<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property string $id 主键
 * @property string $name 标签名
 * @property int $subject_id 布告
 * @property int $created_by 创建者
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class Tag extends \yii\db\ActiveRecord
{
    //public $subject;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject_id', 'name'], 'required'],
            [['subject_id'], 'integer'],
            [['subject_id'], 'validTagsLimit'],
            [['name'], 'string', 'max' => 15],
            //[['subject'], 'string', 'max' => 18],
        ];
    }

    /**
     * 检测标签上限
     */
    public function validTagsLimit($attribute){
        if (!$this->hasErrors()){
            //检测是否已达上限
            $limit = Yii::$app->params['tagsLimit'];
            $total = self::find()->where(['subject_id'=>$this->subject_id])->count();
            if ($total >= $limit){
                $this->addError($attribute,'当前专题标签数量已达上限。');
            }
        }
    }


    /**
     * 行为
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => BlameableBehavior::className(),
                'updatedByAttribute' => null,
            ],
        ];
    }





    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'name' => '标签名',
            'subject_id' => '所属专题',
            'created_by' => '创建者',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            //'subject' => '搜索专题'
        ];
    }

    /**
     * 获取当前标签所属专题
     * @return array|null  #['id' => 'tag']
     */
    public function getCurrentSubject(){
        $subject = Subject::find()
            ->select(['name','id'])
            ->where(['id' => $this->subject_id])
            ->indexBy('id')
            ->column();

        return $subject;
    }

    /**
     * 新建标签 并 检测是否达到上限
     * @return bool #true or false
     */
    public function store(){
        if ($this->validate()){
            //检测是否重名
            $exist = self::find()
                ->where(['subject_id'=>$this->subject_id])
                ->andWhere(['name'=>$this->name])
                ->one();
            if ($exist){
                $this->id = $exist->id;
                return true;

            }

            //保存数据
            return $this->save(false);

        }
        return false;

    }

    /**
     * 检测是否可删除标签
     * @return bool #可删除true 否则返回false
     */
    public function canDelete(){
        //检测是否与文章关联
        $count = (new yii\db\Query)
            ->from('{{%article_tag}}')
            ->where(['tag_id'=>$this->id])
            ->count();

        if ($count)
            return false;
        return true;
    }
}
