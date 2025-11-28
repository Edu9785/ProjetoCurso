<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\JogosDefault $model */

$this->title = 'Criar Jogos Default';
$this->params['breadcrumbs'][] = ['label' => 'Jogos Defaults', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jogos-default-create">

    <?= $this->render('_form', [
            'model' => $model,
            'dificuldades' => $dificuldades,
            'tempos' => $tempos,
            'categorias' => $categorias,
    ]) ?>

</div>
