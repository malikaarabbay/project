<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'site/index',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'cart' => [
            'class' => 'yz\shoppingcart\ShoppingCart',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules'=>[
                '/' => 'site/index',
//                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                '<controller:(news)>' => '<controller>/index',
                '<controller:(news)>/<slug>' => '<controller>/view',
                '<controller:(article)>/<slug>' => '<controller>/view',
            ]
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '205019669999942',
                    'clientSecret' => '7209c9cffc541d41807ed012ac45cd77',
                    'viewOptions' => [
                        'popupWidth' => '980',
                        'popupHeight' => '650,'
                    ],
					'attributeNames' => ['name', 'email', 'first_name', 'last_name', 'gender'],
                ],
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '5987209',
                    'clientSecret' => 'q92wtno5hCtWWSFc05LT',
                    'scope' => ['email'],
                    'viewOptions' => [
                        'popupWidth' => '980',
                        'popupHeight' => '650,'
                    ],
                ],
                'mailru' => [
                    'class' => 'common\authclient\clients\Mailru',
                    'clientId' => '753429',
                    'clientSecret' => 'a2db468464c871376f97e1393bd559f8',
                    'viewOptions' => [
                        'popupWidth' => '980',
                        'popupHeight' => '650,'
                    ],
                ],
                'odnoklassniki' => [
                    'class' => 'common\authclient\clients\Ok',
                    'clientId' => '1142895616',
                    //'clientPublic' => 'CBAFDQBFEBABABABA',
                    'clientSecret' => 'CFE468F23D99417C81E00619',
                    'viewOptions' => [
                        'popupWidth' => '980',
                        'popupHeight' => '650,'
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
