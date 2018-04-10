<?php

use yii\db\Migration;

/**
 * Handles the creation of table `content`.
 */
class m180315_133849_create_content_table extends Migration
{
    const TABLE_NAME = '{{%content}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键ID'),
            'content' => $this->text()->notNull()->comment('文章内容'),
        ], $tableOptions);


    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
