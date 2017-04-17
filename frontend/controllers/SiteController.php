<?php
namespace frontend\controllers;

use common\models\Feedback;
use common\models\User;
use common\models\Article;
use yii\data\ActiveDataProvider;
use frontend\models\PasswordResetForm;
use Yii;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\authclient\AuthAction;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;

class SiteController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            Url::remember();
            return true;
        } else {
            return false;
        }
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => AuthAction::className(),
                'successCallback' => [$this, 'successCallback'],
                'successUrl' => '/user/index',
            ],
            'fileapi-upload' => [
                'class' => FileAPIUpload::className(),
                'path' => '@frontend/web/images/',
                'unique' => true,
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Article::find()->where(['is_published' => '1'])->orderBy('created DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new Feedback();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->status = 1;
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Спасибо. Письмо отправлено.');
            } else {
                Yii::$app->session->setFlash('error', 'Произошла ошибка.');
            }
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionCallback()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Спасибо. Письмо отправлено.');
            } else {
                Yii::$app->session->setFlash('error', 'Произошла ошибка.');
            }

            return $this->refresh();
        } else {
            return $this->render('callback', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    Yii::$app->getSession()->setFlash('success', 'Вы успешно зарегистрировались.');
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


//    public function actionRequestPasswordReset()
//    {
//        $model = new PasswordResetRequestForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail()) {
//                Yii::$app->getSession()->setFlash('success', 'Проветьте свою почту и следуйте инструкциям.');
//
//                return $this->goHome();
//            } else {
//                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
//            }
//        }
//
//        return $this->render('requestPasswordResetToken', [
//            'model' => $model,
//        ]);
//    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionPasswordReset()
    {
        $model = new PasswordResetForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->newPassword()) {
                Yii::$app->getSession()->setFlash('success', 'Проверьте ваш email для дальнейших инструкций.');
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Ошибка при отправке');
                return $this->goHome();
            }
        }
        return $this->render('passwordReset', [
            'model' => $model,
        ]);
    }

    public function actionSubscribe()
    {
        $model = new Subscribe();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Вы успешно подписались.');
            return $this->goHome();
        } else{
            Yii::$app->getSession()->setFlash('error', 'Произошла ошибка. Такой email уже существует');
            return $this->goHome();
        }
    }

    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();

        $model = new SignupForm();
        $model->scenario = 'social';

        if($client->getName() == 'vkontakte'){

            $accessToken = $client->getAccessToken();
            $email = isset($accessToken->params['email']) ? $accessToken->params['email'] : '';

            $model->email = $email;
            $model->vk_id = (string)$attributes['id'];
            $model->firstname = $attributes['first_name'];
            $model->lastname = $attributes['last_name'];
            $model->sex = $attributes['sex'] - 1;

            $photo = file_get_contents($attributes['photo']);

            $user = User::find()->where(['vk_id' => $attributes['id']])->one();

        } else if($client->getName() == 'facebook'){

            $email = isset($attributes['email']) ? $attributes['email'] : '';

            $model->email = $email;
            $model->fb_id = $attributes['id'];
            $model->firstname = $attributes['first_name'];
            $model->lastname = $attributes['last_name'];
            $model->sex = ($attributes['gender'] == 'female') ? 0 : 1;

            $photo = file_get_contents('https://graph.facebook.com/'.$attributes['id'].'/picture?type=large');

            $user = User::find()->where(['fb_id' => $attributes['id']])->one();
        }

        else if($client->getName() == 'google'){

            $email = isset($attributes['emails'][0]['value']) ? $attributes['emails'][0]['value'] : '';

            $model->email = $email;
            $model->gg_id = $attributes['id'];
            $model->firstname = $attributes['name']['givenName'];
            $model->lastname = $attributes['name']['familyName'];
            $model->sex = (isset($attributes['gender']) && $attributes['gender'] == 'female') ? 0 : 1;

            $photo = isset($attributes['image']['url']) ? file_get_contents($attributes['image']['url']) : '';

            $user = User::find()->where(['gg_id' => $attributes['id']])->one();
        }
        else if($client->getName() == 'mailru'){

            $email = isset($attributes['email']) ? $attributes['email'] : '';

            $model->email = $email;
            $model->mr_id = $attributes['id'];
            $model->firstname = $attributes['first_name'];
            $model->lastname = $attributes['last_name'];
            $model->sex = ($attributes['sex'] == 1) ? 0 : 1;

            $photo = isset($attributes['pic_2']) ? file_get_contents($attributes['pic_2']) : '';

            $user = User::find()->where(['mr_id' => $attributes['id']])->one();
        }

        else if($client->getName() == 'odnoklassniki'){

            $email = isset($attributes['email']) ? $attributes['email'] : '';
            $model->email = $email;
            $model->ok_id = $attributes['id'];
            $model->firstname = $attributes['first_name'];
            $model->lastname = $attributes['last_name'];
            $photo = isset($attributes['pic_190']) ? file_get_contents($attributes['pic_190']) : '';

            $user = User::find()->where(['ok_id' => $attributes['id']])->one();
        }

        else if($client->getName() == 'linkedin'){

            $email = isset($attributes['email']) ? $attributes['email'] : '';
            $model->email = $email;
            $model->firstname = $attributes['first_name'];
            $model->lastname = $attributes['last_name'];

            $model->li_id = $attributes['id'];

            $photo = isset($attributes['picture-url']) ? file_get_contents($attributes['picture-url']) : '';

            $user = User::find()->where(['li_id' => $attributes['id']])->one();
        }

        else if($client->getName() == 'twitter'){

            $email = '';

            $model->email = $email;
            $model->tw_id = $attributes['id'];
            $model->firstname = $attributes['name'];
            $model->lastname = '';
            $photo = isset($attributes['profile_image_url']) ? file_get_contents(str_replace('_normal', '', $attributes['profile_image_url'])) : '';

            $user = User::find()->where(['tw_id' => $attributes['id']])->one();
        }
        else if($client->getName() == 'github'){

            $email = '';

            $model->email = $email;
            $model->gh_id = $attributes['id'];
            $model->firstname = $attributes['login'];
            $model->lastname = '';
            $photo = isset($attributes['avatar_url']) ? file_get_contents($attributes['avatar_url']) : '';


            $user = User::find()->where(['gh_id' => $attributes['id']])->one();
        }

        if($user){
            if($user->status == User::STATUS_ACTIVE) {
                Yii::$app->getUser()->login($user);
                Yii::$app->getSession()->setFlash('success', 'Вы успешно вошли.');
            } else {
                Yii::$app->getSession()->setFlash('danger', 'Ваш аккаунт заблокирован!');
            }

        }else {
            if($email && $user = User::find()->where(['email' => $email])->one()){

                if($client->getName() == 'vkontakte'){
                    $user->vk_id = (string)$attributes['id'];
                }

                else if($client->getName() == 'facebook'){
                    $user->fb_id = $attributes['id'];
                }

                else if($client->getName() == 'google'){
                    $user->gg_id = $attributes['id'];
                }

                else if($client->getName() == 'linkedin'){
                    $user->li_id = $attributes['id'];
                }

                else if($client->getName() == 'twitter'){
                    $user->tw_id = $attributes['id'];
                }
                else if($client->getName() == 'github'){
                    $user->gh_id = $attributes['id'];
                }

                $user->save(false);

                Yii::$app->getUser()->login($user);
                Yii::$app->getSession()->setFlash('success', 'Вы успешно вошли.');

            } else{
                // Сохраняет Аватарку для нового пользователя
                if ($photo) {
                    $image = uniqid().'.jpg';
                    $model->photo = $image;
                    $imageDir = Yii::getAlias('@frontend/web/images/'.$image);

                    file_put_contents($imageDir, $photo);
                }

                if($user = $model->signupSocial()){
                    if (Yii::$app->getUser()->login($user)) {
                        Yii::$app->getSession()->setFlash('success', 'Вы успешно зарегестрировались.');
                    }
                }
            }
        }
    }
}
