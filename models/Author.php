<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Author extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%author}}';
    }

}