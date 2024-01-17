<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use yii\helpers\Url;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
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
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }else{
            if(Yii::$app->user->identity->role == "admin"){
                return $this->redirect(Url::base(true)."/admin");
            }else if(Yii::$app->user->identity->role == "manager"){
                return $this->redirect(Url::base(true)."/manager");
            }else{
               return $this->render('index'); 
            }
            
        }
        
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        return $this->render('register');
    }
    public function actionSignUp()
    {

        $session = Yii::$app->session;
        $request = Yii::$app->request->post();

        $is_admin = false;
        if(isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role == "admin" && isset($request["action"]) && $request["action"] == "add_manager"){
            $is_admin = true;
           
        }

        if($request["password"] != $request["confirm-password"]){
            $session->setFlash('dataReturn', $request);
            $session->setFlash('errorMessage','Password not match!');
            if($is_admin){
                 return $this->redirect(['admin/manager-register']);
            }else{
                 return $this->redirect(['site/register']);

            }
        }

        //echo "<pre>"; print_r($request); die;

        $user = new User();
        $user->name = $request["name"];
        $user->email = $request["email"];
        $user->attributes = $request;
        $user->password = $request["password"];
        if(!$user->validate())
        {
            $session->setFlash('dataReturn', $request);
            $session->setFlash('errorMessages', $user->getErrors());
            if($is_admin){
                 return $this->redirect(['admin/manager-register']);
            }else{
                 return $this->redirect(['site/register']);

            }
        }
        if($is_admin){
             $user->role = "manager";
        }
        //echo "<pre>"; print_r(Yii::$app->user); die;
       // echo Yii::$app->user->identity->role; die;
        

        $user->password = Yii::$app->getSecurity()->generatePasswordHash($request["password"]);//Hash password before storing to DB
        
       
        if($user->validate() && $user->save())
        {
            $session->setFlash('successMessage', 'Registration successful...');
            if($is_admin){
                 return $this->redirect(['/admin']);
            }else{
                 return $this->redirect(['site/login']);

            }
            
        }

        $session->setFlash('errorMessages', $user->getErrors());
        $session->setFlash('dataReturn', $request);
        if($is_admin){
             return $this->redirect(['admin/manager-register']);
        }else{
             return $this->redirect(['site/register']);

        }
       
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
       // die("dfkdjfkdf");
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
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
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
