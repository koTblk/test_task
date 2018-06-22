<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "send_log_aggregated".
 *
 * @property string $dateFrom
 * @property string $dateTo
 * @property int $log_success_count
 * @property int $log_failed_count
 * @property int $cnt_id
 * @property int $usr_id
 *
 * @property Countries $cnt
 * @property Users $usr
 */
class SendLogAggregatedSearch extends SendLogAggregated
{
    public $dateFrom;
    public $dateTo;
    public $user;
    public $country;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dateFrom', 'dateTo'], 'required'],
            [['user','country'], 'safe'],
            [['log_success_count', 'log_failed_count', 'cnt_id', 'usr_id'], 'integer'],
            [['cnt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['cnt_id' => 'cnt_id']],
            [['usr_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['usr_id' => 'usr_id']],
        ];
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return Users::findOne(['usr_id' => $this->usr_id])->usr_name;
    }

    /**
     * @return string
     */
    public function getCountryName()
    {
        return Countries::findOne(['cnt_id' => $this->cnt_id])->cnt_title;
    }


    /**
     * @return ActiveDataProvider
     */
    public  function search()
    {
        $select = [
            'date'              =>'date',
            'log_success_count' => 'sum(log_success_count)',
            'log_failed_count'  => 'sum(log_failed_count)'];
        $query = $this::find()
            ->where(['>=', 'date', $this->dateFrom])
            ->andWhere(['<=','date', $this->dateTo]);
        if ($this->user)
        {
            $select+=['usr_id'  => 'usr_id'];
            $query->andWhere(['in','usr_id',$this->user]);
            $query->groupBy(['usr_id']);
        }
        if ($this->country)
        {
            $select+=['cnt_id'  => 'cnt_id'];
            $query->andWhere(['in','cnt_id',$this->country]);
            $query->groupBy(['cnt_id']);
        }

        $query->select($select);
        $query->groupBy(['date']);
        $query->orderBy(['date' => SORT_DESC]);
        return new ActiveDataProvider([
            'query' => $query,
            'sort'  => false
        ]);
    }

}
