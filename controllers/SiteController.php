<?php

namespace app\controllers;

use app\models\Article;
use app\models\Category;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $data = Article::getAll(5);
        $categories = Category::getAll();

        return $this->render('index',[
            'articles'=>$data['articles'],
            'pagination'=>$data['pagination'],
            'categories'=>$categories
        ]);
    }

    public function actionView($id)
    {
        $article = Article::findOne($id);
        $categories = Category::getAll();

        return $this->render('single',[
            'article'=>$article,
            'categories'=>$categories,

        ]);
    }

    public function actionCategory($id)
    {

        $data = Category::getArticlesByCategory($id);
        $categories = Category::getAll();

        return $this->render('category',[
            'articles'=>$data['articles'],
            'pagination'=>$data['pagination'],
            'categories'=>$categories
        ]);
    }


    /**
     * Displays contact page.
     *
     * @return Response|string
     */




    public function actionUsers()
    {
        return $this->render('users');
    }
}
