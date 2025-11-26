<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Tempo $model */

$this->title = 'Create Tempo';
$this->params['breadcrumbs'][] = ['label' => 'Tempos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tempo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
