<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

Yii::setAlias('@frontendUrl', 'http://localhost/ProjetoCurso/projeto_PSI/frontend/web');

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

                // 🔹 Jogador
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/jogador'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET count' => 'count',
                        'GET nomes' => 'nomes',
                        'GET {id}/idade' => 'idade',
                        'PUT {id}/idade' => 'putidade',
                        'GET {id}/premium' => 'premium',
                        'PUT {id}/ativar-premium/{premiumId}' => 'ativarpremium',
                        'PUT {id}/remover-premium' => 'removerpremium',
                    ],
                ],

                // 🔹 Jogos Default
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/jogodefault'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET {id}/perguntas' => 'perguntas',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],

                // 🔹 AuthController — tem regra própria
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/auth'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'POST signup' => 'signup',
                        'Post logout' => 'logout',
                    ],
                ],

                // 🔹 Dificuldades
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/dificuldade'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET count' => 'count',
                        'GET nomes' => 'nomes',
                    ],
                ],

                // 🔹 Categorias
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/categoria'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET nomes' => 'nomes',
                        'GET count' => 'count',
                        'GET {id}/jogosdefault' => 'jogosdefault',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],

                // 🔹 Perguntas
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/pergunta'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET {id}/respostas' => 'respostas',
                        'GET search/{texto}' => 'search',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{texto}' => '<texto:[^/]+>',
                    ],
                ],

                // 🔹 Respostas
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/resposta'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET pergunta/{id}' => 'porpergunta',
                        'PUT {id}/correta' => 'setcorreta',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],
            ],
        ],


    ],
    'params' => $params,
];