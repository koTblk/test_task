<?php

use yii\db\Migration;

/**
 * Class m180621_151020_struct
 */
class m180621_151020_struct extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'usr_id'        => $this->primaryKey(),
            'usr_name'      => $this->string(255)->defaultValue(null),
            'usr_active'    => $this->smallInteger(1)->defaultValue(1),
            'usr_created'   => $this->dateTime() . ' DEFAULT NOW()'
        ]);

        $this->createTable('countries', [
            'cnt_id'        => $this->primaryKey(),
            'cnt_code'      => $this->string(255)->defaultValue(null),
            'cnt_title'     => $this->string(255)->defaultValue(null),
            'cnt_created'   => $this->dateTime() . ' DEFAULT NOW()'
        ]);

        $this->createTable('numbers', [
            'num_id'        => $this->primaryKey(),
            'cnt_id'        => $this->integer(11),
            'num_number'    => $this->integer(11),
            'num_created'   => $this->dateTime() . ' DEFAULT NOW()'
        ]);

        $this->createTable('send_log', [
            'log_id'        => $this->primaryKey(),
            'usr_id'        => $this->integer(11)->notNull(),
            'num_id'        => $this->integer(11)->notNull(),
            'log_message'   => $this->string(255)->defaultValue(null),
            'log_success'   => $this->tinyInteger(1)->defaultValue(null),
            'log_created'   => $this->dateTime() . ' DEFAULT NOW()'
        ]);

        $this->addForeignKey(
            'NumCntId_to_CntCntId',
            '{{%numbers}}',
            'cnt_id',
            '{{%countries}}',
            'cnt_id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'LogUsrId_to_UsrUsrId',
            '{{%send_log}}',
            'usr_id',
            '{{%users}}',
            'usr_id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'LogNumId_to_NumNumId',
            '{{%send_log}}',
            'num_id',
            '{{%numbers}}',
            'num_id',
            'CASCADE',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180621_151020_struct cannot be reverted.\n";

        return false;
    }

}
