<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jogosdefault_categoria".
 *
 * @property int $id
 * @property int $id_jogo
 * @property int $id_categoria
 *
 * @property Categoria $categoria
 * @property Jogosdefault $jogo
 */
class JogosdefaultCategoria extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jogosdefault_categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_jogo', 'id_categoria'], 'required'],
            [['id_jogo', 'id_categoria'], 'integer'],
            [['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['id_categoria' => 'id']],
            [['id_jogo'], 'exist', 'skipOnError' => true, 'targetClass' => Jogosdefault::class, 'targetAttribute' => ['id_jogo' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_jogo' => 'Id Jogo',
            'id_categoria' => 'Id Categoria',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'id_categoria']);
    }

    /**
     * Gets query for [[Jogo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogo()
    {
        return $this->hasOne(Jogosdefault::class, ['id' => 'id_jogo']);
    }

}
