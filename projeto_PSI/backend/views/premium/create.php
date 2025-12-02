<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Premium $model */

$this->title = 'Criar Premium';
$this->params['breadcrumbs'][] = ['label' => 'Premium', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Criar';
?>
<div class="premium-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
