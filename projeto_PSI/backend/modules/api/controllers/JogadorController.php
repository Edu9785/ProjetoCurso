<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use Yii;
use common\models\Jogador;
use common\models\User;

class JogadorController extends ActiveController
{
    public $modelClass = 'common\models\Jogador';

    // GET /api/jogador
    public function actionIndex()
    {
        return Jogador::find()
            ->with('user')
            ->all();
    }

    // GET /api/jogador/{id}
    public function actionView($id)
    {
        $jogador = Jogador::find()
            ->with('user')
            ->where(['id' => $id])
            ->one();

        if (!$jogador) {
            throw new NotFoundHttpException('Jogador não encontrado');
        }

        return $jogador;
    }

    // PUT / PATCH /api/jogador/updatejogador/{id}
    public function actionUpdateJogador($id)
    {
        $data = Yii::$app->request->bodyParams;

        // 🔹 Buscar Jogador primeiro
        $jogador = Jogador::findOne($id);
        if (!$jogador) {
            throw new NotFoundHttpException('Jogador não encontrado');
        }

        // 🔹 Buscar User associado
        $user = User::findOne($jogador->id_user);
        if (!$user) {
            throw new NotFoundHttpException('User não encontrado');
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            // ====== UPDATE USER ======
            if (isset($data['email'])) {
                $user->email = $data['email'];
            }

            if (isset($data['username'])) {
                $user->username = $data['username'];
            }

            if (!$user->save()) {
                throw new \Exception(json_encode($user->errors));
            }

            // ====== UPDATE JOGADOR ======
            if (isset($data['nome'])) {
                $jogador->nome = $data['nome'];
            }

            if (isset($data['idade'])) {
                $jogador->idade = $data['idade'];
            }

            if (!$jogador->save()) {
                throw new \Exception(json_encode($jogador->errors));
            }

            $transaction->commit();

            return [
                'success' => true,
                'message' => 'Dados atualizados com sucesso',
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'username' => $user->username,
                ],
                'jogador' => [
                    'id' => $jogador->id,
                    'nome' => $jogador->nome,
                    'idade' => $jogador->idade,
                ],
            ];

        } catch (\Exception $e) {
            $transaction->rollBack();

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }



    protected function findModel($id)
    {
        if (($model = Jogador::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Jogador não encontrado');
    }
}
