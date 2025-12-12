<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\rest\Controller;
use Yii;
use common\models\User;
use common\models\Jogador;

class AuthController extends Controller
{
    public function verbs()
    {
        return [
            'login' => ['POST'],
            'signup' => ['POST'],
        ];
    }

    // --------------------------
    // LOGIN
    // --------------------------
    public function actionLogin()
    {
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        $user = User::findByUsername($username);

        if (!$user || !$user->validatePassword($password)) {
            return ['error' => 'Credenciais inválidas'];
        }

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

    // --------------------------
    // SIGNUP
    // --------------------------
    public function actionSignup()
    {
        $data = Yii::$app->request->post();

        $required = ['username', 'nome', 'email', 'password', 'idade'];
        foreach ($required as $field) {
            if (!isset($data[$field])) {
                return ['error' => "Missing field: $field"];
            }
        }

        // Create USER
        $user = new User();
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->setPassword($data['password']);
        $user->generateAuthKey();
        $user->created_at = time();
        $user->updated_at = time();

        if (!$user->save()) {
            return ['success' => false, 'errors' => $user->errors];
        }

        // Create JOGADOR
        $jogador = new Jogador();
        $jogador->id_user = $user->id;
        $jogador->nome = $data['nome'];
        $jogador->idade = intval($data['idade']);
        $jogador->id_premium = 1; // default

        if (!$jogador->save()) {
            $user->delete();
            return ['success' => false, 'errors' => $jogador->errors];
        }

        return [
            'success' => true,
            'message' => 'Registo efetuado com sucesso!',
            'user_id' => $user->id,
            'jogador_id' => $jogador->id,
            'token' => $user->auth_key,
        ];
    }
}
