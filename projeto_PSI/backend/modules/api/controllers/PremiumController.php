<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use common\models\Premium;
use yii\web\NotFoundHttpException;
use yii\filters\auth\HttpBearerAuth;

class PremiumController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }


    // 1) GET /api/premium
    public function actionIndex()
    {
        return Premium::find()
            ->select(['id', 'nome', 'preco', 'duracao'])
            ->asArray()
            ->all();
    }

    // 2) GET /api/premium/{id}
    public function actionView($id)
    {
        $premium = Premium::find()
            ->where(['id' => $id])
            ->one();

        if (!$premium) {
            throw new NotFoundHttpException("Premium não encontrado.");
        }

        return $premium;
    }

    // 3) GET /api/premium/nomes
    public function actionNomes()
    {
        return Premium::find()
            ->select(['id', 'nome', 'preco'])
            ->asArray()
            ->all();
    }
}
