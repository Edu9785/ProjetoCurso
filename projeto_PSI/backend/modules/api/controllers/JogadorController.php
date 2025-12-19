<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use Yii;
use common\models\Jogador;
use common\models\User;

class JogadorController extends ActiveController
{
    public $modelClass = 'common\models\Jogador';

    // GET /api/jogador
    public function actionIndex()
    {
        return Jogador::find()
            ->with('user')
            ->all();
    }

    // GET /api/jogador/{id}
    public function actionView($id)
    {
        $jogador = Jogador::find()
            ->with('user')
            ->where(['id' => $id])
            ->one();

        if (!$jogador) {
            throw new NotFoundHttpException('Jogador não encontrado');
        }

        return $jogador;
    }

    // PUT / PATCH /api/jogador/{id}
    public function actionUpdate($id)
    {
        $jogador = $this->findModel($id);
        $user = $jogador->user;

        $data = Yii::$app->request->bodyParams;

        // -------- Jogador --------
        $jogador->load($data, '');

        // -------- User --------
        if (isset($data['username'])) {
            if (User::find()
                ->where(['username' => $data['username']])
                ->andWhere(['<>', 'id', $user->id])
                ->exists()) {
                return ['success' => false, 'error' => 'Username já em uso'];
            }
            $user->username = $data['username'];
        }

        if (isset($data['email'])) {
            if (User::find()
                ->where(['email' => $data['email']])
                ->andWhere(['<>', 'id', $user->id])
                ->exists()) {
                return ['success' => false, 'error' => 'Email já em uso'];
            }
            $user->email = $data['email'];
        }

        if ($jogador->validate() && $user->validate()) {
            $jogador->save(false);
            $user->save(false);

            return [
                'success' => true,
                'jogador' => $jogador,
                'user' => [
                    'username' => $user->username,
                    'email' => $user->email
                ]
            ];
        }

        return [
            'success' => false,
            'errors' => [
                'jogador' => $jogador->errors,
                'user' => $user->errors
            ]
        ];
    }


    protected function findModel($id)
    {
        if (($model = Jogador::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Jogador não encontrado');
    }
}
