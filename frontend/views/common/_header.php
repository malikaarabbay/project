<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
?>

<?php
NavBar::begin([
    'brandLabel' => 'Project',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse',
    ],
]);

if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
    $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
} else {
    $menuItems[] = ['label' => 'Личный кабинет (' . Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->lastname. ')', 'url' => ['/profile/index']];
    $menuItems[] = [
        'label' => 'Выйти',
        'url' => ['/site/logout'],
        'linkOptions' => ['data-method' => 'post']
    ];
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();
?>