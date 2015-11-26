<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Библиотека', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Назад', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->book_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->book_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

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

</div>
