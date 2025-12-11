<?php

namespace backend\modules\api\controllers;

use yii\rest\Controller;
use Yii;
use common\models\User;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        $user = User::findByUsername($username);

        if (!$user || !$user->validatePassword($password)) {
            return ['error' => 'Credenciais inválidas'];
        }

        // Gera token se não existir
        if (!$user->auth_key) {
            $user->generateAuthKey();
            $user->save(false);
        }

        return [
            'status' => 'success',
            'user_id' => $user->id,
            'token' => $user->auth_key,
        ];
    }
}
