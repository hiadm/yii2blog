<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%friend}}".
 *
 * @property string $id 主键
 * @property string $name 站点名称
 * @property string $url 站点地址
 * @property int $sort 排序
 */
class Friend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%friend}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','url'], 'required'],
            [['name'], 'string', 'max' => 15],
            [['url'], 'string', 'max' => 64],
            [['url'], 'url', 'defaultScheme' => 'http'],
            [['sort'], 'string', 'max' => 3],
            [['sort'], 'default', 'value' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'name' => '站点名称',
            'url' => '站点地址',
            'sort' => '排序',
        ];
    }
}
