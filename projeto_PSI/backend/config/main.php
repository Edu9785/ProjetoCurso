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

        // 🔹 Request (JSON)
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],

        // 🔹 User
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-backend',
                'httpOnly' => true,
            ],
        ],

        // 🔹 Session
        'session' => [
            'name' => 'advanced-backend',
        ],

        // 🔹 Log
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        // 🔹 Error handler
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        // URL MANAGER (API REST)
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

                // 🔹 JOGADOR
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/jogador'],
                    'pluralize' => false,
                    'extraPatterns' => [

                        // Perfil
                        'GET {id}' => 'view',

                        // Atualizar perfil (custom)
                        'PUT updatejogador/{id}' => 'update-jogador',

                        // Eliminar conta
                        'DELETE {id}' => 'delete',

                        // Premium (mantido do zip/enunciado)
                        'GET {id}/premium' => 'premium',
                        'PUT {id}/comprar-premium/{id_premium}' => 'ativarpremium',
                        'PUT {id}/remover-premium' => 'removerpremium',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\d+>',
                        '{id_premium}' => '<id_premium:\d+>',
                    ],
                ],

                // 🔹 JOGOS DEFAULT
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/jogodefault'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET {titulo}' => 'by-titulo',
                    ],
                    'tokens' => [
                        '{titulo}' => '<titulo:[^/]+>',
                    ],
                ],

                // 🔹 AUTH
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/auth'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'POST signup' => 'signup',
                        'POST logout' => 'logout',
                    ],
                ],

                // 🔹 DIFICULDADES
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/dificuldade'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET nomes' => 'nomes',
                        'GET {id}/jogosdefault' => 'jogosdefault',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\d+>',
                    ],
                ],

                // 🔹 CATEGORIAS
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/categoria'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET nomes' => 'nomes',
                        'GET {id}/jogosdefault' => 'jogosdefault',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\d+>',
                    ],
                ],

                // 🔹 PERGUNTAS
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/pergunta'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET jogar/{id_jogo}' => 'jogar',
                    ],
                    'tokens' => [
                        '{id_jogo}' => '<id_jogo:\d+>',
                    ],
                ],

                // 🔹 PREMIUM
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/premium'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET nomes' => 'nomes',
                    ],
                ],
            ],
        ],
    ],

    'params' => $params,
];
