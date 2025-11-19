<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categoria".
 *
 * @property int $id
 * @property string $categoria
 * @property int $id_gestor
 *
 * @property User $gestor
 * @property JogosdefaultCategoria[] $jogosdefaultCategorias
 * @property JogosworkshopCategoria[] $jogosworkshopCategorias
 */
class Categoria extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categoria', 'id_gestor'], 'required'],
            [['id_gestor'], 'integer'],
            [['categoria'], 'string', 'max' => 100],
            [['id_gestor'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_gestor' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categoria' => 'Categoria',
            'id_gestor' => 'Id Gestor',
        ];
    }

    /**
     * Gets query for [[Gestor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGestor()
    {
        return $this->hasOne(User::class, ['id' => 'id_gestor']);
    }

    /**
     * Gets query for [[JogosdefaultCategorias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogosdefaultCategorias()
    {
        return $this->hasMany(JogosdefaultCategoria::class, ['id_categoria' => 'id']);
    }

    /**
     * Gets query for [[JogosworkshopCategorias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogosworkshopCategorias()
    {
        return $this->hasMany(JogosworkshopCategoria::class, ['id_categoria' => 'id']);
    }

}
