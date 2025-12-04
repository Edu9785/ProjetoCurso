<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */

class JogodefaultController extends ActiveController
{
    public $modelClass = 'common\models\JogosDefault';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTitulos()
    {
        $jogodefaultsmodel = new $this->modelClass;
        $recs = $jogodefaultsmodel::find()->select(['titulo'])->all();
        return $recs;
    }

    public function actionDescricaos()
    {
        $jogodefaultsmodel = new $this->modelClass;
        $recs = $jogodefaultsmodel::find()->select(['descricao'])->all();
        return $recs;
    }

}
