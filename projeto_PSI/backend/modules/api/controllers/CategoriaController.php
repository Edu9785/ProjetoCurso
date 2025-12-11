<?php

namespace backend\modules\api\controllers;

use common\models\Categoria;
use yii\rest\ActiveController;

class CategoriaController extends ActiveController
{
    public $modelClass = 'common\models\Categoria';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCategoria()
    {
        return Categoria::find()
            ->select(['id', 'categoria'])
            ->asArray()
            ->all();
    }
}
