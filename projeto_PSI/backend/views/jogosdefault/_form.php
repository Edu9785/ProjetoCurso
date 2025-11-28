<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\JogosDefault $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jogos-default-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'id_dificuldade')->label('Nivel de Dificuldade')->dropDownList(
            ['' => 'Selecione a dificuldade...'] + ArrayHelper::map($dificuldades, 'id', 'dificuldade'),
            [
                    'options' => [
                            '' => ['disabled' => true, 'selected' => true]
                    ]
            ]
    ) ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_tempo')->label('Tempo')->dropDownList(
            ['' => 'Selecione o tempo...'] + ArrayHelper::map($tempos, 'id', 'quantidadetempo'),
            [
                    'options' => [
                            '' => ['disabled' => true, 'selected' => true]
                    ]
            ]
    )?>

    <?= $form->field($model, 'totalpontosjogo')->label('Total de Pontos')->textInput() ?>

    <!-- CATEGORIAS DINÂMICAS -->
    <div class="form-group">
        <label><strong>Categorias</strong></label>

        <div id="categorias-container">
            <div class="categoria-item mb-2">
                <select name="categorias[]" class="form-control">
                    <option value="" disabled selected>Selecione a categoria...</option>
                    <?php foreach ($categorias as $c): ?>
                        <option value="<?= $c->id ?>"><?= $c->categoria ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <button type="button" class="btn btn-primary btn-sm mt-2" id="add-categoria-btn">
            <i class="fas fa-plus"></i> Adicionar categoria
        </button>
    </div>

    <script>
        document.getElementById("add-categoria-btn").addEventListener("click", function () {

            let container = document.getElementById("categorias-container");

            let div = document.createElement("div");
            div.classList.add("categoria-item", "mb-2");

            div.innerHTML = `
        <div class="d-flex gap-2">
            <select name="categorias[]" class="form-control">
                <option value="" disabled selected>Selecione a categoria...</option>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c->id ?>"><?= $c->categoria ?></option>
                <?php endforeach; ?>
            </select>

            <button type="button" class="btn btn-danger btn-sm remove-categoria">X</button>
        </div>
    `;

            container.appendChild(div);

            div.querySelector(".remove-categoria").addEventListener("click", function () {
                div.remove();
            });
        });
    </script>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
