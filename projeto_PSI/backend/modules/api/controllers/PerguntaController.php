<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use Yii;
use common\models\Pergunta;
use common\models\Resposta;

class PerguntaController extends ActiveController
{
    public $modelClass = 'common\models\Pergunta';


    // GET /api/pergunta
    public function actionIndex()
    {
        return Pergunta::find()->all();
    }

    // GET /api/pergunta/{id}
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    // POST /api/pergunta
    public function actionCreate()
    {
        $model = new Pergunta();
        $model->load(Yii::$app->request->post(), '');
        $model->save();
        return $model;
    }

    // PUT /api/pergunta/{id}
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post(), '');
        $model->save();
        return $model;
    }

    // DELETE /api/pergunta/{id}
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return ['success' => true];
    }

    /* ==========================
     * ENDPOINTS PERSONALIZADOS
     * ========================== */

    // GET /api/pergunta/{id}/respostas
    public function actionRespostas($id)
    {
        return Resposta::find()
            ->where(['id_pergunta' => $id])
            ->all();
    }

    // GET /api/pergunta/search/{texto}
    public function actionSearch($texto)
    {
        return Pergunta::find()
            ->where(['like', 'pergunta', $texto])
            ->all();
    }

    /* ==========================
     * AUX
     * ========================== */
    protected function findModel($id)
    {
        if (($model = Pergunta::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Pergunta não encontrada');
    }
}
