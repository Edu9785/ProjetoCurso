<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Resposta $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="resposta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'resposta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correta')->textInput() ?>

    <?= $form->field($model, 'id_pergunta')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
