<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Pergunta $model */

$this->title = 'Criar Pergunta';
$this->params['breadcrumbs'][] = ['label' => 'Perguntas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Criar';
?>
<div class="pergunta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
