<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JogosDefault;

class JogosDefaultSearch extends JogosDefault
{
    public $categorias = [];
    public $dificuldade;

    public function rules()
    {
        return [
            [['id', 'id_tempo', 'totalpontosjogo'], 'integer'],
            [['titulo', 'descricao', 'imagem'], 'safe'],

            // NOVO
            [['categorias'], 'each', 'rule' => ['integer']],
            [['dificuldade'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params, $formName = null)
    {
        $query = JogosDefault::find();
        $query->joinWith(['categorias']); // importante!

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // FILTRAR POR DIFICULDADE
        if (!empty($this->dificuldade)) {
            $query->andWhere(['jogosdefault.id_dificuldade' => $this->dificuldade]);
        }

        // FILTRAR POR CATEGORIAS (multi-select)
        if (!empty($this->categorias)) {
            $query->andFilterWhere(['IN', 'categoria.id', $this->categorias]);
        }

        // FILTROS NORMAIS
        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'descricao', $this->descricao]);

        return $dataProvider;
    }
}
