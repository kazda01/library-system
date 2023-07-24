<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

/** @var app\models\User $user */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<?= Yii::t('app', 'Request password reset') ?>

<?= Yii::t('app', 'Hello {name},<br> someone requested a password reset and entered your email address correctly. If you did not request this password reset, you can ignore this email.', ['name' => '<b>' . Html::encode($user->username) . '</b>']) ?>

<?= Yii::t('app', 'Follow the <b>link</b> below to reset your password:') ?><br>
<?= $resetLink ?>
