<?php

use yii\db\Migration;

/**
 * Class m180317_074845_user_add_isvip_column
 */
class m180317_074845_user_add_isvip_column extends Migration
{
    const TABLE_NAME = 'user';

    /**
     * {@inheritdoc}
     */
    /*public function safeUp()
    {

    }*/

    /**
     * {@inheritdoc}
     */
    /*public function safeDown()
    {
        echo "m180317_074845_user_add_isvip_column cannot be reverted.\n";

        return false;
    }*/


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn(self::TABLE_NAME,'isvip',$this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('vip')->after('status'));
        $this->addColumn(self::TABLE_NAME,'photo',$this->string(64)->notNull()->defaultValue('')->comment('头像')->after('isvip'));
    }

    public function down()
    {
        $this->dropColumn(self::TABLE_NAME, 'isvip');
        $this->dropColumn(self::TABLE_NAME, 'photo');
    }

}
