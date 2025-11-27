<?php

use common\models\Jogador;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\JogadorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Jogadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jogador-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <?= Html::a('<i class="fas fa-plus"></i> Criar Jogador', ['create'], [
                'class' => 'btn btn-success btn-sm shadow-sm',
        ]) ?>
    </div>

    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-hover align-middle'],
            'summaryOptions' => ['class' => 'text-muted mb-3'],
            'columns' => [

                    [
                            'attribute' => 'id',
                            'headerOptions' => ['style' => 'width:80px'],
                            'contentOptions' => ['class' => 'text-center text-muted'],
                    ],

                    [
                            'attribute' => 'username',
                            'value' => 'user.username',
                            'contentOptions' => ['style' => 'font-weight:500; font-size:1rem;'],
                    ],

                    [
                            'attribute' => 'email',
                            'value' => 'user.email',
                            'format' => 'email',
                    ],

                    [
                            'attribute' => 'nome',
                            'filter' => false,
                            'contentOptions' => ['style' => 'font-size:0.95rem;'],
                    ],

                    [
                            'attribute' => 'idade',
                            'filter' => false,
                            'contentOptions' => ['class' => 'text-center', 'style' => 'width:80px; font-weight:500;'],
                    ],

                    [
                            'class' => \yii\grid\ActionColumn::className(),
                            'header' => 'Ações',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'template' => '{view} {update} {delete}',
                            'visibleButtons' => [
                                    'update' => function ($model) {
                                        if (Yii::$app->user->can('admin')) return true;
                                        if (Yii::$app->user->can('manager'))
                                            return (int)$model->id_user === (int)Yii::$app->user->id;
                                        return false;
                                    },
                                    'delete' => function ($model) {
                                        if (Yii::$app->user->can('admin')) return true;
                                        if (Yii::$app->user->can('manager'))
                                            return (int)$model->id_user === (int)Yii::$app->user->id;
                                        return false;
                                    },
                                    'view' => fn() => true,
                            ],
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
                                                'data-confirm' => 'Tem a certeza que deseja eliminar este jogador?',
                                                'data-method' => 'post',
                                        ]);
                                    },
                            ],
                            'urlCreator' => function ($action, $model) {
                                return Url::to([$action, 'id' => $model->id]);
                            }
                    ],

            ],
    ]); ?>

</div>

