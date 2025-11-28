<?php

use common\models\JogosDefault;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Jogos Defaults';
$this->params['breadcrumbs'][] = $this->title;
?>
<<!-- Header Start -->
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
                <h4 class="mb-4 fw-bold">Filter</h4>

                <div class="mb-3">
                    <label class="form-label">Categoria</label>
                    <select class="form-select">
                        <option selected>Escolha...</option>
                        <option>Desporto</option>
                        <option>Ciência</option>
                        <option>História</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Dificuldade</label>
                    <select class="form-select">
                        <option selected>Escolha...</option>
                        <option>Fácil</option>
                        <option>Médio</option>
                        <option>Difícil</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Tipo de Jogo</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tipo1">
                        <label class="form-check-label" for="tipo1">Customizado</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tipo2">
                        <label class="form-check-label" for="tipo2">Default</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Source</label>
                    <select class="form-select">
                        <option selected>Escolha...</option>
                        <option>Interno</option>
                        <option>Externo</option>
                    </select>
                </div>

                <div class="d-grid mt-4">
                    <a href="#" class="btn btn-outline-primary">Criar jogo</a>
                </div>
            </div>

            <!-- Games Grid -->
            <div class="col-lg-9 col-md-8">
                <div class="row g-4">
                    <?php for ($i = 0; $i < 10; $i++): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card h-100 border">
                                <div class="ratio ratio-1x1 bg-light d-flex align-items-center justify-content-center">
                                    <span class="text-muted">Imagem</span>
                                </div>
                                <div class="card-body text-center">
                                    <h6 class="card-title mb-2">Título do Jogo</h6>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="#" class="btn btn-primary btn-sm">Iniciar</a>
                                        <a href="#" class="btn btn-outline-secondary btn-sm">Ver Detalhes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Jogos Section End -->