<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
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
    // GET /api/dificuldades/count
    // ----------------------------
    public function actionCount()
    {
        return [
            'total' => Dificuldade::find()->count()
        ];
    }
}
