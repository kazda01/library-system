<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "borrowing".
 *
 * @property int $id
 * @property int $fk_customer
 * @property int $fk_book
 * @property string $borrow_date
 * @property string|null $return_date
 * @property int $created_by
 * @property int $updated_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $createdBy
 * @property Book $fkBook
 * @property Customer $fkCustomer
 * @property User $updatedBy
 */
class Borrowing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'borrowing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_customer', 'fk_book', 'borrow_date'], 'required'],
            [['fk_customer', 'fk_book', 'created_by', 'updated_by'], 'integer'],
            [['borrow_date', 'return_date', 'created_at', 'updated_at'], 'safe'],
            [['fk_book'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['fk_book' => 'id']],
            [['fk_customer'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['fk_customer' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fk_customer' => Yii::t('app', 'Customer'),
            'fk_book' => Yii::t('app', 'Book'),
            'borrow_date' => Yii::t('app', 'Borrow date'),
            'return_date' => Yii::t('app', 'Return date'),
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
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'fk_book']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'fk_customer']);
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
     * Returns boolean if Borrowing is active.
     * 
     * @return boolean
     */
    public function isActive()
    {
        if (strtotime(date('Y-m-d')) < strtotime($this->borrow_date)) return false;
        return strtotime(date('Y-m-d')) <= strtotime($this->return_date) || $this->return_date === null;
    }
}
