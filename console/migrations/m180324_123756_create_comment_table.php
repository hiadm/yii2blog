<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 */
class m180324_123756_create_comment_table extends Migration
{
    const TABLE_NAME = '{{%comment}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'user_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('用户id'),
            'article_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('文章id'),
            'content' => $this->text()->notNull()->comment('评论内容'),
            'likes' => $this->integer()->notNull()->defaultValue(0)->comment('喜欢'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('收藏时间'),
        ], $tableOptions);

        $this->createIndex(
            'key_user_id',
            self::TABLE_NAME,
            ['user_id']
        );

        $this->createIndex(
            'key_article_id',
            self::TABLE_NAME,
            ['article_id']
        );

        $this->createIndex(
            'key_created_at',
            self::TABLE_NAME,
            'created_at'
        );
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
