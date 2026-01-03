<?php

/** @var common\models\User $user */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl([
        'site/reset-password',
        'token' => $user->password_reset_token
]);

?>
Olá <?= $user->username ?>,

Recebemos um pedido para redefinir a tua palavra-passe. Para alterar a sua palavra-passe, aceda ao link abaixo:

<?= $resetLink ?>

Se não solicitou esta alteração, pode ignorar este email.
