<?php

namespace app\controllers;


use app\models\SingupForm;
use app\models\User;
use yii\web\Controller;
use yii\web\Response;

use app\models\LoginForm;


class AuthController extends Controller
{
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }

public function actionSingup()
{
 $model = new SingupForm();
 return $this->render('singup', ['model'=>$model]);
}
}
