<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Trainings;

/**
 * TrainingsSearch represents the model behind the search form of `app\models\Trainings`.
 */
class TrainingsSearch extends Trainings
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'speaker'], 'integer'],
            [['training_photo', 'name', 'date', 'address', 'text_before', 'text_after', 'text', 'feedback_video', 'status'], 'safe'],
            [['price'], 'number'],
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
        $query = Trainings::find();

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
            'date' => $this->date,
            'price' => $this->price,
            'speaker' => $this->speaker,
        ]);

        $query->andFilterWhere(['like', 'training_photo', $this->training_photo])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'text_before', $this->text_before])
            ->andFilterWhere(['like', 'text_after', $this->text_after])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'feedback_video', $this->feedback_video])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
