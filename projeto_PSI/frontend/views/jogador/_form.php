<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Jogador $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jogador-form d-flex justify-content-center mt-5">

    <div class="card shadow-lg p-4" style="width: 100%; max-width: 750px; border-radius: 20px; background: var(--light);">
        <h3 class="text-center mb-4 fw-semi-bold" style="color: var(--dark);">Registro do Jogador</h3>

        <?php $form = ActiveForm::begin(['options' => ['class' => 'needs-validation']]); ?>

        <?= $form->field($model->user, 'username')->textInput([
                'maxlength' => true,
                'class' => 'form-control custom-input',
                'placeholder' => 'Nome de usuário'
        ]) ?>

        <?= $form->field($model, 'nome')->textInput([
                'maxlength' => true,
                'class' => 'form-control custom-input',
                'placeholder' => 'Nome completo'
        ]) ?>

        <?= $form->field($model, 'idade')->textInput([
                'class' => 'form-control custom-input',
                'placeholder' => 'Idade'
        ]) ?>

        <?= $form->field($model->user, 'email')->textInput([
                'maxlength' => true,
                'class' => 'form-control custom-input',
                'placeholder' => 'E-mail'
        ]) ?>

        <div class="d-grid mt-4">
            <?= Html::submitButton('Guardar', [
                    'class' => 'btn btn-primary btn-lg',
                    'style' => 'border-radius: 12px; font-weight: 600;'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

