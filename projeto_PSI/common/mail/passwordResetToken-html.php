<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl([
        'site/reset-password',
        'token' => $user->password_reset_token
]);
?>
<div class="password-reset">
    <p>Olá <?= Html::encode($user->username) ?>,</p>

    <p>Recebemos um pedido para redefinir a tua palavra-passe. Para alterar a sua palavra-passe, clique no link abaixo:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>

    <p>Se não solicitou esta alteração, pode ignorar este email.</p>
</div>
