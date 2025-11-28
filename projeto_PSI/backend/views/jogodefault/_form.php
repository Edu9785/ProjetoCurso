<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Jogodefault $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jogodefault-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'id_dificuldade')->dropDownList(
            ['' => 'Selecione a dificuldade...'] + ArrayHelper::map($dificuldades, 'id', 'dificuldade'),
            [
                    'options' => [
                            '' => ['disabled' => true, 'selected' => true]
                    ]
            ]
    ) ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_tempo')->dropDownList(
            ['' => 'Selecione o tempo...'] + ArrayHelper::map($tempos, 'id', 'quantidadetempo'),
            [
                    'options' => [
                            '' => ['disabled' => true, 'selected' => true]
                    ]
            ]
    )?>

    <?= $form->field($model, 'totalpontosjogo')->textInput() ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
