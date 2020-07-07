<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Videochat;

/**
 * VideochatSearch represents the model behind the search form of `frontend\models\Videochat`.
 */
class VideochatSearch extends Videochat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'duration'], 'integer'],
            [['roomname', 'roomId', 'start_time', 'end_time', 'type', 'options', 'status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Videochat::find();

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
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'duration' => $this->duration,
        ]);

        $query->andFilterWhere(['like', 'roomname', $this->roomname])
            ->andFilterWhere(['like', 'roomId', $this->roomId])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'options', $this->options])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
