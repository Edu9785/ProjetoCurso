<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
?>

<div class="site-login d-flex flex-column align-items-center"
     style="min-height: 100vh; background: #f4f8fb; padding-top: 80px;">

    <h1 class="text-center mb-5 fw-bold"
        style="color: #001133; font-size: 2.8rem;">
        <?= Html::encode($this->title) ?>
    </h1>

    <div style="width: 680px;">

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username')
                ->textInput([
                        'autofocus' => true,
                        'placeholder' => 'Nome de utilizador',
                        'class' => 'form-control custom-input',
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

        <?= $form->field($model, 'password')
                ->passwordInput([
                        'placeholder' => 'Palavra-passe',
                        'class' => 'form-control custom-input',
                        'style' => '
                        font-size: 1.3rem;
                        padding: 18px 16px;
                        height: 68px;
                        border-radius: 10px;
                    '
                ])
                ->label('Palavra-passe', [
                        'class' => 'fw-semibold mb-2',
                        'style' => 'font-size: 1.3rem;'
                ]) ?>

        <div class="text-end mt-2">
            <?= Html::a('Esqueceste-te da senha?', ['site/request-password-reset'], [
                    'class' => 'text-decoration-none',
                    'style' => 'color: #4d37b6; font-weight: 600; font-size: 1.1rem;'
            ]) ?>
        </div>

        <div class="form-group text-center mt-5">
            <?= Html::submitButton('Iniciar Sessão', [
                    'class' => 'btn w-100 py-4',
                    'name' => 'login-button',
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

        <div class="text-center mt-5"
             style="color: #555; font-size: 1.3rem;">
            Ainda não tens conta?
            <?= Html::a('<strong>Junta-te a nós!</strong>', ['site/signup'], [
                    'class' => 'text-decoration-none',
                    'style' => 'color: #4d37b6; font-weight: 700;'
            ]) ?>
        </div>
    </div>
</div>
