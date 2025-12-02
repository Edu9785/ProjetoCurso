<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Editar Administrador - ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Administradores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="user-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
