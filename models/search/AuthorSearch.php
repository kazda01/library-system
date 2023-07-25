<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Author;
use app\models\Book;

/**
 * AuthorSearch represents the model behind the search form of `app\models\Author`.
 */
class AuthorSearch extends Author
{
    public $bookCount;
    public $createdByUsername;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'bookCount', 'createdByUsername'], 'safe'],
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
        $subquery = Author::find()->joinWith('books')->select('author.id as author_id, COUNT(book.id) as count')->groupBy('author.id');
        $query = Author::find()->select('author.*')
            ->joinWith('createdBy')
            ->innerJoin(['books' => $subquery], 'author.id = books.author_id');

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

        $dataProvider->sort->attributes['createdByUsername'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['bookCount'] = [
            'asc' => ['books.count' => SORT_ASC],
            'desc' => ['books.count' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'user.username', $this->createdByUsername])
            ->andFilterWhere(['books.count' => $this->bookCount]);

        return $dataProvider;
    }
}
