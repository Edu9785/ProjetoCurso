<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Premium $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="premium-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'preco')->textInput() ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <?php if (!$model->isNewRecord && !empty($model->imagem)): ?>
        <div class="mb-3">
            <label class="form-label">Imagem atual</label><br>
            <img src="<?= Yii::getAlias('@frontendUrl') . '/uploads/' . $model->imagem ?>"
                 style="max-width: 200px; border-radius: 8px;">
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
