<?php

namespace frontend\controllers;

use common\models\Jogador;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JogadorController implements the CRUD actions for Jogador model.
 */
class JogadorController extends Controller
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
                            'Tem de iniciar sessão para aceder à sua página.'
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
     * Lists all Jogador models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $userId = \Yii::$app->user->id;
        $model = Jogador::findOne(['id_user' => $userId]);
        $userModel = $model->user; // pega o modelo User relacionado

        if ($this->request->isPost) {
            $post = $this->request->post();
            $loadJogador = $model->load($post);
            $loadUser = $userModel->load($post);

            if ($loadJogador && $loadUser && $model->save() && $userModel->save()) {
                \Yii::$app->session->setFlash('success', 'Perfil atualizado com sucesso!');
                return $this->refresh();
            }
        }

        return $this->render('index', [
            'model' => $model,
            'userModel' => $userModel,
        ]);
    }

    /**
     * Displays a single Jogador model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $userId = \Yii::$app->user->id;
        $model = Jogador::findOne(['id_user' => $userId]);
        $userModel = $model->user; // pega o modelo User relacionado

        if ($this->request->isPost) {
            $post = $this->request->post();
            $loadJogador = $model->load($post);
            $loadUser = $userModel->load($post);

            if ($loadJogador && $loadUser && $model->save() && $userModel->save()) {
                \Yii::$app->session->setFlash('success', 'Perfil atualizado com sucesso!');
                return $this->refresh();
            }
        }

        return $this->render('index', [
            'model' => $model,
            'userModel' => $userModel,
        ]);
    }
    /**
     * Updates an existing Jogador model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $user = $model->user;

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $user->load($this->request->post());

            $isValid = $model->validate();
            $isValid = $user->validate() && $isValid;

            if ($isValid) {
                $model->save(false);
                $user->save(false);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Jogador model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $jogador = Jogador::findOne($id);

        $user = $jogador->user;

        $user->status = User::STATUS_DELETED;

        $user->save(false);

        Yii::$app->session->setFlash('success', 'Conta apagada');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Jogador model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Jogador the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Jogador::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
