<?php

namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

class PasswordResetRequestForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => User::class,
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Não existe nenhum utilizador com este email.'
            ],
        ];
    }

    /**
     * Envia o email de redefinição de password.
     * @return bool
     */
    public function sendEmail()
    {
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        // Gera token se não existir ou estiver expirado
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            $user->save(false);
        }

        // Envia o email usando o mailer configurado
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ''])
            ->setTo($this->email)
            ->setSubject('Redefinição de palavra-passe para ' . Yii::$app->name)
            ->send();
    }
}
