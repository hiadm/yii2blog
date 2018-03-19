<?php

namespace backend\models;

use Yii;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $isvip vip
 * @property int $created_at
 * @property int $updated_at
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password;
    const BACKEND_PERMISSION = 'author';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email','isvip'], 'required'],
            [['updated_at'], 'default', 'value' => time()],

            [['password'], 'filter', 'filter'=>'trim'],
            [['password'], 'safe'],

            [['email'], 'email'],
            [['email'], 'unique'],
            [['email'], 'string', 'max' => 255],

            [['isvip'], 'in', 'range' => [0, 1]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => '密码',
            'email' => '邮箱',
            'isvip' => 'VIP',
        ];
    }

    /**
     * 更新用户
     */
    public function renew(){
        if (!$this->validate()) {
            return null;
        }
        //是否重设密码
        if (!empty($this->password)){
            $this->setPassword($this->password);
        }

        return $this->save(false);
    }


    /**
     * 为model的password_hash字段生成密码的hash值
     *
     * @param string $password
     */
    public function setPassword($password){
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * 生成 "remember me" 认证key
     */
    public function generateAuthKey(){
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * 生成找回密码token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }


    /**
     * @param string $password #密码
     * @return bool #成功返回true 否则返回false
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * 根据user表的username获取用户
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public static function findByUsernameOrEmail($login)
    {
        return static::find()->where(['or', 'username = "' . $login . '"', 'email = "' . $login . '"'])
            //->andWhere(['blocked_at' => null])
            ->one();
    }

    /**
     * 是否后台用户
     * @return bool
     */
    public function getIsAdmin()
    {
        $auth = Yii::$app->getAuthManager();
        $backend = Yii::$app->getAuthManager()->checkAccess($this->getId(), self::BACKEND_PERMISSION);
        return ($auth  && $backend);

    }



    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
}
