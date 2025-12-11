<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\JogosDefault $jogo */
/** @var common\models\Pergunta[] $perguntasDoJogo */

$this->title = 'Jogo: ' .$jogo->titulo ;
$this->params['breadcrumbs'][] = ['label' => 'Jogos Defaults', 'url' => ['jogosdefault/index']];
$this->params['breadcrumbs'][] = $jogo->titulo;
?>

<div class="pergunta-view">

    <p><b>Total pontos do jogo:</b> <?= Html::encode($jogo->totalpontosjogo ?? '-') ?></p>
    <p><b>Descrição:</b> <?= Html::encode($jogo->descricao ?? '-') ?></p>

    <!-- Botões Editar e Apagar -->
    <?php if (!empty($jogo->jogosdefaultPerguntas)): ?>
        <p class="mt-3 mb-4">
            <?= Html::a(
                    'Editar Perguntas',
                    ['pergunta/update', 'id' => $jogo->jogosdefaultPerguntas[0]->id_pergunta],
                    ['class'=>'btn btn-warning me-2']
            ) ?>
            <?= Html::a(
                    'Apagar Todas as Perguntas',
                    ['pergunta/delete-todas', 'id' => $jogo->id],
                    [
                            'class'=>'btn btn-danger',
                            'data-confirm'=>'Tem certeza que deseja apagar todas as perguntas deste jogo?',
                            'data-method'=>'post'
                    ]
            ) ?>
        </p>
    <?php endif; ?>


    <hr>

    <!-- Lista de perguntas -->
    <?php if (!empty($jogo)): ?>
        <?php foreach ($jogo->jogosdefaultPerguntas as $defaultpergunta): ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Pergunta: <?= Html::encode($defaultpergunta->pergunta->pergunta) ?></h4>
                    <p class="card-text"><b>Valor da pergunta:</b> <?= Html::encode($defaultpergunta->pergunta->valor) ?></p>

                    <h5>Respostas:</h5>
                    <ul>
                        <?php foreach ($defaultpergunta->pergunta->respostas as $resposta): ?>
                            <li>
                                <?= Html::encode($resposta->resposta) ?>
                                <?php if ($resposta->correta): ?>
                                    <span style="color:green;">(Correta)</span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Não há perguntas registadas para este jogo.</p>
    <?php endif; ?>


</div>
