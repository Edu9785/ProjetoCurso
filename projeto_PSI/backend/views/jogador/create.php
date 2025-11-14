<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Jogador $model */

$this->title = 'Create Jogador';
$this->params['breadcrumbs'][] = ['label' => 'Jogadors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jogador-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
