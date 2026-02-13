<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;
use common\models\Jogador;
use common\models\User;

class JogadorController extends ActiveController
{
    public $modelClass = 'common\models\Jogador';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator']['formats']['application/json'] =
            Response::FORMAT_JSON;

        return $behaviors;
    }

    public function actionView($id)
    {
        $user = $this->getUserFromToken();

        $jogador = Jogador::findOne($id);

        if (!$jogador || $jogador->id_user !== $user->id) {
            throw new NotFoundHttpException('Jogador não encontrado ou acesso negado');
        }

        return [
            'id' => $jogador->id,
            'nome' => $jogador->nome,
            'idade' => $jogador->idade,
            'username' => $user->username,
            'email' => $user->email,
        ];
    }

    public function actionUpdateJogador($id)
    {
        $user = $this->getUserFromToken();

        if ($user === null) {
            return ['erro' => 'USER NULL'];
        }

        $data = Yii::$app->request->bodyParams;

        $jogador = Jogador::findOne($id);
        if (!$jogador || $jogador->id_user !== $user->id) {
            throw new NotFoundHttpException('Jogador não encontrado ou acesso negado');
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $user->username = $data['username'];
            $user->email = $data['email'];
            $user->save();

            $jogador->nome = $data['nome'];
            $jogador->idade = (int)$data['idade'];
            $jogador->save();

            $transaction->commit();

            return ['success' => true];

        } catch (\Exception $e) {
            $transaction->rollBack();
            return ['success' => false];
        }
    }

    public function actionDelete($id)
    {
        // validar token
        $user = $this->getUserFromToken();

        // confirmar jogador pertence ao user
        $jogador = Jogador::findOne($id);

        if (!$jogador || $jogador->id_user !== $user->id) {
            throw new NotFoundHttpException('Jogador não encontrado ou acesso negado');
        }

        // SOFT DELETE → desativar conta
        $user->status = 0;

        if ($user->save(false)) {
            return [
                'success' => true,
                'message' => 'Conta desativada com sucesso'
            ];
        }

        return [
            'success' => false,
            'message' => 'Erro ao desativar conta'
        ];
    }


    private function getUserFromToken()
    {
        $authHeader = Yii::$app->request->headers->get('Authorization');

        if (!$authHeader) {
            return null;
        }

        // Remove "Bearer " do início
        $token = str_replace('Bearer ', '', $authHeader);

        return User::findOne(['auth_key' => $token]);
    }

    public function actions()
    {
        $actions = parent::actions();

        // desligar delete default do ActiveController
        unset($actions['delete']);

        return $actions;
    }
}
