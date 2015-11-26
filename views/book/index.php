<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Библиотека';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search', [
        'model' => $searchModel,
        'authors' => $authors,
    ]); ?>

    <br/>
    <p>
        <?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'book_id',
            'name',
            [
                'attribute' => 'preview',
                'value' => function($model){
                    $src_th = $model->preview?Yii::getAlias(Yii::$app->params['previewUrlPath']).'/th_'.$model->preview:Yii::$app->params['webPath'].'/images/th_no_image.png';
                    $src= $model->preview?Yii::getAlias(Yii::$app->params['previewUrlPath']).'/'.$model->preview:Yii::$app->params['webPath'].'/images/no_image.png';
                    return Html::a('<img src="'.$src_th.'" />', $src, [
                        'class' => 'btn-preview-show',
                    ]);
                },
                'format' => 'html',
            ],
            'author.name',
            [
                'attribute' => 'date',
                'value' => function($model){
                    return date('d', $model->date).' '.Yii::$app->params['russianMonths'][date('M', $model->date)].' '.date('Y', $model->date);
                },
            ],
            [
                'attribute' => 'date_create',
                'value' => function($model){
                    return date('d', $model->date_create).' '.Yii::$app->params['russianMonths'][date('M', $model->date_create)].' '.date('Y', $model->date_create);
                },
            ],
            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model){
                        $get_parameters = '';
                        if(Yii::$app->request->get('BookSearch')){
                            foreach(Yii::$app->request->get('BookSearch') as $key => $val){
                                $get_parameters .= '&BookSearch['.$key.']='.$val;
                            }
                        }
                        if(Yii::$app->request->get('sort')){
                            $get_parameters .= ($get_parameters?'&':'').'sort='.Yii::$app->request->get('sort');
                        }
                        return Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $url.$get_parameters,
                            [
                                'title' => 'Редактировать',
                            ]);
                    },
                    'view' => function ($url, $model){
                        return Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', $url,
                            [
                                'class' => 'btn-view-show',
                                'data-id' => $model->book_id,
                                'title' => 'Просмотр',
                            ]);
                    },
                    'delete' => function ($url, $model){
                        return Html::a( '<span class="glyphicon glyphicon-trash"></span>', $url,
                            [
                                'title' => 'Удалить',
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>

<div class="modal fade modal-preview" id="preview-modal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade modal-view" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<?php
$this->registerJsFile(
    Yii::$app->params['webPath'].'/js/script.js',
    ['depends'=>'app\assets\AppAsset']
);
?>