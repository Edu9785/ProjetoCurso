<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Tempo $model */

$this->params['breadcrumbs'][] = ['label' => 'Temporizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
\yii\web\YiiAsset::register($this);
?>

<div class="tempo-view container mt-5">

    <!-- Card moderno -->
    <div class="card shadow-lg rounded-4 border-0" style="background: linear-gradient(135deg, #ffffff, #f0f8ff);">
        <div class="card-header bg-dark text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <span class="fs-5 fw-bold">Detalhes do Temporizador</span>
        </div>

        <div class="card-body">
            <?= DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => 'table table-striped table-bordered mb-0'],
                    'attributes' => [
                            [
                                    'attribute' => 'id',
                                    'label' => 'ID',
                                    'contentOptions' => ['class' => 'text-center fw-bold'],
                            ],
                            [
                                    'attribute' => 'quantidadetempo',
                                    'label' => 'Quantidade de Tempo',
                                    'contentOptions' => ['class' => 'text-center fw-bold text-primary fs-5'],
                            ],
                    ],
            ]) ?>

            <div class="mt-4 d-flex gap-3">
                <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                                'confirm' => 'Tem a certeza que deseja apagar este Temporizador?',
                                'method' => 'post',
                        ],
                ]) ?>
                <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
    </div>

</div>
