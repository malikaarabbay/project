<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use vova07\fileapi\Widget as FileAPI;
use himiklab\thumbnail\EasyThumbnailImage;
use yii\helpers\Url;
use common\models\Category;
use yii\helpers\ArrayHelper;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="<?= ($image_tab) ? '' : 'active'?>">
                <a href="#tab_1" data-toggle="tab">Данные</a>
            </li>
            <li class="pull-right">
                <?= Html::submitButton($model->isNewRecord ?
                        '<span class="glyphicon glyphicon-ok"></span> '.Yii::t('app', 'Create') :
                        '<span class="glyphicon glyphicon-floppy-disk"></span> '.Yii::t('app', 'Save'),
                    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </li>
        </ul>
        <div class="tab-content">

            <div class="tab-pane <?= ($image_tab) ? '' : 'active'?>" id="tab_1">

                <div class="row">
                    <div class="col-md-8 col-xs-12">
                        <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

                        <?= $form->field($model, 'anounce')->textarea(['rows' => 6]) ?>

                        <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                            'options' => ['rows' => 6],
                            'preset' => 'full',
                            'clientOptions' => [
                                'filebrowserBrowseUrl' => '/elfinder/manager?filter=image&'
                            ]
                        ]) ?>

                        <?= $form->field($model, 'is_published')->checkbox() ?>
                        
                    </div>

                    <div class="col-md-4 col-xs-12">
                        <?= $form->field($model, 'photo')->widget(
                            FileAPI::className(),
                            [
                                'settings' => [
                                    'url' => ['fileapi-upload'],
                                    'elements' => [
                                        'preview' => [
                                            'width' => 250,
                                            'height' => 200
                                        ]
                                    ],
                                ],
                            ])
                        ?>

                        <?= $form->field($model, 'meta_keywords')->textarea(['rows' => 4]) ?>

                        <?= $form->field($model, 'meta_description')->textarea(['rows' => 4]) ?>

                        <?= $form->field($model, 'slug')->textInput(['maxlength' => 255]) ?>

                    </div>
                </div>

            </div><!-- /.tab-pane -->
            
        </div><!-- /.tab-content -->
    </div>

    <?php ActiveForm::end(); ?>

</div>

