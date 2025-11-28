<?php

use common\models\JogosDefault;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\JogosDefaultSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Jogos Defaults';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jogosdefault-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <?= Html::a('Criar Jogo', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="row">
        <?php foreach ($dataProvider->getModels() as $model): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php if ($model->imagem): ?>
                        <img src="<?= Yii::getAlias('@frontendUrl') . '/uploads/' . $model->imagem ?>" >
                    <?php else: ?>
                        <img src="https://via.placeholder.com/400x200?text=Sem+Imagem" class="card-img-top" alt="Sem Imagem">
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title"><?= Html::encode($model->titulo) ?></h5>
                        <p class="card-text"><?= Html::encode($model->descricao) ?></p>
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item"><strong>Dificuldade:</strong> <?= Html::encode($model->dificuldade->dificuldade ?? '-') ?></li>
                            <li class="list-group-item"><strong>Tempo:</strong> <?= Html::encode($model->tempo->quantidadetempo ?? '-') ?> seg</li>
                            <li class="list-group-item"><strong>Total Pontos:</strong> <?= Html::encode($model->totalpontosjogo) ?></li>
                        </ul>
                        <div class="d-flex justify-content-between">
                            <?= Html::a('<i class="fas fa-eye"></i> Ver', ['view', 'id' => $model->id], ['class' => 'btn btn-sm btn-outline-info']) ?>
                            <?= Html::a('<i class="fas fa-edit"></i> Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-outline-warning']) ?>
                            <?= Html::a('<i class="fas fa-trash"></i> Apagar', ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'data-confirm' => 'Tem certeza que deseja apagar este jogo?',
                                    'data-method' => 'post',
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>
