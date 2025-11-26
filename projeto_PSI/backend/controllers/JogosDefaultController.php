<?php

namespace backend\controllers;

class JogosDefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
