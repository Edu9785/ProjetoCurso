<?php
use yii\helpers\Url;
use yii\helpers\Html;

$user = Yii::$app->user->identity;
$username = $user ? Html::encode($user->username) : 'Visitante';
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="Desafia te Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Desafia te</span>
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
                        'label' => 'Gestores',
                        'icon' => 'users-cog',
                        'url' => ['/gestores/index'],
                    ],
                        [
                                'label' => 'Jogadores',
                                'icon' => 'user',
                                'url' => ['/jogadors/index'],
                        ],
                        [
                                'label' => 'Jogos',
                                'icon' => 'gamepad',
                                'url' => ['/jogos/index'],
                        ],
                        [
                                'label' => 'Categorias',
                                'icon' => 'tags',
                                'url' => ['/categorias/index'],
                        ],
                        [
                                'label' => 'Dificuldades',
                                'icon' => 'tachometer-alt',
                                'url' => ['/dificuldades/index'],
                        ],
                        [
                                'label' => 'Premiums',
                                'icon' => 'gem',
                                'url' => ['/premiums/index'],
                        ],
                        [
                                'label' => 'Temporizadores',
                                'icon' => 'clock',
                                'url' => ['/temporizadores/index'],
                        ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>