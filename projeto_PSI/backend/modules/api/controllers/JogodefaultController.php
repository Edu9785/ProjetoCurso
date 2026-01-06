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

        return $query->with(['dificuldade', 'categorias'])->all();
    }

    // ------------------------------------
    // GET /api/jogosdefault/{id}
    // ------------------------------------
    public function actionView($id)
    {
        $model = JogosDefault::find()
            ->where(['id' => $id])
            ->with(['dificuldade', 'categorias'])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('Jogo não encontrado');
        }

        return $model;
    }

    public function actionByTitulo($titulo)
    {
        $jogos = JogosDefault::find()
            ->where(['like', 'titulo', $titulo])
            ->with(['dificuldade', 'categorias'])
            ->all();

        if (empty($jogos)) {
            throw new NotFoundHttpException('Nenhum jogo encontrado com esse título');
        }

        return [
            'data' => $jogos
        ];
    }
}
