<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $user */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<?= Yii::t('app', 'Hello,') ?><br>
<br>
<?= Yii::t('app', 'Please click on the link below to activate your account:') ?><br>
<br>
<?= Html::a(Html::encode($verifyLink), $verifyLink) ?><br>