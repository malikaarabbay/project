<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\authclient\widgets\AuthChoice;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">

        <div class="col-xs-12">
            <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6 text-center">
            <p class="login-title"> Вход по e-mail</p>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'layout' => 'horizontal', 'action' => Url::toRoute('/site/login')]); ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group ">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                </div>

            <a href="<?= Url::toRoute(['site/password-reset'])?>" >Забыли?</a> <br/>
            <a href="<?= Url::toRoute(['site/signup'])?>" >Зарегистрироваться</a>
            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6 text-center">
            <p class="login-title">Вход через соц.сервисы</p>
            <ul class="social">
                <?php $authAuthChoice = AuthChoice::begin([
                    'baseAuthUrl' => ['site/auth'],
                    'options' => [
                        'class' => 'social'
                    ]
                ]); ?>
                <?php foreach ($authAuthChoice->getClients() as $client) { ?>
                    <li>
                        <?php switch ($client->getName()) {
                            case ('facebook') :
                                echo $authAuthChoice->clientLink($client, '<i class="fa fa-facebook"></i>', ['class' => 'profile-contact-attach-link']);
                                break;
                            case ('vkontakte') :
                                echo $authAuthChoice->clientLink($client, '<i class="fa fa-vk"></i>');
                                break;
                            case ('mailru') :
                                echo $authAuthChoice->clientLink($client, '<i class="fa fa-at"></i>');
                                break;
                            case ('odnoklassniki') :
                                echo $authAuthChoice->clientLink($client, '<i class="fa fa-odnoklassniki"></i>');
                                break;
                        } ?>
                    </li>
                <?php } ?>
                <?php AuthChoice::end(); ?>
            </ul>
            <div class="clear"></div>
            <span class="case-social">войдите через один из сервисов</span>
        </div>
    </div>
</div>
