<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Jogador $model */

$this->title = 'Perfil';

?>

<div class="container py-5" style="max-width: 1100px; width:100%;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0" style="color:#0A0A3B;">Perfil</h2>

        <div class="d-flex gap-2">
            <!-- Botão Editar -->
            <a href="<?= \yii\helpers\Url::to(['update', 'id' => $model->id]) ?>"
               class="btn btn-primary px-3 py-2"
               style="border-radius:6px;">
                Editar Perfil
            </a>

            <!-- Botão Logout -->
            <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'm-0']) ?>
            <?= Html::submitButton('Logout', [
                    'class' => 'btn btn-danger px-3 py-2',
                    'style' => 'border-radius:6px;',
            ]) ?>
            <?= Html::endForm() ?>
        </div>
    </div>

    <div class="text-center mb-4">

        <!-- Avatar -->
        <div class="rounded-circle mx-auto mb-3"
             style="width:150px;height:150px;background:#d9d9d9;display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-user fa-5x" style="color:#000;"></i>
        </div>

        <h3 class="fw-bold"><?= Html::encode($model->nome) ?></h3>
    </div>

    <!-- Campo Nome -->
    <div class="py-4 border-bottom d-flex align-items-center fs-5">
        <i class="fas fa-user me-3 fs-4"></i>
        <span class="fw-bold" style="color:#0A0A3B;">Nome</span>
        <span class="ms-auto"><?= Html::encode($model->nome) ?></span>
    </div>

    <!-- Campo Idade -->
    <div class="py-4 border-bottom d-flex align-items-center fs-5">
        <i class="fas fa-user me-3 fs-4"></i>
        <span class="fw-bold" style="color:#0A0A3B;">Idade</span>
        <span class="ms-auto"><?= Html::encode($model->idade) ?></span>
    </div>

    <!-- Campo Email -->
    <div class="py-4 border-bottom d-flex align-items-center fs-5">
        <i class="fas fa-at me-3 fs-4"></i>
        <span class="fw-bold" style="color:#0A0A3B;">Email</span>
        <span class="ms-auto"><?= Html::encode($model->user->email ?? '-') ?></span>
    </div>



</div>
