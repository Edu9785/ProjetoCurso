
<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Categoria[] $categorias */
/** @var common\models\Premium[] $premiums */
?>


<!-- Slide Estático -->
<div class="container-fluid p-0 mb-5 position-relative">
    <img class="img-fluid w-100" src="<?= Yii::getAlias('@web/img/homepage2.png') ?>" alt="Slide 1">

    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
         style="background: rgba(24, 29, 56, .7);">
        <div class="container">
            <div class="row justify-content-start">
                <div class="col-sm-10 col-lg-8">
                    <h5 class="text-white mb-3 animated slideInDown">
                        Diverte-te!
                    </h5>
                    <h1 class="display-3 text-white animated slideInDown">
                        Aprende ao Jogar
                    </h1>
                    <p class="fs-5 text-white mb-4 pb-2">
                        Descobre jogos educativos organizados por categorias e dificuldades.
                    </p>
                    <a href="<?= \yii\helpers\Url::to(['jogosdefault/index']) ?>"
                       class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">
                        Ir para os Jogos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Premium Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center px-3">Premium</h6>
            <h1 class="mb-5">Nossos Premiums</h1>
        </div>

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



 <!-- Team Start -->
 <div class="container-xxl py-5">
     <div class="container">
         <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
             <h6 class="section-title bg-white text-center px-3">Criadores</h6>
             <h1 class="mb-5">Os Nossos Criadores</h1>
         </div>

         <!-- ADICIONEI justify-content-center -->
         <div class="row g-4 justify-content-center">

             <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                 <div class="team-item bg-light">
                     <div class="overflow-hidden">
                         <img class="img-fluid" src="img/Eduardo.jpg" alt="">
                     </div>
                     <div class="text-center p-4">
                         <h5 class="mb-0">Eduardo Oliveira</h5>
                     </div>
                 </div>
             </div>

             <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                 <div class="team-item bg-light">
                     <div class="overflow-hidden">
                         <img class="img-fluid" src="img/Dinis.png" alt="">
                     </div>
                     <div class="text-center p-4">
                         <h5 class="mb-0">Dinis Ruivo</h5>
                     </div>
                 </div>
             </div>

             <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                 <div class="team-item bg-light">
                     <div class="overflow-hidden">
                         <img class="img-fluid" src="img/Rafael.jpeg" alt="">
                     </div>
                     <div class="text-center p-4">
                         <h5 class="mb-0">Rafael Rodrigues</h5>
                     </div>
                 </div>
             </div>

         </div>
     </div>
 </div>
 <!-- Team End -->