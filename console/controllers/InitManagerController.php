<?php
namespace console\controllers;
use yii\console\Controller;
use common\models\User;

class InitManagerController extends Controller
{
    //初始化超级管理员
    public function actionManager(){

        $username = $this->prompt('username: ', ['require' => true, 'validator' => function($input, &$error) {
            if (strlen($input) < 5) {
                $error = 'The Pin must be Greater than or equal to 5 chars!';
                return false;
            }
            return true;
        }]);
        $password = $this->prompt('password: ', ['require' => true,'validator' => function($input, &$error) {
            if (strlen($input) < 6) {
                $error = 'The Pin must be Greater than or equal to 6 chars!';
                return false;
            }
            return true;
        }]);
        $email = $this->prompt('email: ', ['require' => true, 'validator' => function($input, &$error) {

            if (!filter_var($input, FILTER_VALIDATE_EMAIL))
            {
                $error = 'The Pin must be email!';
                return false;
            }
            return true;
        }]);

        $user = new User();

        $user->username = $username;
        $user->email = $email;

        $user->setPassword($password);
        $user->generateAuthKey();
        $user->generatePasswordResetToken();

        //保存数据
        if(!$user->save()){
            echo "创建管理员失败!\n";
            return Controller::EXIT_CODE_ERROR;
        }
        echo "创建管理员（{$username}）成功!\n";
        return Controller::EXIT_CODE_NORMAL;





    }
}