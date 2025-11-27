<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Premium $model */

$this->title = 'Update Premium: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Premium', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="premium-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
