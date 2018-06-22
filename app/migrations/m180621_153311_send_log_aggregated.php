<?php

use yii\db\Migration;

/**
 * Class m180621_153311_send_log_aggregated
 */
class m180621_153311_send_log_aggregated extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('send_log_aggregated', [
            'date'                  => $this->date()->notNull(),
            'log_success_count'     => $this->integer(11)->defaultValue(null),
            'log_failed_count'      => $this->integer(11)->defaultValue(null),
            'cnt_id'                => $this->integer(11)->notNull(),
            'usr_id'                => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey(
            'UserUsrId_to_aggrUsrId',
            '{{%send_log_aggregated}}',
            'usr_id',
            '{{%users}}',
            'usr_id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'CountryCntId_to_AggrCntId',
            '{{%send_log_aggregated}}',
            'cnt_id',
            '{{%countries}}',
            'cnt_id',
            'CASCADE',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180621_153311_send_log_aggregated cannot be reverted.\n";

        return false;
    }

}
