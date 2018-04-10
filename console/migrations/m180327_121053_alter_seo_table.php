<?php

use yii\db\Migration;

/**
 * Class m180327_121053_alter_seo_table
 */
class m180327_121053_alter_seo_table extends Migration
{
    const TABLE_NAME = '{{%seo}}';

    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, 'about', $this->string()->notNull()->defaultValue('')->comment('关于我'));
        $this->addColumn(self::TABLE_NAME, 'followme', $this->text()->notNull()->comment('关注我'));
        $this->addColumn(self::TABLE_NAME, 'updated_at', $this->integer()->notNull()->defaultValue(0)->comment('修改时间'));
        $this->addColumn(self::TABLE_NAME, 'keywords', $this->string()->notNull()->defaultValue('')->comment('关键字'));

        $this->alterColumn(self::TABLE_NAME, 'fastchannel', $this->text()->notNull()->comment('快速通道'));

        $this->dropColumn(self::TABLE_NAME, 'keyword');

    }

    public function safeDown()
    {
        $this->dropColumn(self::TABLE_NAME, 'about');
        $this->dropColumn(self::TABLE_NAME, 'followme');
        $this->dropColumn(self::TABLE_NAME, 'keywords');
        $this->dropColumn(self::TABLE_NAME, 'updated_at');

        $this->alterColumn(self::TABLE_NAME, 'fastchannel', $this->string()->notNull()->defaultValue('')->comment('快速通道'));

        $this->addColumn(self::TABLE_NAME, 'keyword', $this->string()->notNull()->defaultValue('')->comment('关键字'));

        /*echo "m180327_121053_alter_seo_table cannot be reverted.\n";

        return false;*/
    }
}
