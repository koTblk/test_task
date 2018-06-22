<?php
namespace app\commands;

use app\models\SendLog;
use app\models\SendLogAggregated;
use yii\console\Controller;
use yii\db\Exception;
use yii\db\Expression;

/**
 * Class CronController
 * @package app\commands
 */
class CronController extends Controller
{
    public function actionEveryDay()
    {
        $dataPerDay = SendLog::find()
            ->select(['date' => 'date(log_created)',
                      'log_failed_count'  => 'count(case When send_log.log_success = 0 Then send_log.log_success End)',
                      'log_success_count' => 'sum(log_success)',
                       'cnt_id'        => 'numbers.cnt_id',
                       'usr_id'        => 'usr_id'])
            ->leftJoin('numbers','send_log.num_id = numbers.num_id')
            ->where(['date(log_created)' => new Expression('date(NOW() - INTERVAL 1 DAY)')])
            ->groupBy([new Expression('date(log_created)'),  'numbers.cnt_id', 'usr_id'])
            ->asArray()->all();



        $transaction = SendLogAggregated::getDb()->beginTransaction();
        foreach ($dataPerDay as $one)
        {
            $model = new SendLogAggregated();
            try {
                $model->usr_id = $one['usr_id'];
                $model->cnt_id = $one['cnt_id'];
                $model->date = $one['date'];
                $model->log_failed_count = $one['log_failed_count'];
                $model->log_success_count = $one['log_success_count'];
                $model->save();

            } catch (Exception $e) {
                $transaction->rollBack();
            } catch (\Throwable $e) {
                $transaction->rollBack();
            }
        }

        try {
            SendLog::deleteAll(['date(log_created)' => new Expression('date(NOW() - INTERVAL 1 DAY)')]);
        } catch (Exception $e) {
            $transaction->rollBack();
        }

        $transaction->commit();

        return 0;
    }

}
