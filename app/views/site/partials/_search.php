<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SendLogAggregated */
/* @var $form ActiveForm */
?>
<div class="col-xs-4">
<div class="search">
    <?php $form = ActiveForm::begin(['method' => 'post']); ?>

        <?= $form->field($model, 'dateFrom')->widget(\dosamigos\datepicker\DatePicker::className(),
            [
                'model' => $model,
                'attribute' => 'dateFrom',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]) ?>

        <?= $form->field($model, 'dateTo')->widget(\dosamigos\datepicker\DatePicker::className(),
        [
                'model' => $model,
                'attribute' => 'dateTo',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
            ]
        ]) ?>

        <?= $form->field($model, 'user')->widget(\dosamigos\multiselect\MultiSelect::className(),[
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Users::find()->all(),'usr_id','usr_name'),
                'options' => ['multiple'=>"multiple"]
        ])  ?>

        <?= $form->field($model, 'country')->widget(\dosamigos\multiselect\MultiSelect::className(),[
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Countries::find()->all(),'cnt_id','cnt_title'),
                'options' => ['multiple'=>"multiple"]
        ])  ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
</div><!-- _search -->
