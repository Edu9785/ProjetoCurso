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

$lastUsers = (new Query())
        ->select([
                'user.username',
                'user.email',
                'user.created_at'
        ])
        ->from('user')
        ->innerJoin(
                'auth_assignment',
                'auth_assignment.user_id = user.id'
        )
        ->where(['auth_assignment.item_name' => 'user']) // 👈 só frontend users
        ->orderBy(['user.created_at' => SORT_DESC])
        ->limit(5)
        ->all();

$this->registerCss("
    .small-box .small-box-footer .fa-arrow-circle-right {
        display: none !important;
    }
    .small-box .small-box-footer:empty::after {
        content: ' ';
        visibility: hidden;
    }
");

$jogos = (new Query())
        ->select([
                'j.id',
                'j.titulo',
                'd.dificuldade',
                't.quantidadetempo AS tempo',
                "GROUP_CONCAT(c.categoria SEPARATOR ', ') AS categorias"
        ])
        ->from(['j' => 'jogosdefault'])
        ->leftJoin(['d' => 'dificuldade'], 'd.id = j.id_dificuldade')
        ->leftJoin(['t' => 'tempo'], 't.id = j.id_tempo')
        ->leftJoin(['jc' => 'jogosdefault_categoria'], 'jc.id_jogo = j.id')
        ->leftJoin(['c' => 'categoria'], 'c.id = jc.id_categoria')
        ->groupBy('j.id')
        ->orderBy(['j.id' => SORT_DESC])
        ->limit(5)
        ->all();
?>
<div class="container-fluid">
    <div class="row">

        <div class="col-md-4 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                    'title' => $totalAdmins,
                    'text' => 'Administradores',
                    'icon' => 'fas fa-user-shield',
                    'theme' => 'info',
                    'linkText' => false,
                    'linkUrl' => false,
            ]) ?>
        </div>

        <div class="col-md-4 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                    'title' => $totalManagers,
                    'text' => 'Gestores',
                    'icon' => 'fas fa-user-tie',
                    'theme' => 'warning',
                    'linkText' => false,
                    'linkUrl' => false,
            ]) ?>
        </div>

        <div class="col-md-4 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                    'title' => $totalPlayers,
                    'text' => 'Jogadores',
                    'icon' => 'fas fa-users',
                    'theme' => 'success',
                    'linkText' => false,
                    'linkUrl' => false,
            ]) ?>
        </div>

        <div class="row dashboard-section">
            <div class="col-12 col-lg-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-clock mr-1"></i>
                            Últimos Utilizadores
                        </h3>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($lastUsers as $user): ?>
                                <tr>
                                    <td><?= $user['username'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= date('d/m/Y', $user['created_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-gamepad mr-1"></i>
                            Jogos Default
                        </h3>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Jogo</th>
                                <th>Dificuldade</th>
                                <th>Tempo</th>
                                <th>Categorias</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($jogos as $jogo): ?>
                                <tr>
                                    <td><strong><?= $jogo['titulo'] ?></strong></td>

                                    <td>
                                        <?php
                                        $badge = match ($jogo['dificuldade']) {
                                            'Fácil' => 'success',
                                            'Médio' => 'warning',
                                            'Difícil' => 'danger',
                                            default => 'secondary',
                                        };
                                        ?>
                                        <span class="badge badge-<?= $badge ?> badge-difficulty">
                                    <?= $jogo['dificuldade'] ?? '-' ?>
                                </span>
                                    </td>

                                    <td><?= $jogo['tempo'] ?? '-' ?> min</td>
                                    <td><?= $jogo['categorias'] ?? '-' ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>