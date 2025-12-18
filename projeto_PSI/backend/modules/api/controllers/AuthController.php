<?php

namespace backend\modules\api\controllers;

use yii\rest\Controller;
use yii\web\Response;
use Yii;
use common\models\User;
use common\models\Jogador;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator']['formats']['application/json'] =
            Response::FORMAT_JSON;

        return $behaviors;
    }

    public function verbs()
    {
        return [
            'login' => ['POST'],
            'signup' => ['POST'],
            'logout' => ['POST'],
        ];
    }

    // --------------------------
    // LOGIN
    // --------------------------
    public function actionLogin()
    {
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        if (!$username || !$password) {
            return ['success' => false, 'errorerror' => 'Username e password são obrigatórios'];
        }

        $user = User::findByUsername($username);

        if (!$user || !$user->validatePassword($password)) {
            return ['success' => false, 'error' => 'Credenciais inválidas'];
        }

        if (!$user->auth_key) {
            $user->generateAuthKey();
            $user->save(false);
        }

        return [
            'success' => true,
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
            if (empty($data[$field])) {
                return ['success' => false, 'error' => "Campo obrigatório: $field"];
            }
        }

        // validações extra
        if (strlen($data['password']) < 6) {
            return ['success' => false, 'error' => 'Password deve ter pelo menos 6 caracteres'];
        }

        if (User::find()->where(['username' => $data['username']])->exists()) {
            return ['success' => false, 'error' => 'Username já existe'];
        }

        if (User::find()->where(['email' => $data['email']])->exists()) {
            return ['success' => false, 'error' => 'Email já registado'];
        }

        // ------------------
        // Criar USER
        // ------------------
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

        // ------------------
        // ATRIBUIR ROLE "user"
        // ------------------
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('user');

        if ($role) {
            $auth->assign($role, $user->id);
        }

        // ------------------
        // Criar JOGADOR
        // ------------------
        $jogador = new Jogador();
        $jogador->id_user = $user->id;
        $jogador->nome = $data['nome'];
        $jogador->idade = (int)$data['idade'];

        if (!$jogador->save()) {
            $user->delete();
            return ['success' => false, 'errors' => $jogador->errors];
        }

        return [
            'success' => true,
            'message' => 'Conta criada com sucesso',
            'user_id' => $user->id,
            'jogador_id' => $jogador->id,
            'token' => $user->auth_key,
        ];
    }

    // --------------------------
    // LOGOUT
    // --------------------------
    public function actionLogout()
    {
        $token = Yii::$app->request->headers->get('Authorization');

        if (!$token) {
            return ['success' => false, 'error' => 'Token não fornecido'];
        }

        $user = User::findOne(['auth_key' => $token]);

        if (!$user) {
            return ['success' => false, 'error' => 'Token inválido'];
        }

        $user->auth_key = null;
        $user->save(false);

        return [
            'success' => true,
            'message' => 'Logout efetuado com sucesso'
        ];
    }
}
