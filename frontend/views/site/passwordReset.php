<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">

    <div class="container">

        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">

                <h1 class="text-center">Восстановление пароля</h1>

                <p>Пожалуйста введите свой email</p>

                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email')->textInput(['class' => 'form-control login-input'])->label(false) ?>

                <div class="form-group text-center">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>

</div>
