<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Dificuldade $model */

$this->title = 'Create Dificuldade';
$this->params['breadcrumbs'][] = ['label' => 'Dificuldades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dificuldade-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
