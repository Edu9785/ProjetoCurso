<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jogosdefault_pergunta".
 *
 * @property int $id
 * @property int $id_jogo
 * @property int $id_pergunta
 *
 * @property Jogosdefault $jogo
 * @property Pergunta $pergunta
 */
class JogosdefaultPergunta extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jogosdefault_pergunta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_jogo', 'id_pergunta'], 'required'],
            [['id_jogo', 'id_pergunta'], 'integer'],
            [['id_jogo'], 'exist', 'skipOnError' => true, 'targetClass' => Jogosdefault::class, 'targetAttribute' => ['id_jogo' => 'id']],
            [['id_pergunta'], 'exist', 'skipOnError' => true, 'targetClass' => Pergunta::class, 'targetAttribute' => ['id_pergunta' => 'id']],
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
            'id_pergunta' => 'Id Pergunta',
        ];
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

    /**
     * Gets query for [[Pergunta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPergunta()
    {
        return $this->hasOne(Pergunta::class, ['id' => 'id_pergunta']);
    }

}
