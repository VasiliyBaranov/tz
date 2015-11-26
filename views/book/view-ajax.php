<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'book_id',
        'name',
        [
            'attribute' => 'preview',
            'value' => $model->preview?Yii::getAlias(Yii::$app->params['previewUrlPath']).'/'.$model->preview:Yii::$app->params['webPath'].'/images/no_image.png',
            'format' => 'image',
        ],
        [
            'attribute' => 'author_id',
            'value' => $model->author->name,
        ],
        [
            'attribute' => 'date',
            'value' => date('d', $model->date).' '.Yii::$app->params['russianMonths'][date('M', $model->date)].' '.date('Y', $model->date),
        ],
        [
            'attribute' => 'date_create',
            'value' => date('d', $model->date_create).' '.Yii::$app->params['russianMonths'][date('M', $model->date_create)].' '.date('Y', $model->date_create),
        ],
        [
            'attribute' => 'date_update',
            'value' => date('d', $model->date_update).' '.Yii::$app->params['russianMonths'][date('M', $model->date_update)].' '.date('Y', $model->date_update),
        ],
    ],
]) ?>