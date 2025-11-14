<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        // Bibliotecas do template eLearning
        'lib/animate/animate.min.css',
        'lib/owlcarousel/assets/owl.carousel.min.css',

        // Bootstrap e estilos principais do template
        'css/bootstrap.min.css',
        'css/style.css',

        // CSS adicional do projeto Yii2
        'css/site.css',
    ];

    public $js = [
        // Bibliotecas JS do template eLearning
        'lib/wow/wow.min.js',
        'lib/easing/easing.min.js',
        'lib/waypoints/waypoints.min.js',
        'lib/owlcarousel/owl.carousel.min.js',

        // Script principal do template
        'js/main.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
