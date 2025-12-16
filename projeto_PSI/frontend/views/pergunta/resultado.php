<?php
use yii\helpers\Html;

/** @var array $jogo */
?>

<div class="container py-5">

    <h1 class="mb-4">Resultado Final</h1>

    <p><strong>Pontos totais:</strong> <?= $jogo['pontos'] ?></p>
    <p><strong>Perguntas acertadas:</strong> <?= count($jogo['acertos']) ?></p>

    <hr>

    <h4>Perguntas corretas</h4>

    <?php if (!empty($jogo['acertos'])): ?>
        <ul>
            <?php foreach ($jogo['acertos'] as $idPergunta): ?>
                <?php $p = \common\models\Pergunta::findOne($idPergunta); ?>
                <li><?= Html::encode($p->pergunta) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-muted">Não acertaste nenhuma pergunta.</p>
    <?php endif; ?>

    <a href="<?= \yii\helpers\Url::to(['site/index']) ?>"
       class="btn btn-primary mt-4">
        Voltar ao início
    </a>

</div>
