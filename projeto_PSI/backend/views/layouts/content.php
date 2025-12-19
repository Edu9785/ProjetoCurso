<?php
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Breadcrumbs;


$hideTitle = !empty($this->params['hideTitle']);
?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <?php if (!$hideTitle): ?>

                <div class="col-sm-6">
                    <h1 class="m-0"><?= Html::encode($this->title) ?></h1>
                </div>


                <div class="col-sm-6">
                    <?php else: ?>

                    <div class="col-sm-12">
                        <?php endif; ?>

                        <?= Breadcrumbs::widget([
                                'links' => $this->params['breadcrumbs'] ?? [],
                                'options' => [
                                        'class' => 'breadcrumb float-sm-right'
                                ]
                        ]) ?>

                    </div>

                </div>
            </div>
        </div>

        <div class="content">
            <?= $content ?>
        </div>

    </div>
