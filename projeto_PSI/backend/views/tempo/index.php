<?php

use common\models\Tempo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\TempoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Temporizadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tempo-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <?= Html::a('<i class="fas fa-plus"></i> Criar Temporizador', ['create'],
                ['class' => 'btn btn-success btn-sm shadow-sm',]) ?>
    </div>

    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'summary' => 'A mostrar <span style="font-weight:700">{begin}</span> - <span style="font-weight:700">{end}</span> de <span style="font-weight:700">{totalCount}</span> item(s)',
            'summaryOptions' => ['class' => 'text-muted mb-3', 'encode' => false],
            'tableOptions' => ['class' => 'table table-hover align-middle'],
            'columns' => [

                    [
                            'attribute' => 'id',
                            'headerOptions' => ['style' => 'width:80px'],
                            'contentOptions' => ['class' => 'text-center text-muted'],
                    ],

                    [
                            'attribute' => 'quantidadetempo',
                            'label' => 'Quantidade de Tempo',
                            'format' => 'text',
                            'contentOptions' => ['style' => 'font-weight:500; font-size:1rem;'],
                    ],

                    [
                            'class' => \yii\grid\ActionColumn::className(),
                            'header' => 'Ações',
                            'headerOptions' => ['class' => 'text-center text-primary'],
                            'contentOptions' => ['class' => 'text-center'],
                            'template' => '{view} {update} {delete}',
                            'buttons' => [
                                    'view' => function($url) {
                                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                                                'class' => 'btn btn-sm btn-outline-info me-1',
                                                'title' => 'Ver',
                                        ]);
                                    },
                                    'update' => function($url) {
                                        return Html::a('<i class="fas fa-edit"></i>', $url, [
                                                'class' => 'btn btn-sm btn-outline-warning me-1',
                                                'title' => 'Editar',
                                        ]);
                                    },
                                    'delete' => function($url) {
                                        return Html::a('<i class="fas fa-trash"></i>', $url, [
                                                'class' => 'btn btn-sm btn-outline-danger',
                                                'title' => 'Apagar',
                                                'data-confirm' => 'Tens a certeza que deseja apagar este Temporizador?',
                                                'data-method' => 'post',
                                        ]);
                                    },
                            ],
                            'urlCreator' => function($action, $model, $key) {
                                return Url::to([$action, 'id' => $model->id]);
                            }
                    ],

            ],
    ]); ?>

</div>

