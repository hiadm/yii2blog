<?php

namespace backend\models;

use Yii;

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
            [['logo', 'name', 'keyword', 'description', 'fastchannel'], 'string', 'max' => 255],
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
            'keyword' => '关键字',
            'description' => '描述',
            'fastchannel' => '快速通道',
            'logo' => 'logo'
        ];
    }
}
