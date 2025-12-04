<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class JogadorController extends ActiveController
{
    public $modelClass = 'common\models\Jogador';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionNomes()
    {
        $jogadoresmodel = new $this->modelClass;
        $recs = $jogadoresmodel::find()->select(['nome'])->all();
        return $recs;
    }
}
