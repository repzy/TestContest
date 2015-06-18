<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use app\models\LoginForm;
use app\models\Advertisement;
use app\models\Author;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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

    /**
     * Lists all Advertisement models.
     * @param string $sort
     * @return mixed
     */
    public function actionIndex($sort = 'SORT_ASC')
    {
        $sort = $sort == 'SORT_ASC' ? SORT_ASC : SORT_DESC;

        $dataProvider = new ActiveDataProvider([
            'query' => Advertisement::find(),
            'pagination' => [
                'pageSize' => 1,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => $sort,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Advertisement model.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Advertisement();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->image = $model->imageFile->baseName . '.' . $model->imageFile->extension;

            $author = Author::findOne(['ip' => Yii::$app->request->userIP]);

            if (null == $author) {
                $author = new Author();
                $author->save();
                $model->link('author', $author);
            }

            $model->author_id = $author->id;

            if ($model->save() && $model->upload() ) {

                return $this->redirect('index');
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}