<?php

namespace frontend\controllers;

use common\models\Categoria;
use common\models\Dificuldade;
use common\models\JogosDefault;
use common\models\JogosDefaultSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * JogosdefaultController implements the CRUD actions for JogosDefault model.
 */
class JogosdefaultController extends Controller
{
    public $viewPath = '@frontend/views/jogosdefault';
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
     * Lists all JogosDefault models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new JogosDefaultSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        // Buscar dados da BD
        $categorias = Categoria::find()->all();
        $dificuldades = Dificuldade::find()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categorias' => $categorias,
            'dificuldades' => $dificuldades,
        ]);
    }

    /**
     * Displays a single JogosDefault model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new JogosDefault model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new JogosDefault();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing JogosDefault model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing JogosDefault model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSearchAjax($q = '')
    {
        $query = JogosDefault::find();

        if (!empty($q)) {
            $query->andWhere(['like', 'titulo', $q]);
        }

        $jogos = $query->all();

        return $this->renderPartial('_jogos_grid', [
            'jogos' => $jogos
        ]);
    }


    /**
     * Finds the JogosDefault model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return JogosDefault the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JogosDefault::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
