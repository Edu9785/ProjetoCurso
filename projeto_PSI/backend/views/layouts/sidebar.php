<?php
use yii\helpers\Url;
use yii\helpers\Html;

$user = Yii::$app->user->identity;
$username = $user ? Html::encode($user->username) : 'Visitante';
?>

<aside class="main-sidebar elevation-4" style="background-color: #4d37b6;"> <!-- Azul claro -->

    <!-- Brand Logo -->
    <a href="<?= Url::home() ?>" class="brand-link" style="background-color: #4d37b6; color: #fff; padding-left: 5px;">
        <img src="<?= Yii::getAlias('@web') ?>/img/icon_logodesafiate.png"
             alt="Logo"
             style="height: 60px; width: auto; margin-right: 5px;">
        <span class="brand-text" style="position: relative; font-weight: bold;">Desafia-te</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= Yii::getAlias('@web') ?>/img/icon_user.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a class="d-block" style="color: #fff; font-weight: 500;"><?= $username ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?= \hail812\adminlte\widgets\Menu::widget([
                    'items' => [
                            ['label' =>
                                    'Administradores',
                                    'icon' => 'users-cog',
                                    'url' => ['/user/index'],
                                    'visible' => Yii::$app->user->can('admin')
                            ],

                            ['label' =>
                                    'Jogadores',
                                    'icon' => 'user',
                                    'url' => ['/jogador/index']
                            ],

                            ['label' =>
                                    'Jogos Default',
                                    'icon' => 'gamepad',
                                    'url' => ['/jogosdefault/index']
                            ],

                            ['label' =>
                                    'Categorias',
                                    'icon' => 'tags',
                                    'url' => ['/categoria/index']
                            ],

                            ['label' =>
                                    'Dificuldades',
                                    'icon' => 'tachometer-alt',
                                    'url' => ['/dificuldade/index']
                            ],

                            ['label' =>
                                    'Premiums',
                                    'icon' => 'gem',
                                    'url' => ['/premium/index']
                            ],
                            /*
                            ['label' =>
                                    'Temporizadores',
                                    'icon' => 'clock',
                                    'url' => ['/tempo/index']
                            ],
                            */
                    ],
                    'options' => ['class' => 'nav nav-pills nav-sidebar flex-column', 'data-widget' => 'treeview', 'role' => 'menu', 'data-accordion' => 'false'],
                    'itemOptions' => ['class' => 'nav-item'],
                    'linkTemplate' => '<a href="{url}" class="nav-link" style="color: #fff;">{icon} {label}</a>',
            ]) ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
