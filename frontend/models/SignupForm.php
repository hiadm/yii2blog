<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $re_password;
    public $captcha;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '该用户名已经存在.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '该邮箱已经被占用.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['re_password', 'required'],
            ['re_password', 'compare', 'compareAttribute' => 'password','message'=>'两次密码不一致'],

            [['captcha'], 'required'],
            [['captcha'], 'validateCaptcha'],
        ];
    }

    /**
     * 验证邮箱验证码
     */
    public function validateCaptcha($attribute){
        if(!$this->hasErrors()){
            //获取session 验证码
            $session = Yii::$app->session;
            $captchaInfo = $session->get('emailCaptcha');

            //验证时间
            if (
				empty($captchaInfo) || 
				((time() - $captchaInfo['timeout']) > 300) ||
				($captchaInfo['captcha'] !== $this->$attribute)
			){
                $this->addError($attribute, '验证码错误。');
            }
        }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'email' => '邮箱',
            'password' => '密码',
            're_password' => '重复密码',
            'captcha' => '邮箱验证码'

        ];
    }
}
