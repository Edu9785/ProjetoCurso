<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "resposta".
 *
 * @property int $id
 * @property string $resposta
 * @property int $correta
 * @property int $id_pergunta
 *
 * @property Pergunta $pergunta
 */
class Resposta extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resposta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resposta', 'correta', 'id_pergunta'], 'required'],
            [['correta', 'id_pergunta'], 'integer'],
            [['resposta'], 'string', 'max' => 500],
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
            'resposta' => 'Resposta',
            'correta' => 'Correta',
            'id_pergunta' => 'Id Pergunta',
        ];
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
