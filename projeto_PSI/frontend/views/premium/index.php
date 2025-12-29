<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$premiums = $dataProvider->getModels();
?>

<div class="container-fluid hero-section py-5 mb-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Premium</h1>
            </div>
        </div>
    </div>
</div>

<!-- Premium Start -->
<div class="container-xxl py-5">

    <div class="container">

        <div class="row g-4 justify-content-center">
            <?php foreach ($premiums as $premium): ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light text-center h-100">

                        <!-- IMAGEM -->
                        <?php if (!empty($premium->imagem)): ?>
                            <div class="overflow-hidden">
                                <img class="img-fluid"
                                     src="<?= Yii::getAlias('@web/uploads/' . $premium->imagem) ?>"
                                     alt="<?= Html::encode($premium->nome) ?>"
                                     style="height: 220px; object-fit: cover; width: 100%;">
                            </div>
                        <?php endif; ?>

                        <div class="p-4 pb-4">
                            <h3 class="mb-2">
                                € <?= number_format($premium->preco, 2, ',', '.') ?>
                            </h3>

                            <h5 class="mb-3">
                                <?= Html::encode($premium->nome) ?>
                            </h5>

                            <p class="card-text">
                                Descrição do plano premium pode ser adicionada aqui.
                            </p>

                            <a href="<?= \yii\helpers\Url::to(['premium/comprar', 'id' => $premium->id]) ?>"
                               class="btn btn-buy px-4 py-2">
                                Comprar
                            </a>

                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- Premium End -->
