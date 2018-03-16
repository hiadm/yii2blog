<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_tag`.
 */
class m180315_133825_create_article_tag_table extends Migration
{
    const TABLE_NAME = '{{%article_tag}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'article_id' => $this->integer()->notNull()->defaultValue(0)->comment('文章ID'),
            'tag_id' => $this->integer()->notNull()->defaultValue(0)->comment('标签ID'),
        ], $tableOptions);

        $this->createIndex(
            'key_article_id',
            self::TABLE_NAME,
            'article_id'
        );

        $this->createIndex(
            'key_tag_id',
            self::TABLE_NAME,
            'tag_id'
        );

    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
