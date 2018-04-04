<?php
namespace frontend\modules\user\models;
use common\components\Helper;
use common\models\User;
use yii\base\Model;
use Yii;

class Setting extends Model
{
    public $password;
    public $new_password;
    public $re_new_password;

    public $email;
    public $captcha;

    public $photo;

    const RESET_PASSOWRD = 'reset_password';
    const RESET_EMAIL = 'reset_email';
    const SET_PHOTO = 'set_photo';

    public $_user;

    public function rules()
    {
        return [
            ['password','required','on'=>[self::RESET_PASSOWRD,self::RESET_EMAIL]],
            ['password', 'validatePassword','on'=>[self::RESET_PASSOWRD,self::RESET_EMAIL]],

            ['new_password', 'required','on'=>[self::RESET_PASSOWRD]],
            ['new_password', 'string', 'min'=>6,'on'=>[self::RESET_PASSOWRD]],
            ['re_new_password','compare','compareAttribute'=>'new_password','on'=>[self::RESET_PASSOWRD]],

            ['email', 'required','on'=>[self::RESET_EMAIL]],
            ['email', 'email','on'=>[self::RESET_EMAIL]],
            ['email', 'unique', 'targetClass' => User::className(), 'targetAttribute' => 'email','on'=>[self::RESET_EMAIL]],
            ['captcha', 'validateCaptcha','on'=>[self::RESET_EMAIL]],

            ['photo','required','on'=>[self::SET_PHOTO]],
            ['photo', 'string', 'max'=>64,'on'=>[self::SET_PHOTO]]
        ];
    }

    public function validateCaptcha($attribute){
        if (!$this->hasErrors()){
            //获取session 验证码
            $session = Yii::$app->session;
            $captchaInfo = $session->get('emailCaptcha');

            //验证时间
            if ((time() - $captchaInfo['timeout']) > 300){
                $this->addError($attribute, '验证码已超时。');
            }

            if($captchaInfo['captcha'] !== $this->$attribute){
                $this->addError($attribute, '验证码错误。');
            }
        }
    }

    public function validatePassword($attribute){
        if (!$this->hasErrors()){
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->$attribute))
                $this->addError($attribute, '密码不正确。');
        }
    }


    public function attributeLabels()
    {
        return [
            'password' => '密码',
            'new_password' => '新密码',
            're_new_password' => '重复密码',
            'photo' => '头像',
            'email' => '邮箱',
        ];
    }

    public function store(){
        if($this->validate()){
            //保存数据
            $user = $this->getUser();
            $user->setPassword($this->new_password);

            return $user->save(false);
        }
        return false;
    }

    public function storeEmail(){
        if($this->validate()){
            //保存数据
            $user = $this->getUser();
            $user->email = $this->email;

            return $user->save(false);
        }
        return false;
    }

    public function savePhoto(){
        if (!$this->validate()){
            return false;
        }
        $user = $this->getUser();
        $user->photo = Helper::thumbImage($this->photo, 150, 150);
//        $user->photo = $this->photo;

        //删除原有图片
        Helper::delImage($user->getOldAttribute('photo'));

        return $user->save(false);

    }


    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findIdentity(Yii::$app->user->getId());
        }

        return $this->_user;
    }
}