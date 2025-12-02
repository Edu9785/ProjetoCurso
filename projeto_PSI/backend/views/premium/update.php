<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Premium $model */

$this->title = 'Editar Premium: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Premium', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="premium-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
