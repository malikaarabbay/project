<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use vova07\fileapi\Widget as FileAPI;
use himiklab\thumbnail\EasyThumbnailImage;
$this->title = 'Редактирование профиля';

/* @var $this yii\web\View */
?>

<!-- LEFT -->
<div class="col-xs-12 col-md-9">

<!-- CONTENT -->
<div class="row">
<div class="col-xs-12 wrap-content-blog">
<h1 class="title"><?= $this->title ?></h1> <br>
<div class="row">
<br>

<div class="col-xs-12 main-blog-item main-news-item">

    <span class="cabinet-title"><?= $user->firstname . ' ' . $user->lastname ?>!</span>

    <div class="row">

        <?php $form = ActiveForm::begin(['id' => 'profile-form', 'action' => Url::toRoute('/profile/edit')]); ?>

            <div class="col-xs-12 col-md-4 col-sm-4">
                <img src="<?= $user->image ?>" width="206" alt="">

                <?= $form->field($model, 'photo')->widget(
                    FileAPI::className(),
                    [
                        'settings' => [
                            'url' => ['fileapi-upload'],
                        ],
                        'preview' =>false,
                        'crop' =>true,


                    ]);
                ?>

            </div>

            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="title">Фамилия</div>
                <div class="form-group">
                    <?= $form->field($model, 'lastname')->textInput(['value' => $user->lastname ])->label(false) ?>
                </div>

                <div class="title">Имя</div>
                <div class="form-group">
                    <?= $form->field($model, 'firstname')->textInput(['value' => $user->firstname ])->label(false) ?>
                </div>

                <div class="title">День рождения</div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <?= $form->field($model, 'birthday', [
                            'template' => "{label}\n<div class='col-xs-12'>{input}\n{hint}\n{error}\n</div>",
                        ])->widget(\kartik\date\DatePicker::className(), [
                            'language' => 'ru',
                            'type' => \kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
                            'pluginOptions' => [
                                'todayHighlight' => 'true',
                                'autoclose' => true,
                                'format' => 'dd.mm.yyyy'
                            ]
                        ])->label(false) ?>
                    </div>
                </div>

                <div class="title">Пол</div>
                <div class="row">
                    <div class="col-xs-5 form-group">
                        <?= $form->field($model, 'sex')->dropDownList(Yii::$app->params['user_sex'])->label(false) ?>
                    </div>
                </div>

                <div class="title">E-Mail</div>
                <div class="form-group">
                    <?= $form->field($model, 'email')->textInput(['value' => $user->email ])->label(false) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                </div>

            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<div class="col-xs-12 cabinet-bottom-margin">

    <div class="col-xs-11">
        <span class="cabinet-title">Сменить пароль</span>
        <?php $form = ActiveForm::begin(['id' => 'change-pass-form', 'action' => Url::toRoute('/profile/change-password')]); ?>
        <!--                        --><?php //$form = ActiveForm::begin(['id' => 'change-pass-form']); ?>

        <div class="cabinet-title-1">Введите новый пароль</div>
        <div class="form-group">
            <?= $form->field($passwordModel, 'password', ['inputOptions' => ['class' => 'form-control col-xs-10']])->passwordInput()->label(false) ?>
        </div>

        <div class="cabinet-title-1">Повторите пароль</div>

        <div class="form-group">
            <?= $form->field($passwordModel, 'repeatPassword', ['inputOptions' => ['class' => 'form-control col-xs-10']])->passwordInput()->label(false) ?>
        </div>

        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?php ActiveForm::end(); ?>

    </div>
</div>

</div>
</div>
</div>
<!-- CONTENT -->
</div>
<!-- LEFT -->

