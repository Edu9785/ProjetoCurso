<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var array $pergunta */

$this->params['hideFooter'] = true;
$this->registerCssFile('@web/css/game.css', ['depends' => [\frontend\assets\AppAsset::class]]);
?>

<div class="game-page">

    <div class="game-card">

        <div class="game-question">
            <?= Html::encode($pergunta['pergunta']) ?>
        </div>

        <form method="post" action="<?= Url::to(['pergunta/responder']) ?>">
            <?= Html::hiddenInput(
                    Yii::$app->request->csrfParam,
                    Yii::$app->request->csrfToken
            ) ?>

            <?php foreach ($pergunta['respostas'] as $resposta): ?>
                <button
                        type="submit"
                        name="id_resposta"
                        value="<?= $resposta['id'] ?>"
                        class="game-answer mb-3"
                >
                    <?= Html::encode($resposta['resposta']) ?>
                </button>
            <?php endforeach; ?>
        </form>

    </div>

</div>
