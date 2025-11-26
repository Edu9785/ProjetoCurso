<?php
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

    <div class="sidebar">
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

        <nav class="mt-2">
            <?php
            $menuItems = [];

            // Mostrar "Administradores" apenas se for admin
            if (Yii::$app->user->can('admin')) {
                $menuItems[] = [
                        'label' => 'Administradores',
                        'icon' => 'users-cog',
                        'url' => ['/user/index'],
                ];
            }

            // Esses itens todos podem ser visíveis para manager e admin
            $menuItems = array_merge($menuItems, [
                    [
                            'label' => 'Jogadores',
                            'icon' => 'user',
                            'url' => ['/jogador/index'],
                    ],
                    [
                            'label' => 'Jogos',
                            'icon' => 'gamepad',
                            'url' => ['/jogo/index'],
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
            ]);

            echo \hail812\adminlte\widgets\Menu::widget([
                    'items' => $menuItems,
            ]);
            ?>
        </nav>
    </div>
</aside>
