<?php

namespace backend\modules\api\controllers;

class JogodefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
