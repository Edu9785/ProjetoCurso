<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jogosworkshop".
 *
 * @property int $id
 * @property int $id_jogador
 * @property int $id_gestor
 * @property int $id_dificuldade
 * @property int $aprovacao
 * @property string $titulo
 * @property string $descricao
 * @property int $id_tempo
 * @property int $totalpontosjogo
 * @property string $imagem
 *
 * @property Dificuldade $dificuldade
 * @property Jogador $gestor
 * @property Jogador $jogador
 * @property JogosworkshopCategoria[] $jogosworkshopCategorias
 * @property JogosworkshopPergunta[] $jogosworkshopPerguntas
 * @property Tempo $tempo
 */
class Jogoworkshop extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jogosworkshop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_jogador', 'id_gestor', 'id_dificuldade', 'aprovacao', 'titulo', 'descricao', 'id_tempo', 'totalpontosjogo', 'imagem'], 'required'],
            [['id_jogador', 'id_gestor', 'id_dificuldade', 'aprovacao', 'id_tempo', 'totalpontosjogo'], 'integer'],
            [['titulo', 'imagem'], 'string', 'max' => 45],
            [['descricao'], 'string', 'max' => 500],
            [['id_dificuldade'], 'exist', 'skipOnError' => true, 'targetClass' => Dificuldade::class, 'targetAttribute' => ['id_dificuldade' => 'id']],
            [['id_gestor'], 'exist', 'skipOnError' => true, 'targetClass' => Jogador::class, 'targetAttribute' => ['id_gestor' => 'id']],
            [['id_jogador'], 'exist', 'skipOnError' => true, 'targetClass' => Jogador::class, 'targetAttribute' => ['id_jogador' => 'id']],
            [['id_tempo'], 'exist', 'skipOnError' => true, 'targetClass' => Tempo::class, 'targetAttribute' => ['id_tempo' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_jogador' => 'Id Jogador',
            'id_gestor' => 'Id Gestor',
            'id_dificuldade' => 'Id Dificuldade',
            'aprovacao' => 'Aprovacao',
            'titulo' => 'Titulo',
            'descricao' => 'Descricao',
            'id_tempo' => 'Id Tempo',
            'totalpontosjogo' => 'Totalpontosjogo',
            'imagem' => 'Imagem',
        ];
    }

    /**
     * Gets query for [[Dificuldade]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDificuldade()
    {
        return $this->hasOne(Dificuldade::class, ['id' => 'id_dificuldade']);
    }

    /**
     * Gets query for [[Gestor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGestor()
    {
        return $this->hasOne(Jogador::class, ['id' => 'id_gestor']);
    }

    /**
     * Gets query for [[Jogador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogador()
    {
        return $this->hasOne(Jogador::class, ['id' => 'id_jogador']);
    }

    /**
     * Gets query for [[JogosworkshopCategorias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogosworkshopCategorias()
    {
        return $this->hasMany(JogosworkshopCategoria::class, ['id_jogo' => 'id']);
    }

    /**
     * Gets query for [[JogosworkshopPerguntas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogosworkshopPerguntas()
    {
        return $this->hasMany(JogosworkshopPergunta::class, ['id_jogo' => 'id']);
    }

    /**
     * Gets query for [[Tempo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTempo()
    {
        return $this->hasOne(Tempo::class, ['id' => 'id_tempo']);
    }

}
