<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Premium $model */

$this->title = 'Create Premium';
$this->params['breadcrumbs'][] = ['label' => 'Premium', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="premium-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
