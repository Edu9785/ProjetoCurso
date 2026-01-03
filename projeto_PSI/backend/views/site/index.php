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

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Últimos Utilizadores</h3>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-striped">
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
        </div>


    </div>
</div>
