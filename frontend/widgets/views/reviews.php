<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Review;
use himiklab\thumbnail\EasyThumbnailImage;

?>
<div class="comment-headline">
    Комментарии к посту
</div>
<?php if (Yii::$app->user->isGuest) { ?>
    <div class="reviews-form">

        <div class="col-xs-12">
            <blockquote>
                <small>Только зарегистрированные пользователи могут оставлять комментарии! <a href="<?= Url::toRoute(['/site/signup']) ?>">Зарегистрироватся</a></small>
            </blockquote>
        </div>
        <div class="clearfix"></div>

        </div>
<?php } else { ?>

<div class="media">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($reviewModel, 'model')->input('hidden', ['value' => $model->formName()])->label(false) ?>

    <?= $form->field($reviewModel, 'model_id')->input('hidden', ['value' => $model->id])->label(false) ?>

    <?= $form->field($reviewModel, 'user_id')->input('hidden', ['value' => Yii::$app->user->id])->label(false) ?>



    <?= $form->field($reviewModel, 'review',[
        'inputOptions' => [
            'placeholder' => 'Ваш комментарий',
        ]])->textarea(['cols' => 40, 'rows' => 7])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>

<?php } ?>

        <?php foreach($reviews as $review) { ?>
            <div class="media">
                <div class="col-xs-12 col-sm-3 col-md-2">
                    <div class="media-left media-middle">
                        <?php if($review->user->imagePath) {?>
                        <?=
                        EasyThumbnailImage::thumbnailImg(
                            $review->user->imagePath,
                            120,
                            120,
                            EasyThumbnailImage::THUMBNAIL_OUTBOUND,
                            [

                                'class' => 'media-object img-circle'
                            ]
                        );
                        ?>
                        <?php } else {?>
                            <img class="media-object" src="/images/default-user.jpg" alt="">
                        <?php } ?>
                        <span><?= $review->user->firstname.' '.$review->user->lastname ?></span>
                </div>
                </div>
                <div class="col-xs-12 col-sm-9 col-md-10">
                    <div class="media-body">
                        <div class="review-date">
                            <small><?= Yii::$app->formatter->asDatetime($review->created) ?></small>
                        </div>
                        <?=$review->review?>
                    </div>
                </div>
            </div>

        <?php } ?>


