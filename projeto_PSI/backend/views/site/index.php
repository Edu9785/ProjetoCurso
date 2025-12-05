<?php

use yii\db\Query;

$this->title = 'Home';

$totalAdmins = (new Query())
        ->from('auth_assignment')
        ->where(['item_name' => 'admin'])
        ->count();

$totalPlayers = (new Query())
        ->from('auth_assignment')
        ->where(['item_name' => 'user'])
        ->count();

$totalManagers = (new Query())
        ->from('auth_assignment')
        ->where(['item_name' => 'manager'])
        ->count();

?>

<div class="container-fluid">
    <div class="row">

        <div class="col-md-4 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                    'title' => $totalAdmins,
                    'text' => 'Administradores',
                    'icon' => 'fas fa-user-shield',
                    'theme' => 'info'
            ]) ?>
        </div>

        <div class="col-md-4 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                    'title' => $totalManagers,
                    'text' => 'Gestores',
                    'icon' => 'fas fa-user-tie',
                    'theme' => 'warning'
            ]) ?>
        </div>

        <div class="col-md-4 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                    'title' => $totalPlayers,
                    'text' => 'Jogadores',
                    'icon' => 'fas fa-users',
                    'theme' => 'success'
            ]) ?>
        </div>

    </div>
</div>
