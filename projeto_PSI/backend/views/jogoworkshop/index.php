<?php

use common\models\Jogoworkshop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\JogoworkshopSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Jogoworkshops';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jogoworkshop-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Jogoworkshop', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_jogador',
            'id_gestor',
            'id_dificuldade',
            'aprovacao',
            //'titulo',
            //'descricao',
            //'id_tempo',
            //'totalpontosjogo',
            //'imagem',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Jogoworkshop $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
