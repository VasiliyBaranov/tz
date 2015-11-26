<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = 'Редактирование: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Библиотека', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;

?>

<div class="book-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'authors' => $authors,
        'back_url' => $back_url,
    ]) ?>

</div>
