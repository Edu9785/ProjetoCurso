<?php

use common\models\JogosDefault;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;

/** @var yii\web\View $this */
/** @var common\models\JogosDefaultSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\Categoria[] $categorias */
/** @var common\models\Dificuldade[] $dificuldades */

$this->title = 'Jogos Trivia';
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
                <!-- FORM que envia GET para o mesmo index -->
                <form method="GET" id="filtro-jogos-form">

                    <h4 class="mb-4 fw-bold">Filtrar</h4>

                    <!-- Wrapper para selects dinâmicos -->
                    <div id="categorias-wrapper">
                        <?php
                        // Preserve valores selecionados (do searchModel ou do request)
                        $selectedCats = [];
                        if (!empty($searchModel->categorias) && is_array($searchModel->categorias)) {
                            $selectedCats = $searchModel->categorias;
                        } else {
                            $req = Yii::$app->request->get('JogosDefaultSearch');
                            if (!empty($req['categorias']) && is_array($req['categorias'])) {
                                $selectedCats = $req['categorias'];
                            }
                        }

                        // Se houver selects previamente escolhidos, renderiza-os.
                        if (!empty($selectedCats)) :
                            foreach ($selectedCats as $selCat) : ?>
                                <div class="categoria-item mb-3 d-flex gap-2">
                                    <select name="JogosDefaultSearch[categorias][]" class="form-select categoria-select">
                                        <option value="">Escolha...</option>
                                        <?php foreach ($categorias as $cat): ?>
                                            <option value="<?= $cat->id ?>" <?= ($cat->id == $selCat) ? 'selected' : '' ?>>
                                                <?= Html::encode($cat->categoria) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <!-- botão remover para selects pré-existentes -->
                                    <button type="button" class="btn btn-danger btn-sm remove-categoria">Remover</button>
                                </div>
                            <?php endforeach;
                        else: ?>
                            <!-- Renderiza um select vazio por defeito -->
                            <div class="categoria-item mb-3 d-flex gap-2">
                                <select name="JogosDefaultSearch[categorias][]" class="form-select categoria-select">
                                    <option value="">Escolha...</option>
                                    <?php foreach ($categorias as $cat): ?>
                                        <option value="<?= $cat->id ?>"><?= Html::encode($cat->categoria) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Botão adicionar categoria (JS vai clonar um select com este name) -->
                    <button type="button" class="btn btn-sm btn-primary mb-3" id="add-categoria">
                        + Adicionar categoria
                    </button>

                    <div class="mb-3">
                        <label class="form-label">Dificuldade</label>
                        <?php
                        // Valor selecionado para dificuldade
                        $selectedDif = $searchModel->dificuldade ?? Yii::$app->request->get('JogosDefaultSearch')['dificuldade'] ?? '';
                        ?>
                        <select class="form-select" name="JogosDefaultSearch[dificuldade]">
                            <option value="">Escolha...</option>
                            <?php foreach ($dificuldades as $dif): ?>
                                <option value="<?= $dif->id ?>" <?= ($dif->id == $selectedDif) ? 'selected' : '' ?>>
                                    <?= Html::encode($dif->dificuldade) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-grid mt-4">
                        <button class="btn btn-outline-primary" type="submit">Procurar</button>
                    </div>

                </form>
            </div>

            <!-- Games Grid -->
            <div class="col-lg-9 col-md-8">
                <div class="row g-4">
                    <?php if (!empty($dataProvider->models)): ?>
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
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-warning">Nenhum jogo encontrado com os filtros aplicados.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- /Games Grid -->

        </div>
    </div>
</div>
<!-- Jogos Section End -->

<?php
// Passar categorias para JS de forma segura (JSON)
$categoriasJson = Json::htmlEncode(array_map(fn($c) => ['id' => $c->id, 'nome' => $c->categoria], $categorias));
$this->registerJs("const categoriasData = $categoriasJson;", \yii\web\View::POS_HEAD);

// Incluir JS externo (certifica-te que o ficheiro existe: web/js/jogosdefault.js)
$this->registerJsFile('@web/js/jogosdefault.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
