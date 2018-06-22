

<?= $this->render('partials/_search', ['model' => $model]); ?>
<?php if ($dataProvider) : ?>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=> '{items}',
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn'],
                'date',
                'log_success_count',
                'log_failed_count',
                'userName',
                'countryName'
            ],
        ]); ?>
<?php endif; ?>