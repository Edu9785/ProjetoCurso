<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Jogodefault $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jogodefault-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_dificuldade')->dropDownList(
            ArrayHelper::map($dificuldades, 'id', 'dificuldade'),
            ['prompt' => 'Selecione a dificuldade...']
    ) ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_tempo')->textInput() ?>

    <?= $form->field($model, 'totalpontosjogo')->textInput() ?>

    <?= $form->field($model, 'imagem')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
