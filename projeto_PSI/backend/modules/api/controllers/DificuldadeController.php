<?php

namespace backend\modules\api\controllers;

use common\models\JogosDefault;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;
use common\models\Dificuldade;

class DificuldadeController extends ActiveController
{
    public $modelClass = 'common\models\Dificuldade';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator']['formats']['application/json'] =
            Response::FORMAT_JSON;

        return $behaviors;
    }

    // ----------------------------
    // GET /api/dificuldades/nomes
    // (para spinner Android)
    // ----------------------------
    public function actionNomes()
    {
        return Dificuldade::find()->all();
    }

    // ----------------------------
// GET /api/dificuldade/{id}/jogosdefault
// MASTER / DETAIL
// ----------------------------
    public function actionJogosdefault($id)
    {
        // Buscar a dificuldade
        $dificuldade = Dificuldade::findOne($id);

        if (!$dificuldade) {
            throw new NotFoundHttpException('Dificuldade não encontrada');
        }

        // Buscar todos os jogos que tenham esta dificuldade
        return JogosDefault::find()
            ->where(['id_dificuldade' => $id])
            ->all();
    }
}
