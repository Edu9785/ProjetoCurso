<?php

namespace backend\controllers;

use common\models\JogosDefault;
use common\models\JogosDefaultSearch;
use common\models\JogosdefaultCategoria;
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
        $model = $this->findModel($id);

        $categorias = \common\models\Categoria::find()->all();

        return $this->render('view', [
            'model' => $model,
            'categorias' => $categorias
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
        $categorias = \common\models\Categoria::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile) {
                if (!$model->upload()) {
                    Yii::$app->session->setFlash('error', 'Erro ao enviar a imagem.');
                    return $this->render('create', [
                        'model' => $model,
                        'dificuldades' => $dificuldades,
                        'tempos' => $tempos,
                        'categorias' => $categorias,
                    ]);
                }

                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                if ($model->imageFile && $model->upload()) {
                    $model->save(false);
                } else {
                    $model->save(false);
                }

                if ($model->save(false)) {
                    $categoriasSelecionadas = Yii::$app->request->post('categorias', []);
                        foreach ($categoriasSelecionadas as $categoriaID) {
                            if ($categoriaID > 0) {
                                $categoriasJogo = new JogosdefaultCategoria();
                                $categoriasJogo->id_jogo = $model->id;
                                $categoriasJogo->id_categoria = $categoriaID;
                                $categoriasJogo->save(false);
                            }
                        }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
            'dificuldades' => $dificuldades,
            'tempos' => $tempos,
            'categorias' => $categorias,
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
        $categorias = \common\models\Categoria::find()->all();

        $oldImage = $model->imagem;

        $categoriasSelecionadas = array_map(function($cat) {
            return $cat->id_categoria;
        }, $model->jogosdefaultCategorias);

        if ($model->load(Yii::$app->request->post())) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile) {
                if ($model->upload()) {
                    $model->imagem = $model->imageFile->name;
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao enviar a imagem.');
                    return $this->render('update', [
                        'model' => $model,
                        'dificuldades' => $dificuldades,
                        'tempos' => $tempos,
                        'categorias' => $categorias,
                        'categoriasSelecionadas' => $categoriasSelecionadas,
                    ]);
                }
            } else {
                $model->imagem = $oldImage;
            }

            if ($model->save(false)) {
                JogosdefaultCategoria::deleteAll(['id_jogo' => $model->id]);

                $novasCategorias = Yii::$app->request->post('categorias', []);
                if (is_array($novasCategorias)) {
                    foreach ($novasCategorias as $catId) {
                        $jc = new JogosdefaultCategoria();
                        $jc->id_jogo = $model->id;
                        $jc->id_categoria = (int)$catId;
                        $jc->save(false);
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'dificuldades' => $dificuldades,
            'tempos' => $tempos,
            'categorias' => $categorias,
            'categoriasSelecionadas' => $categoriasSelecionadas,
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
        $model = $this->findModel($id);

        JogosdefaultCategoria::deleteAll(['id_jogo' => $model->id]);

        $model->delete();

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
