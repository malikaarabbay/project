<?php
use yii\helpers\Url;
use frontend\widgets\ContestWidget;
use frontend\widgets\NewTestWidget;
use frontend\widgets\BlogWidget;
use yii\helpers\Html;
use yii\authclient\widgets\AuthChoice;
use yii\widgets\LinkPager;

$this->title = 'Личный кабинет';

/* @var $this yii\web\View */
?>
<div class="col-xs-12">
    <ul class="nav nav-pills">
        <li><a href="<?= Url::toRoute(['/profile/index']) ?>">Личный кабинет</a></li>
        <li><a href="<?= Url::toRoute(['/user/index']) ?>">Мои посты</a></li>
    </ul>
</div>
<div class="col-xs-12">

    <!-- CONTENT -->
    <div class="row">
        <div class="col-xs-12 wrap-content-blog">
            <h1>Личный кабинет</h1> <br>
            <div class="row">
                <br>

                <div class="col-xs-12 main-profile-item">

                    <div class="row">
                        <div class="col-xs-12 text-right">
                            <a class="profile-edit" href="/profile/edit">
                                Редактировать свои данные <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <form action="">
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <img src="<?= $user->image ?>" class="img-responsive" alt="">
                            </div>

                            <div class="col-xs-12 col-sm-8 col-md-7">
                                <div class="row">
                                    <div class="col-xs-12 ">
                                        <div class="title">ФИО</div>
                                        <div class="form-group">
                                            <p class="profile-text">
                                                <?= $user->firstname . ' ' . $user->lastname ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xs-12">
                                        <div class="title">Дата рождения</div>
                                        <div class="form-group">
                                            <p class="profile-text"><?= Yii::$app->formatter->asDate($user->birthday, 'dd.MM.yyyy') ?></p>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 ">
                                        <div class="title">Пол</div>
                                        <div class="row">
                                            <div class="col-xs-5 form-group">
                                                <p class="profile-text"><?= Yii::$app->params['user_sex'][$user->sex] ?></p>
                                            </div>
                                            <div class="col-xs-7 ">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12">
                                        <div class="title">E-Mail</div>
                                        <div class="form-group">
                                            <p class="profile-text"><?= $user->email ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="title">Социальные сети</div>
                                        <div class="social-attach">
                                            <?= $this->render('/profile/_socLinks',[
                                                'user' => $user,
                                            ]) ?>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>

            </div>


        </div>
    </div>
    <!-- CONTENT -->
</div>

