<?php
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\helpers\Html;

$premiums = $dataProvider->getModels();
?>

<div class="container py-5">
    <h1 class="mb-4 text-center">Planos Premium</h1>

    <div class="row g-4">
        <?php foreach ($premiums as $premium): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h4 class="card-title"><?= Html::encode($premium->nome) ?></h4>

                        <h2 class="text-primary my-3">
                            € <?= number_format($premium->preco, 2, ',', '.') ?>
                        </h2>

                        <p class="card-text">
                            Descrição do plano premium pode ser adicionada aqui.
                        </p>

                        <a href="#" class="btn btn-primary px-4 py-2 mt-2">
                            Comprar
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
