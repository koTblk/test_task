<?php

namespace app\controllers;

use app\models\SendLogAggregatedSearch;
use yii\web\Controller;

class SiteController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SendLogAggregatedSearch();
        $searchModel->load(\Yii::$app->request->post());
        $dataProvider = $searchModel->search();
        return $this->render('index', ['dataProvider'   => $dataProvider, 'model' => $searchModel]);
    }

    /**
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('index');
    }
}
