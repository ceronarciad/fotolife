<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Meeting;

/**
 * MeetingSearch represents the model behind the search form of `app\models\Meeting`.
 */
class MeetingSearch extends Meeting
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'user_id_log'], 'integer'],
            [['title', 'description', 'start', 'time_init', 'location'], 'safe'],
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
        $query = Meeting::find();

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
            'start' => $this->start,
            'time_init' => $this->time_init,
            'status' => $this->status,
            'user_id_log' => $this->user_id_log,
        ]);

        //$query->where('status>0');
        
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'start', $this->start])
            ->andFilterWhere(['like', 'time_init', $this->time_init])
            ->andFilterWhere(['like', 'location', $this->location]);

        return $dataProvider;
    }
}
