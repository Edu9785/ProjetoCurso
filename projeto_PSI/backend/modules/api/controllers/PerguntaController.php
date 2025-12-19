<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use common\models\Pergunta;
use common\models\JogosDefault;

class PerguntaController extends Controller
{
    public function actionJogar($id_jogo)
    {
        $jogo = JogosDefault::findOne($id_jogo);

        if (!$jogo) {
            throw new NotFoundHttpException('Jogo não encontrado');
        }

        $perguntas = [];

        foreach ($jogo->jogosdefaultPerguntas as $defaultPergunta) {
            $pergunta = $defaultPergunta->pergunta;

            if ($pergunta) {
                $respostas = [];

                foreach ($pergunta->respostas as $resposta) {
                    $respostas[] = [
                        'id'       => $resposta->id,
                        'resposta' => $resposta->resposta,
                        'correta'  => (bool)$resposta->correta,
                    ];
                }

                $perguntas[] = [
                    'id'        => $pergunta->id,
                    'pergunta'  => $pergunta->pergunta,
                    'valor'     => $pergunta->valor,
                    'respostas' => $respostas,
                ];
            }
        }

        if (empty($perguntas)) {
            throw new NotFoundHttpException('Este jogo não tem perguntas');
        }

        return [
            'id_jogo'   => $jogo->id,
            'titulo'    => $jogo->titulo,
            'perguntas' => $perguntas
        ];
    }
}
