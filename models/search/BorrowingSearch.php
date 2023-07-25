<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Borrowing;

/**
 * BorrowingSearch represents the model behind the search form of `app\models\Borrowing`.
 */
class BorrowingSearch extends Borrowing
{
    public $bookTitle;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['borrow_date', 'return_date', 'fk_customer', 'bookTitle'], 'safe'],
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
        $query = Borrowing::find()->joinWith('book')->joinWith('customer')->select(['borrowing.*', 'book.title', 'CONCAT(customer.name, customer.surname) AS customer_full_name']);

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

        $dataProvider->sort->attributes['fk_customer'] = [
            'asc' => ['customer_full_name' => SORT_ASC],
            'desc' => ['customer_full_name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['bookTitle'] = [
            'asc' => ['book.title' => SORT_ASC],
            'desc' => ['book.title' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fk_customer' => $this->fk_customer,
            'fk_book' => $this->fk_book,
            'borrow_date' => $this->borrow_date,
            'return_date' => $this->return_date,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['=', 'fk_customer', $this->fk_customer])
            ->andFilterWhere(['like', 'book.title', $this->bookTitle]);

        return $dataProvider;
    }
}
