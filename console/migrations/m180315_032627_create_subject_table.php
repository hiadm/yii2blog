<?php

use yii\db\Migration;

/**
 * Handles the creation of table `subject`.
 */
class m180315_032627_create_subject_table extends Migration
{
    const TABLE_NAME = '{{%subject}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'name' => $this->string(18)->notNull()->unique()->comment('专题名'),
            'desc' => $this->string(128)->notNull()->defaultValue('')->comment('描述'),
            'logo' => $this->string(64)->notNull()->defaultValue('')->comment('Logo'),
            'type' => $this->tinyInteger()->notNull()->defaultValue(0)->comment('类型'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0)->comment('状态'),
            'notice_id' => $this->integer()->notNull()->defaultValue(0)->comment('布告'),
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
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
