<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Resposta $model */

$this->title = 'Criar Resposta';
$this->params['breadcrumbs'][] = ['label' => 'Respostas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Criar';
?>
<div class="resposta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
