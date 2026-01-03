<?php
use yii\helpers\Html;

$this->registerCss("
  html, body { height: 100%; margin: 0; padding: 0; }
  
  .login-abs-wrapper {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90%;
    max-width: 1100px;     /* aumenta/reduz aqui para deixar o form maior/menor */
    box-sizing: border-box;
    padding: 12px;
  }

  .login-abs-wrapper .card { width: 100%; box-sizing: border-box; }

  .login-abs-wrapper .card-body { padding: 2rem; }
  .login-abs-wrapper .form-control {
    font-size: 1.05rem;
    padding: 0.85rem 0.9rem;
  }
  .login-abs-wrapper .btn {
    padding: 0.62rem 1rem;
    font-size: 1rem;
  }

  .login-abs-wrapper *, .login-abs-wrapper { box-sizing: border-box; }

  body { overflow-y: auto; }
");

?>
<div class="login-abs-wrapper">
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Faça login para iniciar sessão</p>

            <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

            <?= $form->field($model,'username', [
                    'options' => ['class' => 'form-group has-feedback mb-4'],
            ])->label(false)->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

            <?= $form->field($model, 'password', [
                    'options' => ['class' => 'form-group has-feedback mb-4'],
            ])->label(false)->passwordInput(['placeholder' =>'Palavra-passe']) ?>

            <div class="row mt-3">
                <div class="col-12">
                    <?= Html::submitButton('Iniciar Sessão', ['class' => 'btn btn-primary btn-block']) ?>
                </div>
            </div>

            <?php \yii\bootstrap4\ActiveForm::end(); ?>

        </div>
    </div>
</div>
