<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use common\mosquitto\phpMQTT;

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
            [['id_dificuldade', 'titulo', 'descricao', 'totalpontosjogo', 'imagem'], 'required'],
            [['id_dificuldade', 'totalpontosjogo'], 'integer'],
            [['titulo', 'imagem'], 'string', 'max' => 45],
            [['descricao'], 'string', 'max' => 500],

            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],

            [['id_dificuldade'], 'exist', 'skipOnError' => true, 'targetClass' => Dificuldade::class, 'targetAttribute' => ['id_dificuldade' => 'id']],
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

            $filename = uniqid('img_') . '.' . $this->imageFile->extension;

            $path = Yii::getAlias('@frontend/web/uploads/') . $filename;

            if ($this->imageFile->saveAs($path)) {

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

    public function getCategorias()
    {
        return $this->hasMany(\common\models\Categoria::class, ['id' => 'id_categoria'])
            ->via('jogosdefaultCategorias');
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

    /**
     * Messaging MQTT — notifica quando um jogo é criado
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Só notificar quando é um NOVO jogo
        if ($insert) {

            $obj = new \stdClass();
            $obj->titulo = $this->titulo;
            $obj->descricao = $this->descricao;

            $json = json_encode($obj);

            $this->publishMqtt("JOGO_NOVO", $json);
        }
    }

    /**
     * Publica mensagem no Mosquitto (igual ao PDF)
     */
    private function publishMqtt($canal, $mensagem)
    {
        $server = "127.0.0.1";
        $port = 1883;
        $clientId = "yii2-jogo-" . uniqid();

        $mqtt = new phpMQTT($server, $port, $clientId);

        if ($mqtt->connect(true)) {
            $mqtt->publish($canal, $mensagem, 0);
            $mqtt->close();
        }
    }


}