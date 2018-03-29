<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%seo}}".
 *
 * @property int $id
 * @property string $keyword 关键字
 * @property string $description 描述
 * @property string $fastchannel 快速通道
 */
class Seo extends \yii\db\ActiveRecord
{
    public $quicks = []; //快速通道
    public $follows = []; //关注我

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max'=>5],
            [['logo', 'keywords', 'description', 'about'], 'string', 'max' => 255],
            [['fastchannel','followme'], 'string'],
        ];
    }


    //行为
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => null,
            ],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '站点名称',
            'keywords' => '关键字',
            'description' => '描述',
            'fastchannel' => '快速通道',
            'logo' => 'logo',
            'about' => '关于我'
        ];
    }

    /**
     * 保存
     */
    public function store(){
        //快速通道
        $quicks = Yii::$app->request->post('quicks');
        $this->fastchannel = serialize(self::operateArr($quicks, 5));

        //关注我
        $follows = Yii::$app->request->post('follows');
        $this->followme = serialize(self::operateArr($follows, 3));



        return $this->save();
    }

    /**
     * 处理快捷通道
     */
    public static function operateArr($arrs, $degree){
        $tmp = [];
        $num = 0;
        foreach ($arrs['name'] as $k => $arr){
            if ($num >= $degree)
                break;

            if(!empty($arrs['name'][$k]) && !empty($arrs['url'][$k])){
                $tmp[$num]['name'] = $arrs['name'][$k];
                $tmp[$num]['url'] = $arrs['url'][$k];

                $num++;
            }
        }
        return $tmp;
    }
}
