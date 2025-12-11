<?php

namespace backend\modules\api\controllers;

use common\models\Dificuldade;
use yii\rest\ActiveController;

class DificuldadeController extends ActiveController
{
    public $modelClass = 'common\models\Dificuldade';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDificuldade()
    {
        return Dificuldade::find()
            ->select(['id', 'dificuldade'])
            ->asArray()
            ->all();
    }

}
