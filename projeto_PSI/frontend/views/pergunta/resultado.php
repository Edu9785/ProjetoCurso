<?php

use yii\helpers\Html;

/** @var array $jogo */
/** @var int $totalPontos */

?>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Resultado Final</h1>
        <?= Html::a('← Voltar', ['jogosdefault/index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <!-- RESUMO -->
    <div class="row g-4 mb-4">

        <div class="col-md-6">
            <div class="card shadow-sm p-4 h-100 text-center">
                <h5 class="card-title">Pontuação</h5>
                <p class="display-5 fw-bold text-primary mb-0">
                    <?= $jogo['pontos'] ?>
                    <span class="fs-4 text-muted">/ <?= $totalPontos ?></span>
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm p-4 h-100 text-center">
                <h5 class="card-title">Perguntas acertadas</h5>
                <p class="display-5 fw-bold text-success mb-0">
                    <?= count($jogo['acertos']) ?>
                </p>
            </div>
        </div>

    </div>

    <!-- PERGUNTAS CERTAS -->
    <div class="card shadow-sm p-4 mb-4">
        <h4 class="mb-3 text-success">Perguntas corretas</h4>

        <?php if (!empty($jogo['acertos'])): ?>
            <ul class="list-group list-group-flush">
                <?php foreach ($jogo['acertos'] as $idPergunta): ?>
                    <?php $p = \common\models\Pergunta::findOne($idPergunta); ?>
                    <li class="list-group-item">
                        ✔️ <?= Html::encode($p->pergunta) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-muted">Não acertaste nenhuma pergunta.</p>
        <?php endif; ?>
    </div>

    <!-- PERGUNTAS ERRADAS -->
    <div class="card shadow-sm p-4">
        <h4 class="mb-3 text-danger">Perguntas erradas</h4>

        <?php if (!empty($jogo['erros'])): ?>
            <ul class="list-group list-group-flush">
                <?php foreach ($jogo['erros'] as $erro): ?>
                    <?php $p = \common\models\Pergunta::findOne($erro['pergunta_id']); ?>
                    <li class="list-group-item">
                        <strong><?= Html::encode($p->pergunta) ?></strong><br>
                        <span class="text-muted">
                            A tua resposta: <?= Html::encode($erro['resposta_escolhida']) ?>
                        </span><br>
                        <span class="text-success fw-bold">
                            Resposta correta: <?= Html::encode($erro['resposta_correta']) ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-muted">Não erraste nenhuma pergunta 👏</p>
        <?php endif; ?>
    </div>

    <div class="mt-4 text-center">
        <?= Html::a('Voltar ao início', ['site/index'], ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

</div>
