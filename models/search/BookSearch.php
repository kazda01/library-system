<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Book;
use app\models\Borrowing;

/**
 * BookSearch represents the model behind the search form of `app\models\Book`.
 */
class BookSearch extends Book
{
    public $authorName;
    public $createdByUsername;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'isbn', 'authorName', 'createdByUsername'], 'safe'],
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
        $query = Book::find()->joinWith('author')->joinWith('createdBy')->select([
            'book.*',
            'available' => Borrowing::find()->select(['COUNT(*)'])
                ->where('book.id = borrowing.fk_book')
                ->andWhere(['<=', 'borrow_date', date('Y-m-d')])
                ->andWhere(['or', ['IS', 'return_date', null], ['>=', 'return_date', date('Y-m-d')]])
        ]);
        
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

        $dataProvider->sort->attributes['authorName'] = [
            'asc' => ['author.name' => SORT_ASC],
            'desc' => ['author.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['createdByUsername'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['available'] = [
            'asc' => ['available' => SORT_ASC],
            'desc' => ['available' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fk_author' => $this->fk_author,
            'pages' => $this->pages,
            'year_of_publication' => $this->year_of_publication,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'author.name', $this->authorName])
            ->andFilterWhere(['like', 'user.username', $this->createdByUsername])
            ->andFilterWhere(['like', 'isbn', $this->isbn]);

        return $dataProvider;
    }
}
