<?php

namespace app\controllers;

use app\models\RegisterForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['logout'],
//                'rules' => [
//                    [
//                        'actions' => ['logout'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        $message = 'Error '.$exception->statusCode.': '.$exception->getMessage();
        if(\Yii::$app->user->isGuest){
            return $this->redirect(Url::toRoute('/site/login'));
        }else{
            if ($exception !== null) {
                return $this->render('error', ['message' => $message]);
            }
        }
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegister()
    {
        if(!Yii::$app->user->isGuest){
            return $this->redirect(Url::toRoute('/site/index'));
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post())) {
            $user = $model->register();
            if($user){
                $login = new LoginForm();
                $login->username = $model->username;
                $login->password = $model->password;
                $login->login();

                echo '<pre>';
                print_r($login);
                echo '</pre>';
                die();
            }
            return $this->goHome();
        }
        return $this->render('register', [
            'model' => $model
        ]);
    }

}
