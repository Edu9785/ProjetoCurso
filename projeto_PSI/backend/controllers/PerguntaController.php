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
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [

                    // 🚪 Visitantes
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],

                    // ✅ Gestor e Admin
                    [
                        'allow' => true,
                        'roles' => ['manager', 'admin'],
                    ],
                ],
                'denyCallback' => function () {
                    if (Yii::$app->user->isGuest) {
                        Yii::$app->session->setFlash(
                            'error',
                            'Tem de iniciar sessão para aceder ao Back Office.'
                        );

                        return Yii::$app->response->redirect(['/site/login']);
                    }

                    throw new \yii\web\ForbiddenHttpException(
                        'Não tem permissões para aceder a esta área.'
                    );
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
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
    public function actionView($id_jogo)
    {

        $jogo = JogosDefault::findOne($id_jogo);

        if (!$jogo) {
            throw new NotFoundHttpException('Jogo não encontrado.');
        }

        return $this->render('view', [
            'jogo' => $jogo
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

        // Garantir que $modelsPerguntas existe, mesmo para jogo novo
        $modelsPerguntas = $jogo->jogosdefaultPerguntas
            ? array_map(fn($jp) => $jp->pergunta, $jogo->jogosdefaultPerguntas)
            : [];

        if (Yii::$app->request->isPost) {
            $dadosPerguntas = Yii::$app->request->post('PerguntaTexto', []);
            $dadosValores = Yii::$app->request->post('PerguntaValor', []);
            $dadosRespostas = Yii::$app->request->post('RespostaTexto', []);
            $corretas = Yii::$app->request->post('RespostaCorreta', []);

            foreach ($dadosPerguntas as $index => $perguntaTexto) {
                if (trim($perguntaTexto) === '') continue;

                $modelPergunta = new Pergunta();
                $modelPergunta->pergunta = $perguntaTexto;
                $modelPergunta->valor = $dadosValores[$index] ?? 0;
                $modelPergunta->save();

                $jogosPergunta = new JogosdefaultPergunta();
                $jogosPergunta->id_jogo = $id;
                $jogosPergunta->id_pergunta = $modelPergunta->id;
                $jogosPergunta->save();

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

            return $this->redirect(['pergunta/view', 'id_jogo' => $id]);
        }

        return $this->render('_form', [
            'modelsPerguntas' => $modelsPerguntas,
            'totalPontos' => $totalPontos,
            'id_jogo' => $jogo->id,
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
        $modelPergunta = Pergunta::findOne($id);
        if (!$modelPergunta) throw new NotFoundHttpException("Pergunta não encontrada");

        $jp = $modelPergunta->jogosdefaultPerguntas[0] ?? null;
        $jogo = $jp ? $jp->jogo : null;
        if (!$jogo) throw new NotFoundHttpException("Jogo não encontrado");

        $totalPontos = $jogo->totalpontosjogo;

        // buscar todas as perguntas do jogo
        $modelsPerguntas = Pergunta::find()
            ->joinWith('jogosdefaultPerguntas')
            ->where(['jogosdefault_pergunta.id_jogo' => $jogo->id])
            ->orderBy('pergunta.id ASC')
            ->all();

        if (Yii::$app->request->isPost) {
            $dadosPerguntas = Yii::$app->request->post('PerguntaTexto', []);
            $dadosValores   = Yii::$app->request->post('PerguntaValor', []);
            $dadosRespostas = Yii::$app->request->post('RespostaTexto', []);
            $corretas       = Yii::$app->request->post('RespostaCorreta', []);

            $errors = [];

            // 🔥 Validação da soma dos pontos
            $somaPontos = array_sum(array_map('intval', $dadosValores));
            if ($somaPontos != $totalPontos) {
                if (Yii::$app->request->isAjax) {
                    return $this->asJson([
                        'success' => false,
                        'errors' => "A soma dos pontos das perguntas ($somaPontos) deve ser IGUAL ao total do jogo ($totalPontos)."
                    ]);
                } else {
                    Yii::$app->session->setFlash('error', "A soma dos pontos das perguntas ($somaPontos) deve ser IGUAL ao total do jogo ($totalPontos).");
                    return $this->refresh();
                }
            }

            // apagar perguntas removidas no formulário
            foreach ($modelsPerguntas as $idx => $model) {
                if (!array_key_exists($idx, $dadosPerguntas)) {
                    Resposta::deleteAll(['id_pergunta' => $model->id]);
                    JogosdefaultPergunta::deleteAll(['id_jogo' => $jogo->id, 'id_pergunta' => $model->id]);
                    $model->delete();
                    unset($modelsPerguntas[$idx]);
                }
            }

            $modelsPerguntas = array_values($modelsPerguntas);

            foreach ($dadosPerguntas as $index => $texto) {
                if (trim($texto) === '') continue;

                $respostas = $dadosRespostas[$index] ?? [];
                $respostasValidas = array_filter($respostas, fn($r) => trim($r) !== '');

                if (empty($respostasValidas)) {
                    $errors[] = "A pergunta n.º " . ($index + 1) . " precisa ter pelo menos uma resposta.";
                    continue;
                }

                if (!isset($corretas[$index]) || !isset($respostasValidas[$corretas[$index]])) {
                    $errors[] = "A pergunta n.º " . ($index + 1) . " precisa ter uma resposta correta marcada.";
                    continue;
                }

                $modelAtual = $modelsPerguntas[$index] ?? new Pergunta();
                $modelAtual->pergunta = $texto;
                $modelAtual->valor = $dadosValores[$index] ?? 0;
                $modelAtual->save();

                if (!isset($modelsPerguntas[$index])) {
                    $rel = new JogosdefaultPergunta();
                    $rel->id_jogo = $jogo->id;
                    $rel->id_pergunta = $modelAtual->id;
                    $rel->save();
                }

                Resposta::deleteAll(['id_pergunta' => $modelAtual->id]);
                foreach ($respostasValidas as $i => $rTxt) {
                    $resp = new Resposta();
                    $resp->id_pergunta = $modelAtual->id;
                    $resp->resposta = $rTxt;
                    $resp->correta = ($corretas[$index] == $i) ? 1 : 0;
                    $resp->save();
                }
            }

            if (!empty($errors)) {
                if (Yii::$app->request->isAjax) {
                    return $this->asJson([
                        'success' => false,
                        'errors' => implode('<br>', $errors)
                    ]);
                } else {
                    Yii::$app->session->setFlash('error', implode('<br>', $errors));
                    return $this->refresh();
                }
            }

            if (Yii::$app->request->isAjax) {
                return $this->asJson([
                    'success' => true,
                    'redirect' => \yii\helpers\Url::to(['pergunta/view', 'id_jogo' => $jogo->id])
                ]);
            }

            return $this->redirect(['pergunta/view', 'id_jogo' => $jogo->id]);
        }

        return $this->render('_form', [
            'modelsPerguntas' => $modelsPerguntas,
            'totalPontos' => $totalPontos,
            'id_jogo' => $jogo->id,
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

    public function actionDeleteTodas($id)
    {
        $jogo = JogosDefault::findOne($id);

        if (!$jogo) {
            throw new NotFoundHttpException("Jogo não encontrado.");
        }

        foreach ($jogo->jogosdefaultPerguntas as $jp) {

            // Apagar respostas da pergunta
            Resposta::deleteAll(['id_pergunta' => $jp->id_pergunta]);

            // Apagar ligação jogo-pergunta
            $jp->delete();

            // Apagar a pergunta
            $jp->pergunta->delete();
        }

        Yii::$app->session->setFlash('success', 'Todas as perguntas do jogo foram apagadas.');

        return $this->redirect(['jogosdefault/view', 'id' => $jogo->id]);
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
