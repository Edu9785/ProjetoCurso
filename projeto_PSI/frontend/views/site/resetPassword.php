<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\ResetPasswordForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Alterar palavra-passe';

?>

<div class="d-flex flex-column align-items-center"
     style="min-height: 85vh; background: #f4f8fb; padding-top: 40px; padding-bottom: 20px;">

    <h1 class="text-center mb-4 fw-bold"
        style="color: #001133; font-size: 2.8rem;">
        <?= Html::encode($this->title) ?>
    </h1>

    <p class="text-center mb-5" style="color: #555; font-size: 1.25rem; max-width: 600px;">
        Escolhe a tua nova palavra-passe abaixo:
    </p>

    <div style="width: 680px;">

        <?php $form = ActiveForm::begin([
                'id' => 'reset-password-form',
        ]); ?>

        <div class="d-flex align-items-center gap-3">

            <div class="flex-grow-1">
                <?= $form->field($model, 'password')
                        ->passwordInput([
                                'id' => 'password-input',
                                'placeholder' => 'Nova palavra-passe',
                                'class' => 'form-control',
                                'style' => '
                            font-size: 1.3rem;
                            padding: 18px 16px;
                            border-radius: 10px;
                        '
                        ])
                        ->label('Palavra-passe', [
                                'class' => 'fw-semibold mb-2',
                                'style' => 'font-size: 1.3rem;'
                        ]) ?>
            </div>

            <div class="d-flex align-items-center">
                <i id="togglePasswordIcon" class="bi bi-eye-slash"
                   style="cursor: pointer; font-size: 1.5rem; transform: translateY(15px);"></i>
            </div>

        </div>

        <div class="form-group text-center mt-4">
            <?= Html::submitButton('Guardar', [
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

<!-- Script JS para alternar a palavra-passe -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const passwordInput = document.getElementById("password-input");
        const icon = document.getElementById("togglePasswordIcon");

        icon.addEventListener("click", function () {
            const isHidden = passwordInput.type === "password";
            passwordInput.type = isHidden ? "text" : "password";

            icon.classList.toggle("bi-eye");
            icon.classList.toggle("bi-eye-slash");
        });
    });
</script>
