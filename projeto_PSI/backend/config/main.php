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
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'api/jogador',
                        'api/jogodefault',
                        ],
                    'pluralize' => false,
                    'extraPatterns' => [

                        // 1) Contar jogadores
                        'GET count' => 'count',

                        // 2) Apenas nomes
                        'GET nomes' => 'nomes',

                        // 3) Obter idade por ID
                        'GET {id}/idade' => 'idade',

                        // 4) Obter idade por nome
                        'GET idade/{nome}' => 'idadepornome',

                        // 5) Apagar jogador pelo nome
                        'DELETE {nome}' => 'delpornome',

                        // 6) Atualizar idade pelo nome
                        'PUT {nome}' => 'putidadepornome',

                        // 7) Criar jogador vazio
                        'POST vazio' => 'postjogadorvazio',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',           // apenas números
                        '{nome}' => '<nome:\\w+>',       // letras, números, underscore
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
