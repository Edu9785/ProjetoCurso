<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "jogosdefault".
 *
 * @property int $id
 * @property int $id_dificuldade
 * @property string $titulo
 * @property string $descricao
 * @property int $id_tempo
 * @property int $totalpontosjogo
 * @property string $imagem
 * @property UploadedFile $imageFile
 * @property Dificuldade $dificuldade
 * @property JogosdefaultCategoria[] $jogosdefaultCategorias
 * @property JogosdefaultPergunta[] $jogosdefaultPerguntas
 * @property Tempo $tempo
 */
class JogosDefault extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * @var UploadedFile
     */
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jogosdefault';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_dificuldade', 'titulo', 'descricao', 'id_tempo', 'totalpontosjogo', 'imagem'], 'required'],
            [['id_dificuldade', 'id_tempo', 'totalpontosjogo'], 'integer'],
            [['titulo', 'imagem'], 'string', 'max' => 45],
            [['descricao'], 'string', 'max' => 500],

            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],

            [['id_dificuldade'], 'exist', 'skipOnError' => true, 'targetClass' => Dificuldade::class, 'targetAttribute' => ['id_dificuldade' => 'id']],
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
            'id_dificuldade' => 'Id Dificuldade',
            'titulo' => 'Titulo',
            'descricao' => 'Descricao',
            'id_tempo' => 'Id Tempo',
            'totalpontosjogo' => 'Totalpontosjogo',
            'imagem' => 'Imagem',
            'imageFile' => 'Upload da Imagem',
        ];
    }

    /**
     * Guarda a imagem na pasta e grava o nome na BD
     */
    public function upload()
    {
        if ($this->imageFile) {

            // gerar nome único
            $filename = uniqid('img_') . '.' . $this->imageFile->extension;

            // definir caminho correto para frontend/web/uploads/
            $path = Yii::getAlias('@frontend/web/uploads/') . $filename;

            // guardar ficheiro físico
            if ($this->imageFile->saveAs($path)) {

                // guardar nome da imagem na BD
                $this->imagem = $filename;

                return true;
            }

            return false;
        }

        return true; // caso não envie imagem
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
     * Gets query for [[JogosdefaultCategorias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogosdefaultCategorias()
    {
        return $this->hasMany(JogosdefaultCategoria::class, ['id_jogo' => 'id']);
    }

    /**
     * Gets query for [[JogosdefaultPerguntas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogosdefaultPerguntas()
    {
        return $this->hasMany(JogosdefaultPergunta::class, ['id_jogo' => 'id']);
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