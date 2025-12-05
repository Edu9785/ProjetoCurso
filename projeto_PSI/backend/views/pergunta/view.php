<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Pergunta $model */
/** @var common\models\Resposta[] $respostas */
/** @var common\models\JogosDefault|null $jogo */

$this->title = "Pergunta #{$model->id}";
$this->params['breadcrumbs'][] = ['label' => 'Perguntas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="pergunta-view">

    <h2>Pergunta: <?= Html::encode($model->pergunta) ?></h2>
    <p><b>Valor:</b> <?= $model->valor ?></p>

    <?php if ($jogo): ?>
        <p><b>Jogo:</b> <?= Html::encode($jogo->titulo) ?></p>
        <p><b>Total pontos do jogo:</b> <?= $jogo->totalpontosjogo ?></p>
    <?php endif; ?>

    <hr>
    <h4>Respostas:</h4>
    <ul>
        <?php foreach ($respostas as $r): ?>
            <li>
                <?= Html::encode($r->resposta) ?>
                <?php if ($r->correta): ?>
                    <span style="color:green;">(Correta)</span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <hr>
    <?= Html::a('Editar', ['update', 'id' => $model->id], ['class'=>'btn btn-warning']) ?>
    <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class'=>'btn btn-danger',
            'data-confirm'=>'Apagar pergunta?',
            'data-method'=>'post'
    ]) ?>

</div>
