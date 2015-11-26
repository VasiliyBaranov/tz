<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'name')->textInput() ?>

        <?= $form->field($model, 'preview',[
            'template' => '{label} {hint} {input} {error}',
        ])
            ->fileInput()
            ->hint($model->preview?'<img src="'.Yii::getAlias(Yii::$app->params['previewUrlPath']).'/'.$model->preview.'"/><br/>filename: '.$model->preview:''); ?>

        <?= $form->field($model, 'date')->widget(MaskedInput::className(),[
            'mask' => '99-99-9999',
        ]) ?>

        <?= $form->field($model, 'author_id')->dropDownList(
            ArrayHelper::map($authors, 'author_id', 'name'),[
                'prompt' => 'Select...'
            ]
        ) ?>

        <div class="form-group">
            <?= Html::a('Back', $back_url, ['class' => 'btn btn-default']) ?>
            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
