
<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Categoria[] $categorias */
/** @var common\models\Premium[] $premiums */
?>


 <!-- Carousel Start -->
    <div class="container p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/carousel-1.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Best Online Courses</h5>
                                <h1 class="display-3 text-white animated slideInDown">The Best Online Learning Platform</h1>
                                <p class="fs-5 text-white mb-4 pb-2">Vero elitr justo clita lorem. Ipsum dolor at sed stet sit diam no. Kasd rebum ipsum et diam justo clita et kasd rebum sea sanctus eirmod elitr.</p>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Ir Categoria</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/carousel-2.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Best Online Courses</h5>
                                <h1 class="display-3 text-white animated slideInDown">Get Educated Online From Your Home</h1>
                                <p class="fs-5 text-white mb-4 pb-2">Vero elitr justo clita lorem. Ipsum dolor at sed stet sit diam no. Kasd rebum ipsum et diam justo clita et kasd rebum sea sanctus eirmod elitr.</p>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Ir Categorias</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->




 <!-- Categories Start -->
 <div class="container-xxl py-5 category">
     <div class="container">
         <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
             <h6 class="section-title bg-white text-center text-primary px-3">Categorias</h6>
             <h1 class="mb-5">As Nossas Categorias</h1>
         </div>

         <div class="row g-4 justify-content-center">
             <?php foreach ($categorias as $categoria): ?>
                 <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
                     <div class="card border-0 shadow-sm text-center h-100">
                         <div class="card-body">
                             <h5 class="card-title"><?= Html::encode($categoria->categoria) ?></h5>
                             <br>
                             <a href="<?= \yii\helpers\Url::to(['categoria/view', 'id' => $categoria->id]) ?>" class="btn btn-outline-primary px-4 py-2">Ver Detalhes</a>
                         </div>
                     </div>
                 </div>
             <?php endforeach; ?>
         </div>
     </div>
 </div>
 <!-- Categories End -->



 <!-- Premium Start -->
 <div class="container-xxl py-5">
     <div class="container">
         <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
             <h6 class="section-title bg-white text-center text-primary px-3">Premium</h6>
             <h1 class="mb-5">Nossos Premiums</h1>
         </div>
         <div class="row g-4 justify-content-center">
             <?php foreach ($premiums as $premium): ?>
                 <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                     <div class="course-item bg-light text-center h-100">
                         <div class="p-4 pb-4">
                             <h3 class="mb-2">€ <?= number_format($premium->preco, 2, ',', '.') ?></h3>
                             <h5 class="mb-3"><?= Html::encode($premium->nome) ?></h5>
                             <a href="#" class="btn btn-buy px-4 py-2">Comprar</a>
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
             <h6 class="section-title bg-white text-center text-primary px-3">Criadores</h6>
             <h1 class="mb-5">Os Nossos Criadores</h1>
         </div>

         <!-- ADICIONEI justify-content-center -->
         <div class="row g-4 justify-content-center">

             <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                 <div class="team-item bg-light">
                     <div class="overflow-hidden">
                         <img class="img-fluid" src="img/team-1.jpg" alt="">
                     </div>
                     <div class="text-center p-4">
                         <h5 class="mb-0">Instructor Name</h5>
                     </div>
                 </div>
             </div>

             <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                 <div class="team-item bg-light">
                     <div class="overflow-hidden">
                         <img class="img-fluid" src="img/team-2.jpg" alt="">
                     </div>
                     <div class="text-center p-4">
                         <h5 class="mb-0">Instructor Name</h5>
                     </div>
                 </div>
             </div>

             <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                 <div class="team-item bg-light">
                     <div class="overflow-hidden">
                         <img class="img-fluid" src="img/team-4.jpg" alt="">
                     </div>
                     <div class="text-center p-4">
                         <h5 class="mb-0">Instructor Name</h5>
                     </div>
                 </div>
             </div>

         </div>
     </div>
 </div>
 <!-- Team End -->
