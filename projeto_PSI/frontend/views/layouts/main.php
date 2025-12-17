<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web') ?>/img/icon_logodesafiate.png">


    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>

    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->



    <?php
    NavBar::begin([
            'brandLabel' => Html::img('@web/img/logodesafia.jpg', [
                    'alt' => Yii::$app->name,
                    'width' => '90',  // define a largura em pixels
                    'height' => '70px' // mantém a proporção
            ]),
        //'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        //'brandUrl' => Yii::$app->urlManager->createUrl(['/site/index']),
        'options' => [
            'class' => 'navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0',
        ],
    ]);
    $menuItems = [
            ['label' => 'Home', 'url' => Yii::$app->homeUrl],
        ['label' => 'Premium', 'url' => ['/premium/index']],
        ['label' => 'Jogos', 'url' => ['/jogosdefault/index']],
    ];
    /*
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    }*/

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto p-4 p-lg-0'],
        'items' => $menuItems,
    ]);
    if (Yii::$app->user->isGuest) {

        // --- USER DESLOGADO → mostra Login ---
        echo Html::tag(
                'div',
                Html::a('Login', ['/site/login'], [
                        'class' => 'btn btn-primary py-4 px-lg-5 d-none d-lg-block'
                ]),
                ['class' => 'd-flex']
        );

    } else {

        // --- USER LOGADO → mostra o nome do user e link para jogador/index ---
        echo Html::tag(
                'div',
                Html::a(
                        Yii::$app->user->identity->username,
                        ['/jogador/view'],
                        [
                                'class' => 'btn btn-primary d-inline-flex align-items-center',
                                'style' => 'border-radius:5px; padding: 8px 36px;'  // padding horizontal aumentado
                        ]
                ),
                ['class' => 'd-flex me-3 align-items-center']
        );

        // Botão Logout
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
                . Html::endForm();
    }
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
</main>

<!-- Footer Start -->
<div class="container-fluid bg-dark text-light pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">

    <div class="container py-5">
        <div class="row g-5 justify-content-center text-center">

            <!-- Quick Links -->
            <div class="col-lg-4 col-md-6">
                <h4 class="text-white mb-3">Links Rápidos</h4>
                <a class="btn btn-link d-block" href="#">Política de Privacidade</a>
                <a class="btn btn-link d-block" href="#">Termos & Condições</a>
                <a class="btn btn-link d-block" href="#">Ajuda & FAQs</a>
            </div>

            <!-- Contactos -->
            <div class="col-lg-4 col-md-6">
                <h4 class="text-white mb-3">Contacto</h4>
                <p class="mb-2">
                    <i class="fa fa-map-marker-alt me-2"></i>
                    Portugal
                </p>
                <p class="mb-2">
                    <i class="fa fa-phone-alt me-2"></i>
                    +351 914 574 853
                </p>
                <p class="mb-2">
                    <i class="fa fa-envelope me-2"></i>
                    suporte@desafia.pt
                </p>

                <!-- Social -->
                <div class="d-flex justify-content-center pt-3">
                    <a class="btn btn-outline-light btn-social mx-1" href="#">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- Copyright -->
    <div class="container">
        <div class="copyright">
            <div class="row justify-content-center text-center">
                <div class="col-12">
                    &copy; <?= date('Y') ?> <strong>Desafia</strong>. Todos os direitos reservados.
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Footer End -->




<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= Yii::getAlias('@web'). '/lib/wow/wow.min.js';?>"></script>
<script src="<?= Yii::getAlias('@web'). '/lib/easing/easing.min.js';?>"></script>
<script src="<?= Yii::getAlias('@web'). '/lib/waypoints/waypoints.min.js';?>"></script>
<script src="<?= Yii::getAlias('@web'). '/lib/owlcarousel/owl.carousel.min.js';?>"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
