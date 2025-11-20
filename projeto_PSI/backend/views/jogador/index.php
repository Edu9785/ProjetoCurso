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
                            'class' => 'yii\grid\ActionColumn',
                            'visibleButtons' => [

                                    'update' => function ($model) {

                                        // Admin pode editar tudo
                                        if (Yii::$app->user->can('admin')) {
                                            return true;
                                        }

                                        // Manager só pode editar a própria conta
                                        if (Yii::$app->user->can('manager')) {
                                            return (int)$model->id_user === (int)Yii::$app->user->id;
                                        }

                                        return false;
                                    },

                                    'delete' => function ($model) {

                                        // Admin pode eliminar tudo
                                        if (Yii::$app->user->can('admin')) {
                                            return true;
                                        }

                                        // Manager só pode eliminar a própria conta
                                        if (Yii::$app->user->can('manager')) {
                                            return (int)$model->id_user === (int)Yii::$app->user->id;
                                        }

                                        return false;
                                    },

                                    'view' => fn() => true,
                            ],
                    ],
            ],
    ]); ?>

</div>
