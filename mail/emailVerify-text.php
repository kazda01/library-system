<?php

/** @var yii\web\View $this */
/** @var app\models\User $user */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<?= Yii::t('app', 'Hello,') ?>

<?= Yii::t('app', 'Please click on the link below to activate your account:') ?>

<?= $verifyLink ?>
