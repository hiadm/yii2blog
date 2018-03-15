<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tag`.
 */
class m180315_080102_create_tag_table extends Migration
{
    const TABLE_NAME = '{{%tag}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'name' => $this->string(15)->notNull()->defaultValue('')->comment('标签名'),
            'subject_id' => $this->integer()->notNull()->defaultValue(0)->comment('所属专题'),
            'created_by' => $this->integer()->notNull()->defaultValue(0)->comment('创建者'),
            'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->defaultValue(0)->comment('更新时间'),
        ], $tableOptions);

        $this->createIndex(
            'key_name',
            self::TABLE_NAME,
            'name'
        );

        $this->createIndex(
            'key_created_by',
            self::TABLE_NAME,
            'created_by'
        );
        $this->createIndex(
            'key_created_at',
            self::TABLE_NAME,
            'created_at'
        );
        $this->createIndex(
            'key_subject_id',
            self::TABLE_NAME,
            'subject_id'
        );
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
