<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property int|null $fk_author
 * @property string $name
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
class BaseModel extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',

            ],
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()')
            ]
        ];
    }
}
