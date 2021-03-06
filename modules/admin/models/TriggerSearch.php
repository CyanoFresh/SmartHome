<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Trigger;

/**
 * TriggerSearch represents the model behind the search form about `app\models\Trigger`.
 */
class TriggerSearch extends Trigger
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'item_id', 'active'], 'integer'],
            [['date', 'time', 'weekdays', 'item_value', 'name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = Trigger::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'item_id' => $this->item_id,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'time', $this->time])
            ->andFilterWhere(['like', 'weekdays', $this->weekdays])
            ->andFilterWhere(['like', 'item_value', $this->item_value])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
