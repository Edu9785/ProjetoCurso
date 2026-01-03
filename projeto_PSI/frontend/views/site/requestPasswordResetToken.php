<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\PasswordResetRequestForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Pedido para alterar palavra-passe';

?>
<div class="d-flex flex-column align-items-center"
     style="min-height: 85vh; background: #f4f8fb; padding-top: 40px; padding-bottom: 20px;">

    <h1 class="text-center mb-4 fw-bold"
        style="color: #001133; font-size: 2.8rem;">
        <?= Html::encode($this->title) ?>
    </h1>

    <p class="text-center mb-5" style="color: #555; font-size: 1.25rem; max-width: 600px;">
        Por favor, preencha o seu email, um link para alterar a sua password vai ser enviado para lá.
    </p>

    <div style="width: 680px;">

        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

        <?= $form->field($model, 'email')
                ->textInput([
                        'autofocus' => true,
                        'placeholder' => 'O teu email',
                        'class' => 'form-control',
                        'style' => '
                    font-size: 1.3rem;
                    padding: 18px 16px;
                    height: 68px;
                    border-radius: 10px;
                '
                ])
                ->label('Email', [
                        'class' => 'fw-semibold mb-2',
                        'style' => 'font-size: 1.3rem;'
                ]) ?>

        <div class="form-group text-center mt-4">
            <?= Html::submitButton('Enviar link', [
                    'class' => 'btn w-100 py-4',
                    'style' => '
                        background-color: #4d37b6;
                        color: #fff;
                        border-radius: 12px;
                        font-weight: 700;
                        font-size: 1.5rem;
                        height: 72px;
                        transition: 0.3s;
                        letter-spacing: 0.5px;
                    '
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

