<?php

namespace frontend\controllers;

use common\models\JogosDefault;
use yii;
use common\models\Pergunta;
use common\models\Resposta;
use common\models\JogosdefaultPergunta;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
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
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['user', 'manager'],
                    ],
                ],
                'denyCallback' => function () {
                    if (Yii::$app->user->isGuest) {
                        Yii::$app->session->setFlash(
                            'error',
                            'Tem de iniciar sessão para jogar'
                        );

                        return Yii::$app->response->redirect(['/site/login']);
                    }

                    throw new \yii\web\ForbiddenHttpException(
                        'Acesso negado.'
                    );
                },
            ],
        ];
    }

    /**
     * Lists all Pergunta models.
     *
     * @return string
     */
    /**
     * Displays a single Pergunta model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_jogo)
    {
        $session = Yii::$app->session;

        if (!$session->has('jogo')) {

            $jogosdefault = JogosDefault::findOne($id_jogo);
            $perguntas = [];

            foreach ($jogosdefault->jogosdefaultPerguntas as $defaultPergunta) {
                $jogoPerguntas = $defaultPergunta->pergunta;
                if ($jogoPerguntas) {
                    $arrayRespostas = [];
                    foreach ($jogoPerguntas->respostas as $resposta) {
                        $arrayRespostas[] = [
                            'id' => $resposta->id,
                            'resposta' => $resposta->resposta,
                            'correta' => $resposta->correta,
                        ];
                    }

                    $perguntas[] = [
                        'id' => $jogoPerguntas->id,
                        'pergunta' => $jogoPerguntas->pergunta,
                        'valor' => $jogoPerguntas->valor,
                        'respostas' => $arrayRespostas,
                    ];
                }
            }

            if (empty($perguntas)) {
                throw new NotFoundHttpException('Este jogo não tem perguntas associadas.');
            }

            $session->set('jogo', [
                'id_jogo'   => $id_jogo,
                'perguntas' => $perguntas,
                'contador'  => 0,
                'pontos'    => 0,
                'acertos'   => [],
            ]);
        }

        $jogo = $session->get('jogo');

        if ($jogo['contador'] >= count($jogo['perguntas'])) {
            return $this->redirect(['pergunta/resultado']);
        }

        // Pega a pergunta atual diretamente da sessão
        $pergunta = $jogo['perguntas'][$jogo['contador']];

        return $this->render('view', [
            'pergunta' => $pergunta
        ]);
    }



    public function actionResponder()
    {
        $session = Yii::$app->session;
        $jogo = $session->get('jogo');

        $idResposta = Yii::$app->request->post('id_resposta');
        $respostaEscolhida = Resposta::findOne($idResposta);

        if (!$respostaEscolhida) {
            return $this->redirect([
                'pergunta/view',
                'id_jogo' => $jogo['id_jogo']
            ]);
        }

        $pergunta = $respostaEscolhida->pergunta;

        $respostaCorreta = null;
        foreach ($pergunta->respostas as $r) {
            if ($r->correta) {
                $respostaCorreta = $r;
                break;
            }
        }

        if ($respostaEscolhida->correta) {
            $jogo['pontos'] += $pergunta->valor;
            $jogo['acertos'][] = $pergunta->id;
        } else {
            $jogo['erros'][] = [
                'pergunta_id' => $pergunta->id,
                'resposta_escolhida' => $respostaEscolhida->resposta,
                'resposta_correta' => $respostaCorreta ? $respostaCorreta->resposta : '—'
            ];
        }

        $jogo['contador']++;

        $session->set('jogo', $jogo);

        return $this->redirect([
            'pergunta/view',
            'id_jogo' => $jogo['id_jogo']
        ]);
    }



    public function actionResultado()
    {
        $session = Yii::$app->session;

        if (!$session->has('jogo')) {
            return $this->redirect(['site/index']);
        }

        $jogo = $session->get('jogo');


        $totalPontos = 0;
        foreach ($jogo['perguntas'] as $pergunta) {
            $totalPontos += $pergunta['valor'];
        }

        $session->remove('jogo');

        return $this->render('resultado', [
            'jogo'         => $jogo,
            'totalPontos'  => $totalPontos,
        ]);
    }


    /**
     * Creates a new Pergunta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionCreate()
    {
        $model = new Pergunta();

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
