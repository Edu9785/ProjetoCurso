<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Dificuldade $model */

$this->title = 'Criar Dificuldade';
$this->params['breadcrumbs'][] = ['label' => 'Dificuldades', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Criar';
?>
<div class="dificuldade-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
