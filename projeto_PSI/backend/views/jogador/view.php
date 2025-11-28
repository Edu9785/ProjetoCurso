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
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                        'confirm' => 'Are you sure you want to delete this jogador?',
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