<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Jogador $model */

$this->title = 'Update Jogador: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jogadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jogador-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
