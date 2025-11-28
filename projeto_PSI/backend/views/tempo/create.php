<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Tempo $model */

$this->title = 'Criar Temporizador';
$this->params['breadcrumbs'][] = ['label' => 'Temporizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tempo-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
