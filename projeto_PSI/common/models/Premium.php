<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "premium".
 *
 * @property int $id
 * @property string $nome
 * @property float $preco
 *
 * @property Jogador[] $jogadors
 */
class Premium extends \yii\db\ActiveRecord
{

    public $imageFile;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'premium';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'preco'], 'required'],
            [['preco'], 'number'],
            [['nome'], 'string', 'max' => 100],
            [['imagem'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'preco' => 'Preco',
            'imagem' => 'Imagem',
            'imageFile' => 'Upload da Imagem',
        ];
    }

    public function upload()
    {
        if (!$this->imageFile) {
            return true;
        }

        $path = Yii::getAlias('@frontend/web/uploads/');
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // apagar imagem antiga (se existir)
        if (!empty($this->imagem)) {
            $oldFile = $path . $this->imagem;
            if (file_exists($oldFile)) {
                @unlink($oldFile);
            }
        }

        $filename = uniqid('img_') . '.' . $this->imageFile->extension;

        if ($this->imageFile->saveAs($path . $filename)) {
            $this->imagem = $filename;
            return true;
        }

        return false;
    }

    /**
     * Gets query for [[Jogadors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogadors()
    {
        return $this->hasMany(Jogador::class, ['id_premium' => 'id']);
    }

}
