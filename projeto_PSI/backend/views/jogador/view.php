<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View /
/ @var $model common\models\Jogador /
/ @var string $role /
/ @var bool $isAdmin */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Jogadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jogador-view">

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                        'confirm' => 'Tem a certeza que quer apagar este Utilizador?',
                        'method' => 'post',
                ],
        ]) ?>

        <?php if ($isAdmin): ?>
            <?php if ($role === 'user'): ?>
                <?= Html::a('Promover', ['promote', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            <?php elseif ($role === 'manager'): ?>
                <?= Html::a('Despromover', ['demote', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
            <?php endif; ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                    'id',
                    [
                            'label' => 'Username',
                            'value' => $model->user->username,
                    ],
                    [
                            'label' => 'Email',
                            'value' => $model->user->email,
                    ],
                    'nome',
                    'idade',
                    'id_premium',
                    [
                            'label' => 'Role',
                            'value' => $role,
                    ],
            ],
    ]) ?>

</div>