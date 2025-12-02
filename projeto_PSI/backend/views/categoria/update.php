<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Categoria $model */

$this->title = 'Editar Categoria - ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Categorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="categoria-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
