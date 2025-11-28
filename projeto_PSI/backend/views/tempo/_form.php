<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Tempo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tempo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'quantidadetempo')->label('Quantidade de Tempo (em segundos)')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
