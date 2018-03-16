<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m180315_133907_create_article_table extends Migration
{
    const TABLE_NAME = '{{%article}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键ID'),
            'title' => $this->string(125)->notNull()->defaultValue('')->comment('文章标题'),
            'brief' => $this->string(225)->notNull()->defaultValue('')->comment('文章简介'),
            'smallimg' => $this->string('64')->notNull()->defaultValue('')->comment('文章图片'),
            'bigimg' => $this->string('64')->notNull()->defaultValue('')->comment('文章海报'),
            'favorite' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('喜欢数'),
            'collect' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('收藏数'),
            'visited' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('阅读数'),
            'type' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('文章类型'),
            'isbest' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('精品推荐'),
            'isdraft' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('草稿箱'),
            'isrecycle' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('回收站'),
            'subject_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('所属专题'),
            'content_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('内容ID'),
            'created_by' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('作者'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('更新时间'),

        ], $tableOptions);

        $this->createIndex(
            'key_subject_id',
            self::TABLE_NAME,
            'subject_id'
        );

        $this->createIndex(
            'key_content_id',
            self::TABLE_NAME,
            'content_id'
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
