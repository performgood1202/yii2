<?php

namespace app\controllers;
use yii\web\Controller;
use app\models\User;
use Yii;
use yii\helpers\Url;
use app\models\AdminAccessFilter;

class AdminController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AdminAccessFilter::class,
            ],
        ];
    }
    public function actionIndex()
    {
        $users = User::find()->andWhere(['not', ['role' => 'admin']])->all();
         return $this->render('index', [
            'users' => $users,
        ]);
    }
    public function actionManagerRegister()
    {

        return $this->render('manager-register');
    }

}
