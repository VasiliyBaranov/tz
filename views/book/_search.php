<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\BookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-search">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => ['class' => 'form-inline'],
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'author_id')->dropDownList(
            ArrayHelper::map($authors, 'author_id', 'name'),[
                'prompt' => 'Select...'
            ]
        ) ?>

        <?= $form->field($model, 'name') ?>
        <br/>

        <?= $form->field($model, 'date_from')->widget(MaskedInput::className(),[
            'mask' => '99-99-9999',
        ]) ?>
        <?= $form->field($model, 'date_to')->widget(MaskedInput::className(),[
            'mask' => '99-99-9999',
        ]) ?>
        <br/>

        <div class="form-group">
            <?= Html::submitButton('Искать', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Сброс',\yii\helpers\Url::toRoute('index'),[
                'class' => 'btn btn-default'
            ]) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
