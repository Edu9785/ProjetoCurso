<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tempo".
 *
 * @property int $id
 * @property int $quantidadetempo
 *
 * @property Jogosdefault[] $jogosdefaults
 * @property Jogosworkshop[] $jogosworkshops
 */
class Tempo extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tempo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidadetempo'], 'required'],
            [['quantidadetempo'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quantidadetempo' => 'Quantidadetempo',
        ];
    }

    /**
     * Gets query for [[Jogosdefaults]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogosdefaults()
    {
        return $this->hasMany(Jogosdefault::class, ['id_tempo' => 'id']);
    }

    /**
     * Gets query for [[Jogosworkshops]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogosworkshops()
    {
        return $this->hasMany(Jogosworkshop::class, ['id_tempo' => 'id']);
    }

}
