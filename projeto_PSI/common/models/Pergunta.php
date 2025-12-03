<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pergunta".
 *
 * @property int $id
 * @property string $pergunta
 * @property int $valor
 *
 * @property JogosdefaultPergunta[] $jogosdefaultPerguntas
 * @property JogosworkshopPergunta[] $jogosworkshopPerguntas
 * @property Resposta[] $respostas
 */
class Pergunta extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pergunta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pergunta', 'valor'], 'required'],
            [['valor'], 'integer'],
            [['pergunta'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pergunta' => 'Pergunta',
            'valor' => 'Valor',
        ];
    }

    /**
     * Gets query for [[JogosdefaultPerguntas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogosdefaultPerguntas()
    {
        return $this->hasMany(JogosdefaultPergunta::class, ['id_pergunta' => 'id']);
    }

    /**
     * Gets query for [[JogosworkshopPerguntas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogosworkshopPerguntas()
    {
        return $this->hasMany(JogosworkshopPergunta::class, ['id_pergunta' => 'id']);
    }

    /**
     * Gets query for [[Respostas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRespostas()
    {
        return $this->hasMany(Resposta::class, ['id_pergunta' => 'id']);
    }

}
