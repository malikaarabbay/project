<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use vova07\fileapi\Widget as FileAPI;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(['id' => 'form-signup', 'layout' => 'horizontal', 'action' => Url::toRoute('/site/signup')]); ?>

            <div class="row">
                <div class="col-xs-12">
                    <?= $form->field($model, 'firstname') ?>
                    <?= $form->field($model, 'lastname') ?>
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
                    <?= $form->field($model, 'birthday', [
                        'template' => "{label}\n<div class='col-xs-6'>{input}\n{hint}\n{error}\n</div>",
                    ])->widget(\kartik\date\DatePicker::className(), [
                        'language' => 'ru',
                        'type' => \kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
                        'pluginOptions' => [
                            'todayHighlight' => 'true',
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy'
                        ]
                    ])->label('День рождения') ?>
                    <?= $form->field($model, 'sex')->dropDownList(Yii::$app->params['user_sex']) ?>
                    <?= $form->field($model, 'email') ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>
                </div>
            </div>

        <div class="form-group text-center">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-info']) ?>
        </div>

        <?php ActiveForm::end(); ?>
</div>
