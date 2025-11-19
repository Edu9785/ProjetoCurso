<?php

use common\models\Dificuldade;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\DficuldadeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Dificuldades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dificuldade-index">


    <p>
        <?= Html::a('Create Dificuldade', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'dificuldade',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Dificuldade $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
