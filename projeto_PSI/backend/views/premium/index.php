<?php

use common\models\Premium;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\PremiumSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Premiums';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="premium-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <?= Html::a('<i class="fas fa-plus"></i> Criar Premium', ['create'], [
                'class' => 'btn btn-success btn-sm shadow-sm',
        ]) ?>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'nome',
            'preco',
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
                                            'data-confirm' => 'Tens a certeza que queres eliminar este temporizador?',
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
