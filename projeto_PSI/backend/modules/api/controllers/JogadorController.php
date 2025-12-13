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
        return Jogador::find()->all();
    }

    // GET /api/jogador/{id}
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    // POST /api/jogador
    public function actionCreate()
    {
        $model = new Jogador();
        $model->load(Yii::$app->request->post(), '');
        $model->save();
        return $model;
    }

    // PUT /api/jogador/{id}
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post(), '');
        $model->save();
        return $model;
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

    // GET /api/jogador/count
    public function actionCount()
    {
        return ['count' => (int) Jogador::find()->count()];
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

    protected function findModel($id)
    {
        if (($model = Jogador::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Jogador não encontrado');
    }
}
