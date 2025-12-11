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
                        'DELETE {id}' => 'delporid',
                        'PUT {id}' => 'putidadeporid',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{nome}' => '<nome:\\w+>',
                    ],
                ],

                // 🔹 Jogos Default
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/jogosdefault'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET count' => 'count',
                        'GET titulos' => 'titulos',
                        'GET descricoes' => 'descricoes',
                        'GET {id}/titulo' => 'titulo',
                        'PUT {id}' => 'puttitulo',
                        'DELETE {id}' => 'delporid',
                        'GET {id}/categorias' => 'categorias',
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
                    ],
                ],

            ],
        ],


    ],
    'params' => $params,
];

// ==========================
// API DO JOGOSDEFAULT
// ==========================