<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Signup';
?>

<div class="site-signup d-flex flex-column align-items-center"
     style="min-height: 100vh; background: #f4f8fb; padding-top: 80px;">

    <h1 class="text-center mb-5 fw-bold"
        style="color: #001133; font-size: 2.8rem;">
        <?= Html::encode($this->title) ?>
    </h1>

    <div style="width: 680px;">

        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <!-- USERNAME -->
        <?= $form->field($model, 'username')
                ->textInput([
                        'autofocus' => true,
                        'placeholder' => 'Nome de utilizador',
                        'style' => '
                    font-size: 1.3rem;
                    padding: 18px 16px;
                    height: 68px;
                    border-radius: 10px;
                '
                ])
                ->label('Nome de utilizador', [
                        'class' => 'fw-semibold mb-2',
                        'style' => 'font-size: 1.3rem;'
                ]) ?>

        <!-- EMAIL -->
        <?= $form->field($model, 'email')
                ->textInput([
                        'placeholder' => 'Email',
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

        <!-- PASSWORD -->
        <?= $form->field($model, 'password')
                ->passwordInput([
                        'placeholder' => 'Senha',
                        'style' => '
                    font-size: 1.3rem;
                    padding: 18px 16px;
                    height: 68px;
                    border-radius: 10px;
                '
                ])
                ->label('Senha', [
                        'class' => 'fw-semibold mb-2',
                        'style' => 'font-size: 1.3rem;'
                ]) ?>

        <!-- BUTTON -->
        <div class="form-group text-center mt-5">
            <?= Html::submitButton('Criar Conta', [
                    'class' => 'btn w-100 py-4',
                    'name' => 'signup-button',
                    'style' => '
                    background-color: #00bcd4;
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

<?php
$this->registerCss("
    .btn:hover {
        background-color: #00acc1 !important;
        transform: scale(1.04);
    }
");
?>
