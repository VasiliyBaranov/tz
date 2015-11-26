<?php
namespace app\controllers;

use app\models\Author;
use app\models\Book;
use app\models\BookForm;
use app\models\BookSearch;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class BookController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        $actions = parent::actions();

        if(Yii::$app->user->isGuest){
            return $this->redirect(Url::toroute('site/login'));
        }
        return $actions;
    }
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'authors' => Author::find()->all(),
        ]);
    }
    public function actionView($id)
    {
        $model = Book::findOne($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    public function actionViewAjax($id)
    {
        $this->layout='/empty';
        $model = Book::findOne($id);
        return $this->render('view-ajax', [
            'model' => $model,
        ]);
    }
    public function actionCreate()
    {
        $model = new BookForm();

        $back_url = Url::toRoute('index');

        if ($model->load(Yii::$app->request->post()) && $model->insert()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'authors' => Author::find()->all(),
                'back_url' => $back_url,
            ]);
        }
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->isNewRecord = 0;
        $back_url = Url::toRoute('index');
        $get_parameters = '';
        if(Yii::$app->request->get('BookSearch')){
            foreach(Yii::$app->request->get('BookSearch') as $key => $val){
                $get_parameters .= '&BookSearch['.$key.']='.$val;
            }
        }
        if(Yii::$app->request->get('sort')){
            $get_parameters .= ($get_parameters?'&':'').'sort='.Yii::$app->request->get('sort');
        }

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            return $this->redirect($back_url.$get_parameters);
        } else {
            return $this->render('update', [
                'model' => $model,
                'authors' => Author::find()->all(),
                'back_url' => $back_url.$get_parameters,
            ]);
        }

    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(Url::toRoute('book/index'));
    }

    protected function findModel($id)
    {
        $model = new BookForm();

        if (($model->loadBook($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемой страницы не существует.');
        }
    }

}