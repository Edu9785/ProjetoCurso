<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\JogoworkshopSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jogoworkshop-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_jogador') ?>

    <?= $form->field($model, 'id_gestor') ?>

    <?= $form->field($model, 'id_dificuldade') ?>

    <?= $form->field($model, 'aprovacao') ?>

    <?php // echo $form->field($model, 'titulo') ?>

    <?php // echo $form->field($model, 'descricao') ?>

    <?php // echo $form->field($model, 'id_tempo') ?>

    <?php // echo $form->field($model, 'totalpontosjogo') ?>

    <?php // echo $form->field($model, 'imagem') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
