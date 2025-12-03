<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\JogosDefault $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $categorias */
/** @var array $dificuldades */
/** @var array $tempos */
?>

<div class="jogos-default-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <!-- Título e Descrição -->
    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <!-- Total de Pontos -->
    <?= $form->field($model, 'totalpontosjogo')->label('Total de Pontos')->textInput() ?>

    <!-- Dificuldade -->
    <?= $form->field($model, 'id_dificuldade')->label('Grau de Dificuldade')->dropDownList(
        ArrayHelper::map($dificuldades, 'id', 'dificuldade'),
        ['prompt' => 'Selecione a dificuldade...']
    ) ?>

    <!-- Tempo -->
    <?= $form->field($model, 'id_tempo')->label('Tempo')->dropDownList(
        ArrayHelper::map($tempos, 'id', 'quantidadetempo'),
        ['prompt' => 'Selecione o tempo...']
    ) ?>

    <!-- Categorias -->
    <div class="form-group">
        <label><strong>Categorias</strong></label>
        <div id="categorias-container">
            <div class="categoria-item mb-2">
                <select name="categorias[]" class="form-control">
                    <option value="">Selecione a categoria...</option>
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

    <!-- Upload de imagem -->
    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <!-- Submit -->
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<!-- JavaScript para adicionar/remover categorias -->
<script>
    document.getElementById("add-categoria-btn").addEventListener("click", function () {
        const container = document.getElementById("categorias-container");
        const div = document.createElement("div");
        div.classList.add("categoria-item", "mb-2");
        div.innerHTML = `
        <div class="d-flex gap-2">
            <select name="categorias[]" class="form-control">
                <option value="">Selecione a categoria...</option>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c->id ?>"><?= $c->categoria ?></option>
                <?php endforeach; ?>
            </select>
            <button type="button" class="btn btn-danger btn-sm remove-categoria">X</button>
        </div>
    `;
        container.appendChild(div);

        // Evento para remover o select
        div.querySelector(".remove-categoria").addEventListener("click", function () {
            div.remove();
        });
    });
</script>
