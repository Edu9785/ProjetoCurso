<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Administradores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">


    <p>
        <?php if (Yii::$app->user->can('admin')): ?>
            <?= Html::a('Create Administrador', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'username',
            'email:email',

                [
                        'class' => 'yii\grid\ActionColumn',
                        'visibleButtons' => [
                                'update' => function ($model) {
                                    return Yii::$app->user->can('admin');
                                },
                                'delete' => function ($model) {
                                    return Yii::$app->user->can('admin');
                                },
                                'view' => function ($model) {
                                    return true; // todos podem ver (opcional)
                                },
                        ],
                ],
        ],
    ]); ?>


</div>
