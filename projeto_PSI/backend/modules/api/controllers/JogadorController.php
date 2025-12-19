<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use Yii;
use common\models\Jogador;
use common\models\User;
use common\models\Premium;

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
        return Jogador::find()
            ->with('user')
            ->where(['id' => $id])
            ->one();
    }

    // PUT /api/jogador/{id}
    public function actionUpdate($id)
    {
        $jogador = $this->findModel($id);
        $user = $jogador->user; // relação Jogador → User

        $data = Yii::$app->request->post();

        // --------------------
        // Atualizar JOGADOR
        // --------------------
        $jogador->load($data, '');

        // --------------------
        // Atualizar USER
        // --------------------
        if (isset($data['username'])) {
            // verificar se username já existe (exceto o próprio user)
            if (User::find()
                ->where(['username' => $data['username']])
                ->andWhere(['<>', 'id', $user->id])
                ->exists()) {

                return [
                    'success' => false,
                    'error' => 'Username já está em uso'
                ];
            }

            $user->username = $data['username'];
        }

        if (isset($data['email'])) {
            // verificar se email já existe (exceto o próprio user)
            if (User::find()
                ->where(['email' => $data['email']])
                ->andWhere(['<>', 'id', $user->id])
                ->exists()) {

                return [
                    'success' => false,
                    'error' => 'Email já está em uso'
                ];
            }

            $user->email = $data['email'];
        }

        // --------------------
        // Guardar tudo
        // --------------------
        if (!$jogador->save()) {
            return [
                'success' => false,
                'errors' => $jogador->errors
            ];
        }

        if (!$user->save()) {
            return [
                'success' => false,
                'errors' => $user->errors
            ];
        }

        return [
            'success' => true,
            'message' => 'Dados atualizados com sucesso',
            'jogador' => $jogador,
            'user' => [
                'username' => $user->username,
                'email' => $user->email
            ]
        ];
    }


    // DELETE /api/jogador/{id}
    public function actionDelete($id)
    {
        $jogador = $this->findModel($id);
        $user = $jogador->user;

        $user->status = User::STATUS_INACTIVE;
        $user->save(false);

        return ['success' => true];
    }

    // GET /api/jogador/nomes
    public function actionNomes()
    {
        return Jogador::find()
            ->select(['id', 'nome'])
            ->asArray()
            ->all();
    }

    // GET /api/jogador/{id}/idade
    public function actionIdade($id)
    {
        return $this->findModel($id)->idade;
    }

    // PUT /api/jogador/{id}/idade
    public function actionPutidade($id)
    {
        $jogador = $this->findModel($id);
        $jogador->idade = Yii::$app->request->post('idade');
        $jogador->save(false);

        return ['success' => true];
    }

    // GET /api/jogador/{id}/premium
    public function actionPremium($id)
    {
        $jogador = $this->findModel($id);

        if (!$jogador->id_premium) {
            return ['premium' => false];
        }

        $premium = Premium::findOne($jogador->id_premium);

        return [
            'premium' => true,
            'plano' => $premium->nome,
            'preco' => $premium->preco
        ];
    }

    // PUT /api/jogador/{id}/comprar-premium/{id_premium}
    public function actionAtivarpremium($id, $id_premium)
    {
        $jogador = $this->findModel($id);

        // verificar se plano premium existe
        $premium = Premium::findOne($id_premium);
        if (!$premium) {
            throw new NotFoundHttpException('Plano premium não encontrado');
        }

        // verificar se já é premium
        if ($jogador->id_premium) {
            return [
                'success' => false,
                'message' => 'Jogador já possui plano premium'
            ];
        }

        $jogador->id_premium = $premium->id;
        $jogador->save(false);

        return [
            'success' => true,
            'message' => 'Premium ativado com sucesso',
            'plano' => $premium->nome,
            'preco' => $premium->preco
        ];
    }

    // PUT /api/jogador/{id}/remover-premium
    public function actionRemoverpremium($id)
    {
        $jogador = $this->findModel($id);

        if (!$jogador->id_premium) {
            return [
                'success' => false,
                'message' => 'Jogador não possui premium ativo'
            ];
        }

        $jogador->id_premium = null;
        $jogador->save(false);

        return [
            'success' => true,
            'message' => 'Premium removido com sucesso'
        ];
    }



    protected function findModel($id)
    {
        if (($model = Jogador::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Jogador não encontrado');
    }
}
