<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Tempo $model */

$this->title = 'Editar Temporizador: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Temporizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="tempo-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
