<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\JogosDefault $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jogos Defaults', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="jogos-default-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_dificuldade',
            'titulo',
            'descricao',
            'id_tempo',
            'totalpontosjogo',
                [
                        'label' => 'Categorias',
                        'value' => function ($model) use ($categorias) {

                            if (empty($model->categorias)) {
                                return 'Nenhuma categoria atribuída';
                            }

                            // converter "1,3,5" → [1,3,5]
                            $ids = explode(',', $model->categorias);

                            // mapear nomes
                            $nomes = [];

                            foreach ($categorias as $cat) {
                                if (in_array($cat->id, $ids)) {
                                    $nomes[] = $cat->categoria;
                                }
                            }

                            return implode(', ', $nomes);
                        },
                        'format' => 'raw',
                ],
            'imagem',
        ],
    ]) ?>

</div>
