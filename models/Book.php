<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Book extends ActiveRecord{

    public static function tableName()
    {
        return '{{%book}}';
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['author_id' => 'author_id']);
    }

    public function attributeLabels()
    {
        return [
            'book_id' => 'ID',
            'name' => 'Название',
            'date_create' => 'Дата добавления',
            'date_update' => 'Обновлено',
            'preview' => 'Превью',
            'date' => 'Дата выхода книги',
            'author.name' => 'Автор',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(!$insert) {
                $this->date_update = time();
            }else{
                $this->date_create = time();
                $this->date_update = $this->date_create;
            }
            return true;
        } else {
            return false;
        }
    }

}