<?php

use yii\db\Migration;

/**
 * Class m180323_094227_alter_user_table
 */
class m180323_094227_alter_user_table extends Migration
{
    const TABLE_NAME = '{{%user}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, 'sponsor', $this->string(125)->notNull()->defaultValue('')->comment('赞助码'));
        $this->addColumn(self::TABLE_NAME, 'joinvip_at', $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('加入会员时间'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE_NAME, 'sponsor');
        $this->dropColumn(self::TABLE_NAME, 'joinvip_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180323_094227_alter_user_table cannot be reverted.\n";

        return false;
    }
    */
}
