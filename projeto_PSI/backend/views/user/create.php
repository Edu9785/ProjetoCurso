<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Criar Administrador';
$this->params['breadcrumbs'][] = ['label' => 'Administradors', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Criar';
?>
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
