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
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use yii\base\InvalidParamException;
use frontend\models\ContactForm;


class IndexController extends BaseController
{
    public $layout = 'layout2';

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


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
                'only' => ['logout', 'signup', 'contact'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'contact'],
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

            try {
                self::sendMail($email, $captcha, $siteInfo);

                return ['errcode'=>0, 'message'=>'邮件已发送'];
            } catch(\Exception $e) {
                throw $e;
            } catch(\Throwable $e) {
                throw $e;
            }
            return ['errcode'=>1, 'message'=>'邮件发送失败'];

            /*if(self::sendMail($email, $captcha, $siteInfo)){
                return ['errcode'=>0, 'message'=>'邮件已发送'];
            }
            else{
                return ['errcode'=>1, 'message'=>'邮件发送失败'];
            }*/


        }
        return false;
    }

    public static function sendMail ($email, $captcha ,$siteInfo)
    {

        $str = "<p  style='font-size:18px;'>您在 <strong>{$siteInfo}</strong> 注册的验证码是 - <strong>{$captcha}</strong> - 五分钟之内有效。</p>";

        $mail= Yii::$app->mailer->compose();
        $mail->setTo($email); //要发送给那个人的邮箱
        $mail->setSubject($siteInfo . ' - 注册验证'); //邮件主题
        $mail->setHtmlBody($str); //发布纯文字文本

        return $mail->send();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('info', '检查您的电子邮件以作进一步操作。');

                return $this->redirect(['login']);
            } else {
                Yii::$app->session->setFlash('info', '对不起，我们无法为所提供的电子邮件地址重置密码。');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {

        try {
            $model = new ResetPasswordForm($token);

        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('info', '新密码已设置成功.');

            return $this->redirect(['login']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['supportEmail'])) {
                Yii::$app->session->setFlash('info', '感谢您联系我们。我们会尽快答复您的。');
            } else {
                Yii::$app->session->setFlash('info', '发送消息时出错。');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }


}