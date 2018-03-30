<?php
namespace frontend\controllers;

use frontend\models\Article;
use frontend\models\Subject;
use frontend\models\Friend;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
use frontend\models\LoginForm;
use frontend\models\SignupForm;
use Gregwar\Captcha\CaptchaBuilder;
use yii\web\Response;
use Gregwar\Captcha\PhraseBuilder;


class IndexController extends BaseController
{
    public $layout = 'layout2';


    /**
     * 前台首页
     */
    public function actionIndex(){
        $this->layout = 'layout';

        //获取首页专题列表
        $subjects = Subject::getActiveSubject();

        //获取首页精品文章 3个
        $bestArticle = Article::getIndexBest();

        //获取首页文章列表
        $articleData = Article::getArticle();

        //获取首页友情链接
        $friends = Friend::getFriends();
        //var_dump($friends);die;


        return $this->render('index',[
            'subjects' => $subjects,
            'bestArticle' => $bestArticle,
            'articles' => $articleData['articles'],
            'pagination' => $articleData['pagination'],
            'friends' => $friends,
        ]);
    }


    /**
     *
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
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

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    /**
     * 验证码
     */
    public function actionCaptcha()
    {
        //生成验证码图片的Builder对象，配置相应属性
        $phraseBuilder = new PhraseBuilder(4);
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->setBackgroundColor(255,255,255);
        //可以设置图片宽高及字体
        $builder->build($width = 150, $height = 55, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();

        //把内容存入session
        $session = Yii::$app->session;
        if (!$session->isActive){
            $session->open();
        }
        $session->set('phrase', $phrase);

        //生成图片
        $response = Yii::$app->getResponse();
        $response->headers->set('Content-Type', 'image/jpeg');
        $response->headers->set('Cache-Control', 'no-cache, must-revalidate');
        $response->format = Response::FORMAT_RAW;
        $response->data = $builder->output();
        return $response->send();

    }


    /**
     * 发送邮箱验证码
     */
    public function actionAjaxEmailCaptcha(){
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            $email = Yii::$app->request->post('mail');
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                return ['errcode'=>1, 'message' => '参数错误'];
            }

            //生成验证码
            $captcha = substr(uniqid(), -5);
            $session = Yii::$app->session;
            if (!$session->isActive){
                Yii::$app->session->open();

            }

            $captchaInfo['captcha'] = $captcha;
            $captchaInfo['timeout'] = time();
            $session->set('emailCaptcha', $captchaInfo);

            $siteInfo = $this->view->params['siteInfo']['name'];

            if(self::sendMail($email, $captcha, $siteInfo)){
                return ['errcode'=>0, 'message'=>'邮件已发送'];
            }
            else{
                return ['errcode'=>1, 'message'=>'邮件发送失败'];
            }


        }
        return false;
    }

    public static function sendMail ($email, $captcha ,$siteInfo)
    {

        $str = "您在 <strong>{$siteInfo}</strong> 注册的验证码是 - <strong>{$captcha}</strong> 五分钟之内有效。";

        $mail= Yii::$app->mailer->compose();
        $mail->setTo($email); //要发送给那个人的邮箱
        $mail->setSubject($siteInfo . ' - 注册验证'); //邮件主题
        $mail->setHtmlBody($str); //发布纯文字文本

        return $mail->send();
    }

}