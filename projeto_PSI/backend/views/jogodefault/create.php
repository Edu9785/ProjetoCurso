<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Jogodefault $model */

$this->title = 'Create Jogodefault';
$this->params['breadcrumbs'][] = ['label' => 'Jogodefaults', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jogodefault-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
