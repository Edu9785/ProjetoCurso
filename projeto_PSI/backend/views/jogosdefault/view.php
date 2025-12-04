<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\JogosDefault $model */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Jogos Defaults', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jogosdefault-view">

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data-confirm' => 'Tem certeza que deseja apagar este jogo?',
            'data-method' => 'post',
        ]) ?>
    </p>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <p><strong>Título:</strong> <?= Html::encode($model->titulo) ?></p>
            <p><strong>Descrição:</strong> <?= Html::encode($model->descricao) ?></p>

            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><strong>Dificuldade:</strong> <?= Html::encode($model->dificuldade->dificuldade ?? '-') ?></li>
                <li class="list-group-item"><strong>Tempo:</strong> <?= Html::encode($model->tempo->quantidadetempo ?? '-') ?> seg</li>
                <li class="list-group-item"><strong>Total Pontos:</strong> <?= Html::encode($model->totalpontosjogo) ?></li>
                <li class="list-group-item"><strong>Categorias:</strong>
                    <?php
                    $nomesCategorias = [];
                    foreach ($model->categorias as $categoria) {
                        $nomesCategorias[] = $categoria->categoria;
                    }
                    echo Html::encode(!empty($nomesCategorias) ? implode(', ', $nomesCategorias) : 'Nenhuma categoria atribuída');
                    ?>
                </li>
            </ul>
        </div>
    </div>

</div>
