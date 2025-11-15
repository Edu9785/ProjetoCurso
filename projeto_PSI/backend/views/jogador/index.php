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



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                    'id',
                    [
                            'attribute' => 'username',
                            'value' => 'user.username',
                    ],
                    [
                            'attribute' => 'email',
                            'value' => 'user.email',
                    ],
                    [
                            'attribute' => 'nome',
                            'filter' => false,
                    ],
                    [
                            'attribute' => 'idade',
                            'filter' => false,
                    ],
                    [
                            'class' => ActionColumn::className(),
                            'urlCreator' => function ($action, Jogador $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                    ],
            ],
    ]); ?>

</div>
