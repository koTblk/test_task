<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property int $cnt_id
 * @property string $cnt_code
 * @property string $cnt_title
 * @property string $cnt_created
 *
 * @property Numbers[] $numbers
 * @property SendLogAggregated[] $sendLogAggregateds
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cnt_created'], 'required'],
            [['cnt_created'], 'safe'],
            [['cnt_code', 'cnt_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cnt_id' => 'Cnt ID',
            'cnt_code' => 'Cnt Code',
            'cnt_title' => 'Cnt Title',
            'cnt_created' => 'Cnt Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumbers()
    {
        return $this->hasMany(Numbers::className(), ['cnt_id' => 'cnt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendLogAggregateds()
    {
        return $this->hasMany(SendLogAggregated::className(), ['cnt_id' => 'cnt_id']);
    }
}
