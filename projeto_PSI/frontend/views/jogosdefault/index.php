<?php

use common\models\JogosDefault;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
?>

<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Jogos Trivia</h1>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Jogos Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">

            <!-- Sidebar Filters -->
            <div class="col-lg-3 col-md-4">
                <h4 class="mb-4 fw-bold">Filtrar</h4>

                <!-- Categorias Dinâmicas -->
                <div id="categorias-wrapper">

                    <!-- Primeiro campo inicial -->
                    <div class="categoria-item mb-3 d-flex gap-2">
                        <select name="categorias[]" class="form-select categoria-select">
                            <option value="">Escolha...</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat->id ?>"><?= Html::encode($cat->categoria) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <!-- Botão adicionar categoria -->
                <button type="button" class="btn btn-sm btn-primary mb-3" id="add-categoria">
                    + Adicionar categoria
                </button>

                <div class="mb-3">
                    <label class="form-label">Dificuldade</label>
                    <select class="form-select" name="dificuldade">
                        <option value="">Escolha...</option>
                        <?php foreach ($dificuldades as $dif): ?>
                            <option value="<?= $dif->id ?>"><?= Html::encode($dif->dificuldade) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="d-grid mt-4">
                    <button class="btn btn-outline-primary">Procurar</button>
                </div>
            </div>

            <!-- Games Grid (RESTORED) -->
            <div class="col-lg-9 col-md-8">
                <div class="row g-4">

                    <?php foreach ($dataProvider->models as $jogo): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card h-100 border">

                                <!-- Imagem -->
                                <div class="ratio ratio-1x1 bg-light d-flex align-items-center justify-content-center">
                                    <?php if ($jogo->imagem): ?>
                                        <img src="<?= Yii::getAlias('@web/uploads/' . $jogo->imagem) ?>"
                                             alt="<?= Html::encode($jogo->titulo) ?>"
                                             class="img-fluid object-fit-cover w-100 h-100">
                                    <?php else: ?>
                                        <span class="text-muted">Sem imagem</span>
                                    <?php endif; ?>
                                </div>

                                <!-- Info -->
                                <div class="card-body text-center">
                                    <h6 class="card-title mb-2"><?= Html::encode($jogo->titulo) ?></h6>

                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="<?= Url::to(['jogar', 'id' => $jogo->id]) ?>"
                                           class="btn btn-primary btn-sm">Iniciar</a>

                                        <a href="<?= Url::to(['view', 'id' => $jogo->id]) ?>"
                                           class="btn btn-outline-secondary btn-sm">Ver Detalhes</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- Jogos Section End -->

<?php
// Passar categorias para JS em JSON
$categoriasJson = json_encode(
        array_map(fn($c) => ['id' => $c->id, 'nome' => $c->categoria], $categorias),
        JSON_UNESCAPED_UNICODE
);

// Incluir JS externo
$this->registerJs("const categoriasData = $categoriasJson;", \yii\web\View::POS_HEAD);
$this->registerJsFile('@web/js/jogosdefault.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
