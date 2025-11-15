<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jogador".
 *
 * @property int $id
 * @property int $id_user
 * @property string $nome
 * @property int $idade
 * @property int|null $id_premium
 *
 * @property Jogosworkshop[] $jogosworkshops
 * @property Jogosworkshop[] $jogosworkshops0
 * @property Premium $premium
 * @property User $user
 */
class Jogador extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jogador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_premium'], 'default', 'value' => null],
            [['id_user', 'nome', 'idade'], 'required'],
            [['id_user', 'idade', 'id_premium'], 'integer'],
            [['nome'], 'string', 'max' => 150],
            [['id_premium'], 'exist', 'skipOnError' => true, 'targetClass' => Premium::class, 'targetAttribute' => ['id_premium' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'nome' => 'Nome',
            'idade' => 'Idade',
            'id_premium' => 'Id Premium',
        ];
    }

    /**
     * Gets query for [[Jogosworkshops]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogosworkshops()
    {
        return $this->hasMany(Jogosworkshop::class, ['id_gestor' => 'id']);
    }

    /**
     * Gets query for [[Jogosworkshops0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogosworkshops0()
    {
        return $this->hasMany(Jogosworkshop::class, ['id_jogador' => 'id']);
    }

    /**
     * Gets query for [[Premium]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPremium()
    {
        return $this->hasOne(Premium::class, ['id' => 'id_premium']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

}
