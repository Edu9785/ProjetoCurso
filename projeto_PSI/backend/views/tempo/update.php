<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Tempo $model */

$this->title = 'Update Tempo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tempos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tempo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
