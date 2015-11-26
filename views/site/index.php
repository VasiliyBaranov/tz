<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Библиотека';
?>
<div class="site-index">

    <h1>Библиотека</h1>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-8">
                <?php if(Yii::$app->user->isGuest){ ?>
                    Для того чтобы получить доступ в библиотеку нобходимо <?= Html::a('авторизоваться', Url::toroute('site/login')) ?> или <?= Html::a('зарегистрироваться', Url::toroute('site/register')) ?>
                <?php }else{ ?>
                    Перейти в <?= Html::a('библиотеку', Url::toroute('book/index')) ?>
                <?php } ?>
            </div>
        </div>

    </div>
</div>
