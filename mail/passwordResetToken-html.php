<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\User $user */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<b><u><?= Yii::t('app', 'Request password reset') ?></u></b><br>
<br>
<?= Yii::t('app', 'Hello {name},<br> someone requested a password reset and entered your email address correctly. If you did not request this password reset, you can ignore this email.', ['name' => '<b>' . Html::encode($user->username) . '</b>']) ?><br>
<br>
<?= Yii::t('app', 'Follow the <b>link</b> below to reset your password:') ?><br>
<a target="_blank" href="<?= $resetLink ?>" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#242f9b;font-size:18px">
    <?= Html::encode($resetLink) ?></a>