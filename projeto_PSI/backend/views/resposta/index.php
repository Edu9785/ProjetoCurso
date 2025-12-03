<?php

use common\models\Resposta;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\RespostaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Respostas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resposta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <?= Html::a('<i class="fas fa-plus"></i> Criar Resposta', ['create'],
                ['class' => 'btn btn-success btn-sm shadow-sm',]) ?>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => 'A mostrar <span style="font-weight:700">{begin}</span> - <span style="font-weight:700">{end}</span> de <span style="font-weight:700">{totalCount}</span> item(s)',
            'summaryOptions' => ['class' => 'text-muted mb-3', 'encode' => false],
            'filterModel' => $searchModel,
            'columns' => [

                    'id',
                    'resposta',
                    'correta',
                    'id_pergunta',
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
                                                'data-confirm' => 'Tens a certeza que deseja apagar esta Resposta?',
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
