<?php
use yii\helpers\Html;

/** @var array $jogo */
?>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Resultado Final</h1>
        <?= Html::a('← Voltar', ['jogosdefault/index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <div class="row g-4 mb-4">

        <!-- Pontos e acertos -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3 h-100">
                <h5 class="card-title">Pontos Totais</h5>
                <p class="display-6 text-primary fw-bold"><?= $jogo['pontos'] ?></p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm p-3 h-100">
                <h5 class="card-title">Perguntas Acertadas</h5>
                <p class="display-6 text-success fw-bold"><?= count($jogo['acertos']) ?></p>
            </div>
        </div>

    </div>

    <div class="card shadow-sm p-4">
        <h4 class="mb-3">Perguntas corretas</h4>

        <?php if (!empty($jogo['acertos'])): ?>
            <ul class="list-group list-group-flush">
                <?php foreach ($jogo['acertos'] as $idPergunta): ?>
                    <?php $p = \common\models\Pergunta::findOne($idPergunta); ?>
                    <li class="list-group-item"><?= Html::encode($p->pergunta) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-muted">Não acertaste nenhuma pergunta.</p>
        <?php endif; ?>
    </div>

    <div class="mt-4">
        <?= Html::a('Voltar aos Inicio', ['site/index'], ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

</div>
