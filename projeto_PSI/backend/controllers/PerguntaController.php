<?php

namespace backend\controllers;

use common\models\JogosDefault;
use Yii;
use common\models\Resposta;
use common\models\JogosdefaultPergunta;
use common\models\Pergunta;
use common\models\PerguntaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PerguntaController implements the CRUD actions for Pergunta model.
 */
class PerguntaController extends Controller
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
     * Lists all Pergunta models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PerguntaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pergunta model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = Pergunta::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException("Pergunta não encontrada.");
        }

        // Obtem respostas ligadas a essa pergunta
        $respostas = $model->respostas; // precisa do relacionamento no model Pergunta

        // Obtem o jogo ao qual a pergunta pertence (via pivot)
        $jogo = $model->jogosDefault ?? null;

        return $this->render('view', [
            'model' => $model,
            'respostas' => $respostas,
            'jogo' => $jogo,
        ]);
    }

    /**
     * Creates a new Pergunta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $jogo = JogosDefault::findOne($id);
        $totalPontos = $jogo->totalpontosjogo;

        if (Yii::$app->request->isPost) {
            $dadosPerguntas = Yii::$app->request->post('PerguntaTexto', []);
            $dadosValores = Yii::$app->request->post('PerguntaValor', []);
            $dadosRespostas = Yii::$app->request->post('RespostaTexto', []);
            $corretas = Yii::$app->request->post('RespostaCorreta', []);

            foreach ($dadosPerguntas as $index => $perguntaTexto) {
                if (trim($perguntaTexto) === '') continue;

                // Cria nova pergunta
                $modelPergunta = new Pergunta();
                $modelPergunta->pergunta = $perguntaTexto;
                $modelPergunta->valor = $dadosValores[$index] ?? 0;
                if (!$modelPergunta->save()) {
                    Yii::error($modelPergunta->errors);
                    continue;
                }

                // Liga ao jogo
                $jogosPergunta = new JogosdefaultPergunta();
                $jogosPergunta->id_jogo = $id;
                $jogosPergunta->id_pergunta = $modelPergunta->id;
                $jogosPergunta->save();

                // Salva respostas
                if (!empty($dadosRespostas[$index])) {
                    foreach ($dadosRespostas[$index] as $respIndex => $respostaTxt) {
                        if (trim($respostaTxt) === '') continue;

                        $resp = new Resposta();
                        $resp->id_pergunta = $modelPergunta->id;
                        $resp->resposta = $respostaTxt;
                        $resp->correta = (isset($corretas[$index]) && $corretas[$index] == $respIndex) ? 1 : 0;
                        $resp->save();
                    }
                }
            }

            return $this->redirect(['pergunta/view', 'id' => $id]);
        }

        return $this->render('create', [
            'totalPontos' => $totalPontos,
        ]);
    }

    /**
     * Updates an existing Pergunta model.
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
     * Deletes an existing Pergunta model.
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
     * Finds the Pergunta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Pergunta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pergunta::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
