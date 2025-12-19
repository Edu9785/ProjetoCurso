<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Pergunta $model */

$this->title = 'Editar Pergunta: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Perguntas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
$this->params['hideTitle'] = true;
?>
<div class="pergunta-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
