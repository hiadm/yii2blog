<?php

use yii\db\Migration;

/**
 * Handles the creation of table `firend`.
 */
class m180329_130744_create_friend_table extends Migration
{
    const TABLE_NAME = '{{%friend}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'name' => $this->string(15)->notNull()->defaultValue('')->comment('站点名称'),
            'url' => $this->string(64)->notNull()->defaultValue('')->comment('站点地址'),
            'sort' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('排序'),
        ], $tableOptions);

        $this->createIndex(
            'key_sort',
            self::TABLE_NAME,
            ['sort']
        );


    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
