<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Dificuldade $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="dificuldade-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dificuldade')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
