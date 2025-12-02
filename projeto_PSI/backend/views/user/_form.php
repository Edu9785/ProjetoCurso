<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'username')->textInput() ?>

    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => 'Escolha uma password (mínimo 6 caracteres)'
        ]) ?>
    <?php else: ?>
        <?= $form->field($model, 'password')->passwordInput([
                'value' => '',
                'placeholder' => 'Preencha para alterar a password (deixe vazio para manter a atual)'
        ]) ?>
    <?php endif; ?>
    <?= $form->field($model, 'email')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
