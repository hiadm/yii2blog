<?php

use yii\db\Migration;

/**
 * Handles the creation of table `seo`.
 */
class m180318_081239_create_seo_table extends Migration
{
    const TABLE_NAME = '{{%seo}}';

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull()->defaultValue('')->comment('关键字'),
            'keyword' => $this->string()->notNull()->defaultValue('')->comment('关键字'),
            'logo' => $this->string()->notNull()->defaultValue('')->comment('logo'),
            'description' => $this->string()->notNull()->defaultValue('')->comment('描述'),
            'fastchannel' => $this->string(64)->notNull()->defaultValue('')->comment('快速通道'),
        ], $tableOptions);

        //插入数据
        $this->insert(self::TABLE_NAME, [
            'id' => 1,
            'name' => 'Yii2blog',
            'keyword' => 'yii,blog',
            'description' => 'yii2小博客',
            'fastchannel' => '',
            'logo' => ''
        ]);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
