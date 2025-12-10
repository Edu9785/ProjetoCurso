<?php

use yii\helpers\Html;
use common\models\Categoria;

/** @var yii\web\View $this */
/** @var common\models\JogosDefault $model */

$this->title = $model->titulo;
\yii\web\YiiAsset::register($this);

// Caminho da imagem
$imagem = $model->imagem
        ? Yii::getAlias("@web/uploads/{$model->imagem}")
        : "https://via.placeholder.com/600x600?text=Sem+Imagem";
?>

<div class="container py-5">

    <div class="row align-items-start">

        <!-- IMAGEM -->
        <div class="col-lg-5">
            <div class="bg-light rounded shadow-sm" style="height: 350px; overflow: hidden;">
                <img src="<?= $imagem ?>" class="w-100 h-100" style="object-fit: cover;">
            </div>
        </div>

        <!-- INFO DO JOGO -->
        <div class="col-lg-7 ps-lg-5">

            <h1 class="fw-bold mb-3"><?= Html::encode($model->titulo) ?></h1>

            <p class="fw-semi-bold text-dark mb-2"><strong>Categorias:</strong></p>
            <div class="mb-3">
                <?php if (!empty($model->categorias)) : ?>
                    <?php foreach ($model->categorias as $categoria) : ?>
                            <?= Html::encode($categoria->categoria) ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span class="text-muted">Nenhuma categoria atribuída</span>
                <?php endif; ?>
            </div>

            <p class="fw-semi-bold text-dark mb-1">Dificuldade</p>
            <p class="mb-3"><?= $model->dificuldade->dificuldade ?? '-' ?></p>

            <p class="fw-semi-bold text-dark mb-1">Total de Pontos</p>
            <p class="mb-3"><?= Html::encode($model->totalpontosjogo) ?></p>

            <p class="fw-semi-bold text-dark mb-1">Tempo</p>
            <p class="mb-3"><?= $model->tempo->quantidadetempo ?? '-' ?> segundos</p>

            <p class="mt-4 text-dark" style="max-width: 500px;">
                <?= Html::encode($model->descricao) ?>
            </p>

            <!-- Botão PLAY -->
            <a href="<?= \yii\helpers\Url::to(['pergunta/view']) ?>" class="btn btn-primary px-5 py-2 mt-4 fw-semi-bold" style="border-radius: 8px;">
                Play
            </a>
        </div>

    </div>

</div>