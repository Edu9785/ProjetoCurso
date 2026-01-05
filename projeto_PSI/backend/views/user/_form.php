<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Nome de Utilizador -->
    <?= $form->field($model, 'username')
            ->textInput()
            ->label('Nome de Utilizador') ?>

    <?php if ($model->isNewRecord): ?>

        <!-- Palavra-passe -->
        <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => 'Escolha uma palavra-passe (mínimo 6 caracteres)'
        ])->label('Palavra-passe') ?>

    <?php else: ?>

        <!-- Palavra-passe -->
        <?= $form->field($model, 'password')->passwordInput([
                'value' => '',
                'placeholder' => 'Preencha para alterar a palavra-passe (deixe vazio para manter a atual)'
        ])->label('Palavra-passe') ?>

    <?php endif; ?>

    <!-- Email -->
    <?= $form->field($model, 'email')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
