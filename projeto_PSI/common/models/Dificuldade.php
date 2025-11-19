<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dificuldade".
 *
 * @property int $id
 * @property string $dificuldade
 *
 * @property Jogosdefault[] $jogosdefaults
 * @property Jogosworkshop[] $jogosworkshops
 */
class Dificuldade extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dificuldade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dificuldade'], 'required'],
            [['dificuldade'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dificuldade' => 'Dificuldade',
        ];
    }

    /**
     * Gets query for [[Jogosdefaults]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogosdefaults()
    {
        return $this->hasMany(Jogosdefault::class, ['id_dificuldade' => 'id']);
    }

    /**
     * Gets query for [[Jogosworkshops]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogosworkshops()
    {
        return $this->hasMany(Jogosworkshop::class, ['id_dificuldade' => 'id']);
    }

}
