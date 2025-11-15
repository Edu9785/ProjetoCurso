<?php

namespace backend\controllers;

use yii;
use common\models\Jogador;
use common\models\JogadorSearch;
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
     * Lists all Jogador models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new JogadorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Jogador model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $userId = $model->user->id;

        $role = key(Yii::$app->authManager->getRolesByUser($userId));

        $isAdmin = Yii::$app->user->can('admin');

        return $this->render('view', [
            'model' => $model,
            'role' => $role,
            'isAdmin' => $isAdmin,
        ]);
    }

    /**
     * Creates a new Jogador model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Jogador();

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
        $model = $this->findModel($id);

        $userId = $model->id_user;

        Yii::$app->db->createCommand()
            ->delete('auth_assignment', ['user_id' => $userId])
            ->execute();

        $model->delete();

        Yii::$app->db->createCommand()
            ->delete('user', ['id' => $userId])
            ->execute();


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

    public function actionPromote($id)
    {
        $model = $this->findModel($id);
        $userId = $model->user->id;

        if (!Yii::$app->user->can('admin')) {
            throw new \yii\web\ForbiddenHttpException('Only admin can promote users.');
        }

        $auth = Yii::$app->authManager;

        // Remove todas as roles atuais do usuário
        $auth->revokeAll($userId);

        // Atribui a role 'gestor'
        $gestorRole = $auth->getRole('manager');
        $auth->assign($gestorRole, $userId);

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDemote($id)
    {
        $model = $this->findModel($id);
        $userId = $model->user->id;

        if (!Yii::$app->user->can('admin')) {
            throw new \yii\web\ForbiddenHttpException('Only admin can demote users.');
        }

        $auth = Yii::$app->authManager;

        // Remove todas as roles atuais do usuário
        $auth->revokeAll($userId);

        // Atribui a role 'user'
        $userRole = $auth->getRole('user');
        $auth->assign($userRole, $userId);

        return $this->redirect(['view', 'id' => $id]);
    }
}
