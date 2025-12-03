<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Pergunta $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pergunta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pergunta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valor')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
