<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>

<p>Здравствуйте, <?= Html::encode($user) ?>!</p>
<p>Ваш новый пароль: <?= Html::encode($newPass)?></p>
