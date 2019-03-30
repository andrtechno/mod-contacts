<?php

namespace panix\mod\contacts\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use panix\mod\contacts\models\Maps;

/**
 * PagesSearch represents the model behind the search form about `app\common\modules\pages\models\Pages`.
 */
class MapsSearch extends Maps {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['name','zoom'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Maps::find();

        $dataProvider = new ActiveDataProvider([
                    'query' => $query,

                ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

}
