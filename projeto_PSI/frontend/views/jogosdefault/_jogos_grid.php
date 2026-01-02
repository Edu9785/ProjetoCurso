<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var common\models\JogosDefault[] $jogos */
?>

<?php if (!empty($jogos)): ?>
    <?php foreach ($jogos as $jogo): ?>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 border">

                <div class="ratio ratio-1x1 bg-light d-flex align-items-center justify-content-center">
                    <?php if ($jogo->imagem): ?>
                        <img src="<?= Yii::getAlias('@web/uploads/' . $jogo->imagem) ?>"
                             alt="<?= Html::encode($jogo->titulo) ?>"
                             class="img-fluid object-fit-cover w-100 h-100">
                    <?php else: ?>
                        <span class="text-muted">Sem imagem</span>
                    <?php endif; ?>
                </div>

                <div class="card-body text-center">
                    <h6 class="card-title mb-2"><?= Html::encode($jogo->titulo) ?></h6>

                    <div class="d-flex justify-content-center gap-2">
                        <a href="<?= Url::to(['pergunta/view', 'id_jogo' => $jogo->id]) ?>"
                           class="btn btn-primary btn-sm">Iniciar</a>

                        <a href="<?= Url::to(['view', 'id' => $jogo->id]) ?>"
                           class="btn btn-outline-secondary btn-sm">Ver Detalhes</a>
                    </div>
                </div>

            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="col-12">
        <div class="alert alert-warning">Nenhum jogo encontrado.</div>
    </div>
<?php endif; ?>
