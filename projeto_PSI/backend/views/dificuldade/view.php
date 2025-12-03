<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Dificuldade $model */

$this->title = 'Dificuldade - ' .$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dificuldades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
\yii\web\YiiAsset::register($this);
?>
<div class="dificuldade-view">

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem a certeza que deseja apagar esta Dificuldade?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'dificuldade',
        ],
    ]) ?>

</div>
