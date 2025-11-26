<?php
use yii\helpers\Url;
use yii\helpers\Html;

$user = Yii::$app->user->identity;
$username = $user ? Html::encode($user->username) : 'Visitante';
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="Desafia te Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Desafia-te</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a class="d-block"><?= $username ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    [
                        'label' => 'Administradores',
                        'icon' => 'users-cog',
                        'url' => ['/user/index'],
                    ],
                        [
                                'label' => 'Jogadores',
                                'icon' => 'user',
                                'url' => ['/jogador/index'],
                        ],
                        [
                                'label' => 'Jogos Default',
                                'icon' => 'gamepad',
                                'url' => ['/jogodefault/index'],
                        ],
                        [
                                'label' => 'Jogos Workshop',
                                'icon' => 'gamepad',
                                'url' => ['/jogoworkshop/index'],
                        ],
                        [
                                'label' => 'Categorias',
                                'icon' => 'tags',
                                'url' => ['/categoria/index'],
                        ],
                        [
                                'label' => 'Dificuldades',
                                'icon' => 'tachometer-alt',
                                'url' => ['/dificuldade/index'],
                        ],
                        [
                                'label' => 'Premiums',
                                'icon' => 'gem',
                                'url' => ['/premium/index'],
                        ],
                        [
                                'label' => 'Temporizadores',
                                'icon' => 'clock',
                                'url' => ['/tempo/index'],
                        ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>