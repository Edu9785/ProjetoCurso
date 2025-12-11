<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use common\models\JogosDefault;
use yii\web\NotFoundHttpException;

class JogodefaultController extends ActiveController
{
    public $modelClass = JogosDefault::class;

    // 1) GET /api/jogosdefault/count
    public function actionCount()
    {
        $total = JogosDefault::find()->count();
        return ['count' => (int)$total];
    }

    // 2) GET /api/jogosdefault/titulos
    public function actionTitulos()
    {
        return JogosDefault::find()
            ->select(['id', 'titulo'])
            ->asArray()
            ->all();
    }

    // 3) GET /api/jogosdefault/descricoes
    public function actionDescricoes()
    {
        return JogosDefault::find()
            ->select(['id', 'descricao'])
            ->asArray()
            ->all();
    }

    // 4) GET /api/jogosdefault/{id}/titulo
    public function actionTitulo($id)
    {
        $jogo = JogosDefault::find()
            ->select(['titulo'])
            ->where(['id' => $id])
            ->one();

        if (!$jogo) {
            throw new NotFoundHttpException("Jogo não encontrado.");
        }

        return $jogo;
    }

    // 5) PUT /api/jogosdefault/{id} — atualizar título
    public function actionPuttitulo($id)
    {
        $novo = \Yii::$app->request->post('titulo');

        $jogo = JogosDefault::findOne(['id' => $id]);

        if (!$jogo) {
            throw new NotFoundHttpException("Jogo não encontrado.");
        }

        $jogo->titulo = $novo;
        $jogo->save();

        return ['status' => 'título atualizado com sucesso'];
    }

    // 6) DELETE /api/jogosdefault/{id}
    public function actionDelporid($id)
    {
        return JogosDefault::deleteAll(['id' => $id]);
    }

    // 7) GET /api/jogosdefault/{id}/categorias
    public function actionCategorias($id)
    {
        $jogo = JogosDefault::findOne($id);
        if (!$jogo) {
            throw new NotFoundHttpException("Jogo não encontrado.");
        }

        return $jogo->categorias;
    }

    // 8) GET /api/jogosdefault/{id}/perguntas
    public function actionPerguntas($id)
    {
        $jogo = JogosDefault::findOne($id);
        if (!$jogo) {
            throw new NotFoundHttpException("Jogo não encontrado.");
        }

        return $jogo->jogosdefaultPerguntas;
    }
}
