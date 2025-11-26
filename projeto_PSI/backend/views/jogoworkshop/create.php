<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Jogoworkshop $model */

$this->title = 'Create Jogoworkshop';
$this->params['breadcrumbs'][] = ['label' => 'Jogoworkshops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jogoworkshop-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
