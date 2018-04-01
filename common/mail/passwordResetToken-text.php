<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['index/reset-password', 'token' => $user->password_reset_token]);
?>
你好 <?= $user->username ?>,

点击以下链接 可完成您的密码重置:

<?= $resetLink ?>
