<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "premium".
 *
 * @property int $id
 * @property string $nome
 * @property float $preco
 *
 * @property Jogador[] $jogadors
 */
class Premium extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'premium';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'preco'], 'required'],
            [['preco'], 'number'],
            [['nome'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'preco' => 'Preco',
        ];
    }

    /**
     * Gets query for [[Jogadors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogadors()
    {
        return $this->hasMany(Jogador::class, ['id_premium' => 'id']);
    }

}
