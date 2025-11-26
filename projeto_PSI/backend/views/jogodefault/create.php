<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Jogodefault $model */

$this->title = 'Create Jogodefault';
$this->params['breadcrumbs'][] = ['label' => 'Jogodefaults', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jogodefault-create">

    <?= $this->render('_form', [
            'model' => $model,
            'dificuldades' => $dificuldades,
            'tempos' => $tempos,
    ]) ?>

</div>
