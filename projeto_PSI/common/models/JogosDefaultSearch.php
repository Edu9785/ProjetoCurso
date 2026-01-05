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
            [['id','totalpontosjogo'], 'integer'],
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

        // Faz LEFT JOIN com categorias para não excluir jogos sem categorias
        $query->joinWith(['categorias']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Carrega os filtros
        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // --- Limpar categorias ---
        // Remove valores vazios e transforma em inteiros
        if (is_array($this->categorias)) {
            $this->categorias = array_map('intval', array_filter($this->categorias, function($val) {
                return $val !== '' && $val !== null;
            }));
        } else {
            $this->categorias = [];
        }

        // --- FILTRAR POR DIFICULDADE ---
        if (!empty($this->dificuldade)) {
            $query->andFilterWhere(['jogosdefault.id_dificuldade' => (int)$this->dificuldade]);
        }

        // --- FILTRAR POR CATEGORIAS (multi-select) ---
        if (!empty($this->categorias)) {
            $query->andFilterWhere(['IN', 'categoria.id', $this->categorias]);
        }

        // --- FILTROS NORMAIS (titulo, descricao) ---
        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'descricao', $this->descricao]);

        return $dataProvider;
    }

}
