<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $usr_id
 * @property string $usr_name
 * @property int $usr_active
 * @property string $usr_created
 *
 * @property SendLog[] $sendLogs
 * @property SendLogAggregated[] $sendLogAggregateds
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usr_active'], 'integer'],
            [['usr_created'], 'required'],
            [['usr_created'], 'safe'],
            [['usr_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usr_id' => 'Usr ID',
            'usr_name' => 'Usr Name',
            'usr_active' => 'Usr Active',
            'usr_created' => 'Usr Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendLogs()
    {
        return $this->hasMany(SendLog::className(), ['usr_id' => 'usr_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendLogAggregateds()
    {
        return $this->hasMany(SendLogAggregated::className(), ['usr_id' => 'usr_id']);
    }
}
