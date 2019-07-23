<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Calendar;

/**
 * CalendarSearch represents the model behind the search form of `app\models\Calendar`.
 */
class CalendarSearch extends Calendar
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'author_id'], 'integer'],
            [['name', 'content', 'date_of_create', 'date_of_change', 'expiration_date'], 'safe'],
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
        $notesID = array();
        if ($notesID = \Yii::$app->request->get('id')) {

            $id = \Yii::$app->user->getId();
            $sql = "SELECT * FROM calendar WHERE author_id = $id and id IN(" . implode(",", $notesID) . ")";
            $query = Calendar::findBySql($sql);
            
        } else {

            $id = \Yii::$app->user->identity->id;
            $query = Calendar::find()->with(['author'])
                        ->leftJoin(['access' => 'access'], 'calendar.id = access.note_id')
                        ->andWhere([
                        'or',
                        ['author_id' => $id],
                        ['access.user_id' => $id],
                ]);
        }    
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
            'date_of_create' => $this->date_of_create,
            'date_of_change' => $this->date_of_change,
            'expiration_date' => $this->expiration_date,
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
