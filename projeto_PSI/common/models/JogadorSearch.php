<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Jogador;

/**
 * JogadorSearch represents the model behind the search form of `common\models\Jogador`.
 */
class JogadorSearch extends Jogador
{
    /**
     * {@inheritdoc}
     */
    public $username;
    public $email;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['username', 'email'], 'safe'],
        ]);
    }

    public function search($params)
    {
        $query = Jogador::find()->joinWith('user');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'user.email', $this->email])
            ->andFilterWhere(['like', 'jogador.nome', $this->nome])
            ->andFilterWhere(['idade' => $this->idade]);

        return $dataProvider;
    }
}
