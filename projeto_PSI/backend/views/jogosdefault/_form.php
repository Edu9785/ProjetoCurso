<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\JogosDefault $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $categorias */
/** @var array $dificuldades */
/** @var array $tempos */
/** @var array $categoriasSelecionadas */

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
            \yii\helpers\ArrayHelper::map($dificuldades, 'id', 'dificuldade'),
            ['prompt' => 'Selecione a dificuldade...']
    ) ?>

    <!-- Tempo -->
    <?= $form->field($model, 'id_tempo')->label('Tempo')->dropDownList(
            \yii\helpers\ArrayHelper::map($tempos, 'id', 'quantidadetempo'),
            ['prompt' => 'Selecione o tempo...']
    ) ?>

    <!-- Categorias -->
    <div class="form-group">
        <label><strong>Categorias</strong></label>
        <div id="categorias-container">

            <?php
            // Se houver categorias selecionadas, mostrar cada uma com a opção marcada
            if (!empty($categoriasSelecionadas)) {
                foreach ($categoriasSelecionadas as $catId) {
                    ?>
                    <div class="categoria-item mb-2">
                        <div class="d-flex gap-2">
                            <select name="categorias[]" class="form-control">
                                <option value="">Selecione a categoria...</option>
                                <?php foreach ($categorias as $c): ?>
                                    <option value="<?= $c->id ?>" <?= ($c->id == $catId) ? 'selected' : '' ?>>
                                        <?= $c->categoria ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="btn btn-danger btn-sm remove-categoria">X</button>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // Caso não haja categorias selecionadas, criar um select vazio
                ?>
                <div class="categoria-item mb-2">
                    <div class="d-flex gap-2">
                        <select name="categorias[]" class="form-control">
                            <option value="">Selecione a categoria...</option>
                            <?php foreach ($categorias as $c): ?>
                                <option value="<?= $c->id ?>"><?= $c->categoria ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" class="btn btn-danger btn-sm remove-categoria">X</button>
                    </div>
                </div>
            <?php } ?>

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

        // Permitir remover a nova categoria
        div.querySelector(".remove-categoria").addEventListener("click", function () {
            div.remove();
        });
    });

    // Permitir remover categorias já existentes
    document.querySelectorAll(".remove-categoria").forEach(btn => {
        btn.addEventListener("click", function () {
            btn.closest(".categoria-item").remove();
        });
    });
</script>
