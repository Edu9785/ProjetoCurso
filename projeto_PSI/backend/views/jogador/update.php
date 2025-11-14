<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Jogador $model */

$this->title = 'Update Jogador: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jogadors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jogador-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
