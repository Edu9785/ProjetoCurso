<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Premium $model */

$this->title = 'Premium - ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Premiums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
\yii\web\YiiAsset::register($this);
?>
<div class="premium-view">

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem a certeza que deseja apagar este Premium?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nome',
            [
                    'attribute' => 'preco',
                    'label' => 'Preço',
            ],

        ],
    ]) ?>

</div>
