<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var common\models\Pergunta $pergunta */
?>

<div class="container py-5">

    <h3 class="mb-4">
        <?= Html::encode($pergunta['pergunta']) ?>
    </h3>

    <form method="post" action="<?= Url::to(['pergunta/responder']) ?>">
        <?= Html::hiddenInput(
            Yii::$app->request->csrfParam,
            Yii::$app->request->csrfToken
        ) ?>

        <?php foreach ($pergunta['respostas'] as $resposta): ?>
            <button type="submit"
                    name="id_resposta"
                    value="<?= $resposta['id'] ?>"
                    class="btn btn-outline-primary d-block w-100 mb-3 text-start">
                <?= Html::encode($resposta['resposta']) ?>
            </button>
        <?php endforeach; ?>
    </form>

</div>
