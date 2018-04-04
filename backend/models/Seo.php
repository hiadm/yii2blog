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

    public $quicks_name = []; //quicks_name[]
    public $quicks_url = [];

    public $follows_name = [];
    public $follows_url = [];

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
            [['name'], 'required'],
            [['name'], 'string', 'max'=>5],
            [['logo', 'keywords', 'description', 'about'], 'string', 'max' => 255],
            ['quicks_url', 'each', 'rule' => ['url','defaultScheme' => 'http']],
            ['follows_url', 'each', 'rule' => ['url','defaultScheme' => 'http']],

            [['quicks_name','quicks_url','follows_name','follows_url'], 'safe']


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

        if(!$this->validate())
            return false;

        $this->fastchannel = serialize(self::operateArr([
            'name' => $this->quicks_name,
            'url'  => $this->quicks_url,
        ], 5));

        $this->followme = serialize(self::operateArr([
            'name' => $this->follows_name,
            'url' => $this->follows_url,
        ], 3));


        return $this->save(false);
    }

    /**
     * 处理快捷通道
     */
    public static function operateArr($arrs, $degree){
        $tmp = [];
        $num = 0;
        if(!empty($arrs['name']) && !empty($arrs['url'])){
            foreach ($arrs['name'] as $k => $arr){
                if ($num >= $degree)
                    break;

                if(!empty($arrs['name'][$k]) && !empty($arrs['url'][$k])){
                    $tmp[$num]['name'] = $arrs['name'][$k];
                    $tmp[$num]['url'] = $arrs['url'][$k];

                    $num++;
                }
            }
        }

        return $tmp;
    }
}
