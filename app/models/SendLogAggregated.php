<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "send_log_aggregated".
 *
 * @property string $date
 * @property int $log_success_count
 * @property int $log_failed_count
 * @property int $cnt_id
 * @property int $usr_id
 *
 * @property Countries $cnt
 * @property Users $usr
 */
class SendLogAggregated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'send_log_aggregated';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'cnt_id', 'usr_id'], 'required'],
            [['date'], 'safe'],
            [['log_success_count', 'log_failed_count', 'cnt_id', 'usr_id'], 'integer'],
            [['cnt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['cnt_id' => 'cnt_id']],
            [['usr_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['usr_id' => 'usr_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Date',
            'log_success_count' => 'Log Success Count',
            'log_failed_count' => 'Log Failed Count',
            'cnt_id' => 'Cnt ID',
            'usr_id' => 'Usr ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCnt()
    {
        return $this->hasOne(Countries::className(), ['cnt_id' => 'cnt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsr()
    {
        return $this->hasOne(Users::className(), ['usr_id' => 'usr_id']);
    }

}
