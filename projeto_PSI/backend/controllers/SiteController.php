<?php

namespace backend\controllers;

use common\models\Compra;
use common\models\LoginForm;
use backend\models\SignupForm;
use common\models\Produto;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login','signup', 'error'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {

        // caso já esteja logado
        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->can('accessBackOffice')) {
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', "Login permitido só a <strong>Administradores</strong>");
            return $this->goHome();
        }

        $this->layout = 'blank';

        $hardcodedEmail = 'admin@exemplo.local';
        $hardcodedPassword = 'minhaSenha123';

        $model = new \common\models\LoginForm();

        if ($model->load(Yii::$app->request->post())) {
            // se bater com as credenciais hardcoded
            if ($model->email === $hardcodedEmail && $model->password === $hardcodedPassword) {

                // cria um identity simples (tem limitações — veja abaixo)
                $identity = new \common\models\User();
                $identity->id = 999999; // id fictício
                $identity->username = 'admin';
                $identity->email = $hardcodedEmail;

                Yii::$app->user->login($identity, 0); // login sem remember

                // redireciona para onde vinha (ou para index)
                return $this->goBack();
            } else {
                Yii::$app->session->setFlash('error', 'Credenciais inválidas (hardcoded).');
            }
        }

        // limpa password antes de mostrar
        $model->password = '';

        // renderiza a view de login (isto corrige a página em branco)
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        $this->layout = 'blank';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->redirect(['login']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}