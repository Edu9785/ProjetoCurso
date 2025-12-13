<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;
use common\models\JogosDefault;
use common\models\Pergunta;

class JogodefaultController extends ActiveController
{
    public $modelClass = 'common\models\JogosDefault';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator']['formats']['application/json'] =
            \yii\web\Response::FORMAT_JSON;

        return $behaviors;
    }

    // ------------------------------------
    // GET /api/jogosdefault
    // ------------------------------------
    public function actionIndex()
    {
        $query = JogosDefault::find();

        // filtro por dificuldade
        if ($dif = Yii::$app->request->get('dificuldade')) {
            $query->andWhere(['id_dificuldade' => $dif]);
        }

        // pesquisa por título
        if ($search = Yii::$app->request->get('search')) {
            $query->andWhere(['like', 'titulo', $search]);
        }

        return $query->with(['dificuldade', 'tempo', 'categorias'])->all();
    }

    // ------------------------------------
    // GET /api/jogosdefault/{id}
    // ------------------------------------
    public function actionView($id)
    {
        $model = JogosDefault::find()
            ->where(['id' => $id])
            ->with(['dificuldade', 'tempo', 'categorias'])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('Jogo não encontrado');
        }

        return $model;
    }

    // ------------------------------------
    // GET /api/jogosdefault/{id}/perguntas
    // MASTER / DETAIL
    // ------------------------------------
    public function actionPerguntas($id)
    {
        $jogo = JogosDefault::findOne($id);

        if (!$jogo) {
            throw new NotFoundHttpException('Jogo não encontrado');
        }

        return Pergunta::find()
            ->joinWith('jogosdefaultPerguntas')
            ->where(['jogosdefault_pergunta.id_jogo' => $id])
            ->with('respostas')
            ->all();
    }

    // ------------------------------------
    // POST /api/jogosdefault
    // (com upload de imagem)
    // ------------------------------------
    public function actionCreate()
    {
        $model = new JogosDefault();

        $model->load(Yii::$app->request->post(), '');

        $model->imageFile = UploadedFile::getInstanceByName('imageFile');

        if ($model->upload() && $model->save()) {
            return [
                'success' => true,
                'jogo' => $model
            ];
        }

        return [
            'success' => false,
            'errors' => $model->errors
        ];
    }

    // ------------------------------------
    // PUT /api/jogosdefault/{id}
    // ------------------------------------
    public function actionUpdate($id)
    {
        $model = JogosDefault::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Jogo não encontrado');
        }

        $model->load(Yii::$app->request->bodyParams, '');

        $model->imageFile = UploadedFile::getInstanceByName('imageFile');

        if ($model->upload() && $model->save()) {
            return [
                'success' => true,
                'jogo' => $model
            ];
        }

        return [
            'success' => false,
            'errors' => $model->errors
        ];
    }

    // ------------------------------------
    // DELETE /api/jogosdefault/{id}
    // ------------------------------------
    public function actionDelete($id)
    {
        $model = JogosDefault::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Jogo não encontrado');
        }

        $model->delete();

        return [
            'success' => true,
            'message' => 'Jogo default eliminado'
        ];
    }
}
