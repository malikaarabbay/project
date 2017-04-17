<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\widgets;

use Yii;
use common\models\Review;

class Reviews extends \yii\bootstrap\Widget
{

    public $model = NULL;

    public function init()
    {
        parent::init();

        $reviewModel = new Review();
        $newReviewModel = new Review();

        if ($reviewModel->load(Yii::$app->request->post()) && $reviewModel->validate()) {
            $reviewModel->save();
        }

        $reviews = $reviewModel->find()->where(['model_id' => $this->model->id])->all();

        echo $this->render('reviews', [
            'reviews' => $reviews,
            'model' => $this->model,
            'reviewModel' => $newReviewModel,
        ]);

    }

    public function getModelName()
    {
        return $this->model->formName();
    }
    public function actions()
    {
        return [
            'fileapi-upload' => [
                'class' => FileAPIUpload::className(),
                'path' => '@frontend/web/images/',
                'unique' => true,
            ],

        ];
    }
}