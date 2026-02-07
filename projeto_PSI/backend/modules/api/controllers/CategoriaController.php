<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use Yii;
use common\models\Categoria;
use common\models\JogosDefault;

class CategoriaController extends ActiveController
{
    public $modelClass = 'common\models\Categoria';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator']['formats']['application/json'] =
            \yii\web\Response::FORMAT_JSON;

        return $behaviors;
    }

    // --------------------------
    // GET /api/categoria
    // --------------------------
    public function actionIndex()
    {
        return Categoria::find()->all();
    }

    // --------------------------
    // GET /api/categoria/{id}
    // --------------------------
    public function actionView($id)
    {
        $model = Categoria::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Categoria não encontrada');
        }

        return $model;
    }

    // --------------------------
    // GET /api/categoria/nomes
    // --------------------------
    public function actionNomes()
    {
        return Categoria::find()
            ->select(['categoria'])
            ->asArray()
            ->all();
    }

    // --------------------------
    // GET /api/categoria/{id}/jogosdefault
    // MASTER / DETAIL
    // --------------------------
    public function actionJogosdefault($id)
    {
        $categoria = Categoria::findOne($id);

        if (!$categoria) {
            throw new NotFoundHttpException('Categoria não encontrada');
        }

        return JogosDefault::find()
            ->joinWith('categorias')
            ->where(['categoria.id' => $id])
            ->all();
    }

    // --------------------------
    // POST /api/categoria
    // --------------------------
    public function actionCreate()
    {
        $model = new Categoria();
        $model->load(Yii::$app->request->post(), '');

        if ($model->save()) {
            return ['success' => true, 'categoria' => $model];
        }

        return ['success' => false, 'errors' => $model->errors];
    }

    // --------------------------
    // PUT /api/categoria/{id}
    // --------------------------
    public function actionUpdate($id)
    {
        $model = Categoria::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Categoria não encontrada');
        }

        $model->load(Yii::$app->request->bodyParams, '');

        if ($model->save()) {
            return ['success' => true, 'categoria' => $model];
        }

        return ['success' => false, 'errors' => $model->errors];
    }

    // --------------------------
    // DELETE /api/categoria/{id}
    // --------------------------
    public function actionDelete($id)
    {
        $model = Categoria::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Categoria não encontrada');
        }

        $model->delete();

        return [
            'success' => true,
            'message' => 'Categoria eliminada'
        ];
    }
}
