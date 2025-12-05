<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Pergunta $model */

$this->params['breadcrumbs'][] = ['label' => 'Perguntas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Criar';
?>
<div class="pergunta-create">


    <?= $this->render('_form', [
            'totalPontos' => $totalPontos,
    ]) ?>

</div>
