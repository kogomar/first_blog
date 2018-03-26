<?php

namespace app\controllers;

use app\models\Article;
use app\models\Category;
use app\models\User;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Profile;

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
                'only' => ['logout', 'profile'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['profile'],
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
        $data = User::getAllUsers(10);
        return $this->render('users',[
            'users'=>$data['user'],
            'pagination'=>$data['pagination']
                ]);
    }

    public function actionPromo($id)
    {
        $article = Article::findOne($id);
        $categories = Category::getAll();

        return $this->render('single',[
            'article'=>$article,
            'categories'=>$categories,

        ]);
    }
public function actionProfile()
{
    $model = ($model=Profile::findOne(Yii::$app->user->id)) ? $model : new Profile();
    if($model->load(Yii::$app->request->post()) && $model->validate() ):
        if($model->updateProfile()):
            Yii::$app->session->setFlash('success', 'Your profile is update');

    else:
        Yii::$app->session->setFlash('error', 'Your profile not update');
        Yii::error('Error');
        return $this->refresh();
        endif;
    endif;

    return $this->render('profile',['model'=>$model]);
}
}
