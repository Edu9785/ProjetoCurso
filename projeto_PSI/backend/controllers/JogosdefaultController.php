<?php

namespace backend\controllers;

use common\models\JogosDefault;
use common\models\JogosDefaultSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * JogosdefaultController implements the CRUD actions for JogosDefault model.
 */
class JogosdefaultController extends Controller
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
     * Lists all JogosDefault models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new JogosDefaultSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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

        $dificuldades = \common\models\Dificuldade::find()->all();
        $tempos = \common\models\Tempo::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            // pegar o ficheiro enviado
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            // SE existir ficheiro → fazer uploads
            if ($model->imageFile) {
                if ($model->upload()) {
                    // uploads OK: agora guarda o nome da imagem na BD
                    $model->save(false);
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'dificuldades' => $dificuldades,
            'tempos' => $tempos,
        ]);
    }

    /**
     * Updates an existing Jogodefault model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $dificuldades = \common\models\Dificuldade::find()->all();
        $tempos = \common\models\Tempo::find()->all();

        // guardar nome da imagem antiga
        $oldImage = $model->imagem;

        if ($model->load(Yii::$app->request->post())) {

            // obter nova imagem (se houver)
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile) {
                // fazer uploads da nova imagem
                if ($model->upload()) {
                    // uploads OK → nova imagem substitui
                    $model->save(false);
                }
            } else {
                // sem nova imagem → manter antiga
                $model->imagem = $oldImage;
                $model->save(false);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'dificuldades' => $dificuldades,
            'tempos' => $tempos,
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
