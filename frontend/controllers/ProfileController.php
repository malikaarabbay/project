<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\Profile;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;
use frontend\models\ChangePasswordForm;
use yii\authclient\AuthAction;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

class ProfileController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user = User::findOne(['id' => Yii::$app->user->id]);

        return $this->render('index', [
            'user' => $user,
        ]);
    }

    public function actionUnbind($data){

        $user = User::findOne(['id' => Yii::$app->user->id]);
        $user->$data = NULL;
        $user->save();

    }

    public function actionEdit()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Profile();
        $user = User::findOne(['id' => Yii::$app->user->id]);



        $passwordModel = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->changeProfile()) {
                Yii::$app->getSession()->setFlash('success', 'Данные успешно изменены!');
                return $this->redirect(['profile/index']);
            }
            else {
                Yii::$app->getSession()->setFlash('danger', 'Возникла ошибка!');
            }
        }
        

        return $this->render('edit', [
            'user' => $user,
            'model' => $model,
            'passwordModel' => $passwordModel,
        ]);
    }

    public function actionView($id)
    {

        $user = User::findOne(['id' => $id]);
        $blogs = Blog::find()->where(['user_id' => $user->id])->all();


        return $this->render('view', [
            'user' => $user,
            'blogs' => $blogs,
        ]);
    }

    public function actionChangePassword()
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);
        $model = new Profile();

        $passwordModel = new ChangePasswordForm();
        if ($passwordModel->load(Yii::$app->request->post())) {
            if ($passwordModel->changePassword()) {
                Yii::$app->getSession()->setFlash('success', 'Пароль успешно изменен!');
            }
            else {
                Yii::$app->getSession()->setFlash('danger', 'Возникла ошибка!');
            }
        }

        return $this->redirect('index');

    }

    public function actions()
    {
        return [
            'fileapi-upload' => [
                'class' => FileAPIUpload::className(),
                'path' => '@frontend/web/images/',
                'unique' => true,
            ],
            'attach' => [
                'class' => AuthAction::className(),
                'successCallback' => [$this, 'successCallback'],
                'successUrl' => '/profile/index',
            ]

        ];
    }

    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();

        $user = User::findOne(Yii::$app->user->id);

        if($client->getName() == 'vkontakte'){
            $user->vk_id = (string)$attributes['id'];
        }

        else if($client->getName() == 'facebook'){
            $user->fb_id = $attributes['id'];
        }

        else if($client->getName() == 'google'){
            $user->gg_id = $attributes['id'];
        }

        else if($client->getName() == 'twitter'){
            $user->tw_id = $attributes['id'];
        }

        else if($client->getName() == 'mailru'){
            $user->mr_id = $attributes['id'];
        }

        else if($client->getName() == 'odnoklassniki'){
            $user->ok_id = $attributes['id'];
        }

        else if($client->getName() == 'linkedin'){
            $user->li_id = $attributes['id'];
        }

        if ($user->validate()) {
            $user->save();
            Yii::$app->getSession()->setFlash('success', 'Вы успешно привязали аккаунт');
        }
        else {
            Yii::$app->getSession()->setFlash('warning', 'Аккаунт уже привязан к другому пользователю');
        }


    }
}
