<?php

namespace frontend\controllers;

use common\models\Jogador;
use Yii;
use common\models\Premium;
use common\models\PremiumSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PremiumController implements the CRUD actions for Premium model.
 */
class PremiumController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Premium models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PremiumSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionComprar($id)
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            Yii::$app->session->setFlash('error', 'Tem de estar logado para comprar.');
            return $this->redirect(['site/login']);
        }

        $jogador = Jogador::findOne(['id_user' => $user->getId()]);

        $jogador->id_premium = $id;

        if ($jogador->save()) {
            Yii::$app->session->setFlash('success', "Compras-te o Premium com sucesso");
        } else {
            Yii::$app->session->setFlash('error', 'Ocorreu um erro ao processar a compra.');
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['premium/index']);
    }


    protected function findModel($id)
    {
        if (($model = Premium::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
