<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Jogador $model */

$this->title = 'Editar Perfil: ' . $model->id;
?>
<div class="jogador-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
