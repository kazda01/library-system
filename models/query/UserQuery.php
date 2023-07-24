<?php

namespace app\models\query;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;


/**
 * This is the ActiveQuery class for [[\app\models\User]].
 *
 * @see \app\models\User
 */
class UserQuery extends ActiveQuery
{
    public function list()
    {
        return ArrayHelper::map(self::all(),'id', function($model){
            return $model->email;
        });
    }
}
