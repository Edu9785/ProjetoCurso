<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use common\models\Jogador;
use yii\web\NotFoundHttpException;

class JogadorController extends ActiveController
{
    public $modelClass = Jogador::class;

    // 1) /api/jogador/count
    public function actionCount()
    {
        $total = Jogador::find()->count();
        return ['count' => (int)$total];
    }

    // 2) /api/jogador/nomes
    public function actionNomes()
    {
        return Jogador::find()
            ->select(['id', 'nome'])
            ->asArray()
            ->all();
    }

    // 3) /api/jogador/{id}/idade
    public function actionIdade($id)
    {
        $jogador = Jogador::find()
            ->select(['idade'])
            ->where(['id' => $id])
            ->one();

        if (!$jogador) {
            throw new NotFoundHttpException("Jogador não encontrado.");
        }
        return $jogador;
    }

    // 5) /api/jogador/{id}  (DELETE)
    public function actionDelpornome($id)
    {
        return Jogador::deleteAll(['id' => $id]);
    }

    // 6) /api/jogador/{id} (PUT)
    public function actionPutidadepornome($id)
    {
        $nova_idade = \Yii::$app->request->post('idade');

        $jogador = Jogador::findOne(['id' => $id]);

        if (!$jogador) {
            throw new NotFoundHttpException("Jogador não encontrado.");
        }

        $jogador->idade = $nova_idade;
        $jogador->save();

        return ['status' => 'idade atualizada com sucesso'];
    }

    // 7) /api/jogador/vazio (POST)
    public function actionPostjogadorvazio()
    {
        $model = new Jogador();
        $model->id_user = 0;
        $model->nome = '';
        $model->idade = 0;
        $model->id_premium = null;
        $model->save();

        return $model;
    }
}
