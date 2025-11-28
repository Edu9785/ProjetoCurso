<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\JogosDefault $model */

$this->title = 'Update Jogos Default: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jogos Defaults', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jogos-default-update">

    <?= $this->render('_form', [
            'model' => $model,
            'dificuldades' => $dificuldades,
            'tempos' => $tempos,
            'categorias' => $categorias,
    ]) ?>

</div>
