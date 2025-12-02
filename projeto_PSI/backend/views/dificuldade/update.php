<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Dificuldade $model */

$this->title = 'Editar Dificuldade - ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dificuldades', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="dificuldade-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
