<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Pergunta[] $modelsPerguntas */
/** @var int $totalPontos */
/** @var int $id_jogo */

if (!isset($modelsPerguntas) || !is_array($modelsPerguntas)) {
    $modelsPerguntas = [];
}
?>

<h2>Gerir Perguntas + Respostas</h2>

<div id="erros-container">
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
</div>

<?php $form = ActiveForm::begin([
        'id' => 'perguntas-form',
        'enableClientValidation' => true,
]); ?>

<h4>Total de pontos do jogo: <span id="total-jogo"><?= $totalPontos ?? 0 ?></span></h4>
<h4>Pontos usados: <span id="pontos-usados">0</span></h4>
<h4>Pontos restantes: <span id="pontos-restantes"><?= $totalPontos ?? 0 ?></span></h4>
<hr>

<div id="perguntas-container">
    <?php foreach($modelsPerguntas as $index => $pergunta): ?>
        <div class="pergunta-bloco">
            <label>Pergunta:</label>
            <input type="text" name="PerguntaTexto[]" class="form-control" value="<?= Html::encode($pergunta->pergunta) ?>">

            <label>Valor Pontos:</label>
            <input type="number" name="PerguntaValor[]" class="form-control" value="<?= $pergunta->valor ?>" min="0">

            <h4>Respostas:</h4>
            <div class="respostas-container">
                <?php foreach($pergunta->getRespostas()->all() as $respIndex => $resposta): ?>
                    <div class="resposta-item">
                        <input type="text" name="RespostaTexto[<?= $index ?>][]"
                               class="form-control"
                               value="<?= Html::encode($resposta->resposta) ?>">
                        <label>
                            <input type="radio" name="RespostaCorreta[<?= $index ?>]"
                                   value="<?= $respIndex ?>" <?= $resposta->correta ? 'checked' : '' ?>> Correta
                        </label>
                        <button type="button" class="btn btn-danger btn-sm remove-resposta">X</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="button" class="btn btn-success add-resposta">+ Resposta</button>
            <button type="button" class="btn btn-warning remove-pergunta">Remover Pergunta</button>
            <hr>
        </div>
    <?php endforeach; ?>
</div>

<button type="button" class="btn btn-primary" id="add-pergunta">+ Adicionar Pergunta</button>
<br><br>

<div class="botoes-acoes" style="margin-bottom:20px; margin-top:-10px;">
    <?= Html::submitButton('Guardar Tudo', ['class' => 'btn btn-success', 'style' => 'margin-right:10px;']) ?>
    <?= Html::a('Voltar sem Guardar', ['pergunta/view', 'id_jogo' => $id_jogo], ['class' => 'btn btn-secondary']) ?>
</div>
<?php ActiveForm::end(); ?>

<style>
    .pergunta-bloco { border:1px solid #ccc; padding:15px; margin-bottom:15px; border-radius:8px; }
    .resposta-item { display:flex; gap:10px; align-items:center; margin-top:7px; }
    .resposta-item label { margin-left:5px; }
</style>

<script>
    let countPerguntas = <?= count($modelsPerguntas) ?>;
    const totalJogo = parseInt(document.getElementById('total-jogo').innerText) || 0;

    function atualizarPontos() {
        let usado = 0;
        document.querySelectorAll('input[name="PerguntaValor[]"]').forEach(input => usado += parseInt(input.value) || 0);
        document.getElementById('pontos-usados').innerText = usado;
        document.getElementById('pontos-restantes').innerText = totalJogo - usado;
    }

    document.addEventListener('input', function(e){
        if(e.target.name === "PerguntaValor[]") {
            let usadoAntes = Array.from(document.querySelectorAll('input[name="PerguntaValor[]"]'))
                .reduce((sum,i)=>sum + parseInt(i.value) || 0,0) - (parseInt(e.target.value)||0);
            let restante = totalJogo - usadoAntes;

            if(parseInt(e.target.value) > restante) {
                e.target.value = restante;
                alert("Não é possível exceder o total de pontos do jogo!");
            }
            atualizarPontos();
        }
    });

    // Adicionar pergunta/resposta dinamicamente
    document.getElementById('add-pergunta').onclick = function() {
        let bloco = document.createElement('div');
        bloco.className = "pergunta-bloco";
        bloco.innerHTML = `
<label>Pergunta:</label>
<input type="text" name="PerguntaTexto[]" class="form-control">
<label>Valor Pontos:</label>
<input type="number" name="PerguntaValor[]" class="form-control" value="0" min="0">
<h4>Respostas:</h4>
<div class="respostas-container">
    <div class="resposta-item">
        <input type="text" name="RespostaTexto[${countPerguntas}][]" class="form-control" placeholder="Resposta...">
        <label><input type="radio" name="RespostaCorreta[${countPerguntas}]" value="0"> Correta</label>
        <button type="button" class="btn btn-danger btn-sm remove-resposta">X</button>
    </div>
</div>
<button type="button" class="btn btn-success add-resposta">+ Resposta</button>
<button type="button" class="btn btn-warning remove-pergunta">Remover Pergunta</button>
<hr>
`;
        document.getElementById('perguntas-container').appendChild(bloco);
        countPerguntas++;
        atualizarPontos();
    };

    document.addEventListener('click', function(e){
        if(e.target.classList.contains('remove-resposta')) e.target.parentElement.remove();
        if(e.target.classList.contains('remove-pergunta')) {
            e.target.closest('.pergunta-bloco').remove();
            atualizarPontos();
        }
        s:

            if(e.target.classList.contains('add-resposta')) {
                let container = e.target.previousElementSibling;
                if(container.children.length >= 4){
                    alert('O número máximo de respostas por pergunta é 4.');
                    return;
                }
                let perguntaIndex = Array.from(document.querySelectorAll('.pergunta-bloco')).indexOf(e.target.closest('.pergunta-bloco'));
                let respostaIndex = container.children.length;
                let div = document.createElement('div');
                div.className = 'resposta-item';
                div.innerHTML = `
<input type="text" name="RespostaTexto[${perguntaIndex}][]" class="form-control" placeholder="Resposta...">
<label><input type="radio" name="RespostaCorreta[${perguntaIndex}]" value="${respostaIndex}"> Correta</label>
<button type="button" class="btn btn-danger btn-sm remove-resposta">X</button>
`;
            container.appendChild(div);
        }
    });

    document.addEventListener("DOMContentLoaded", atualizarPontos);

    // AJAX submit com exibição correta de erros
    $('#perguntas-form').on('beforeSubmit', function(e){
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function(response){
                $('#erros-container').html(''); // limpar mensagens

                if(response.success){
                    window.location.href = response.redirect;
                } else if(response.errors){
                    let errosHtml = typeof response.errors === 'string' ? response.errors : response.errors.join('<br>');
                    $('#erros-container').html('<div class="alert alert-danger">' + errosHtml + '</div>');
                    $('html, body').animate({ scrollTop: $('#erros-container').offset().top - 50 }, 300);
                }
            },
            error: function(){
                $('#erros-container').html('<div class="alert alert-danger">Ocorreu um erro inesperado.</div>');
            }
        });
        return false;
    });
</script>
