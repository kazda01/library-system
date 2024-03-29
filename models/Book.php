<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property int|null $fk_author
 * @property string $title
 * @property string|null $description
 * @property string $language
 * @property string $isbn
 * @property int|null $pages
 * @property int|null $year_of_publication
 * @property int $created_by
 * @property int $updated_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $createdBy
 * @property Author $fkAuthor
 * @property User $updatedBy
 */
class Book extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_author', 'pages', 'year_of_publication', 'created_by', 'updated_by'], 'integer'],
            [['title', 'language', 'isbn'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 191],
            [['language'], 'string', 'max' => 32],
            [['isbn'], 'string', 'max' => 13],
            [['fk_author'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['fk_author' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fk_author' => Yii::t('app', 'Author'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'language' => Yii::t('app', 'Language'),
            'isbn' => Yii::t('app', 'ISBN'),
            'pages' => Yii::t('app', 'Pages'),
            'year_of_publication' => Yii::t('app', 'Year of publication'),
            'created_by' => Yii::t('app', 'Created by'),
            'updated_by' => Yii::t('app', 'Updated by'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'fk_author']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * Gets query for [[Borrowings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBorrowings()
    {
        return $this->hasMany(Borrowing::class, ['fk_book' => 'id']);
    }

    /**
     * Returns boolean if Book is available for borrow in specified range.
     * Accepts two parameters for date range, if null - date('Y-m-d') is used.
     * 
     * @param string|null $borrow_date
     * @param string|null $return_date
     * @return boolean
     */
    public function isAvailable($borrow_date = null, $return_date = null)
    {
        if($borrow_date === null || $borrow_date === '') $borrow_date = date('Y-m-d');
        if($return_date === null || $return_date === '') $return_date = date('Y-m-d');

        $date_intersection = $this->getBorrowings()
            ->andWhere([
                'or',
                [
                    'and', ['IS', 'return_date', null],         ['<=', 'borrow_date', $return_date]
                ],
                [
                    'and', ['>=', 'borrow_date', $borrow_date], ['<=', 'borrow_date', $return_date]
                ],
                [
                    'and', ['>=', 'return_date', $borrow_date], ['<=', 'return_date', $return_date],
                ],
                [
                    'and', ['<=', 'borrow_date', $borrow_date], ['>=', 'return_date', $return_date],
                ],
            ]);
        return $date_intersection->count() == 0;
    }
}
