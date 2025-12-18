<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use Yii;
use common\models\Resposta;
use common\models\Pergunta;

class RespostaController extends ActiveController
{
    public $modelClass = 'common\models\Resposta';

    // GET /api/resposta
    public function actionIndex()
    {
        return Resposta::find()->all();
    }

    // GET /api/resposta/{id}
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    // POST /api/resposta
    public function actionCreate()
    {
        $model = new Resposta();
        $model->load(Yii::$app->request->post(), '');
        $model->save();
        return $model;
    }

    // PUT /api/resposta/{id}
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post(), '');
        $model->save();
        return $model;
    }

    // DELETE /api/resposta/{id}
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return ['success' => true];
    }

    /* ==========================
     * ENDPOINTS PERSONALIZADOS
     * ========================== */

    // GET /api/resposta/pergunta/{id}
    public function actionPorpergunta($id)
    {
        return Resposta::find()
            ->where(['id_pergunta' => $id])
            ->all();
    }

    // PUT /api/resposta/{id}/correta
    public function actionSetcorreta($id)
    {
        $model = $this->findModel($id);
        $model->correta = Yii::$app->request->post('correta');
        $model->save();
        return ['status' => 'Resposta atualizada'];
    }

    protected function findModel($id)
    {
        if (($model = Resposta::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Resposta não encontrada');
    }
}
