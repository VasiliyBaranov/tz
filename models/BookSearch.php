<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class BookSearch extends Book
{

    public $date_from;
    public $date_to;

    public function rules()
    {
        return [
            [['author_id'], 'integer'],
            [['date_from', 'date_to'], 'date', 'format' => 'd-M-yyyy'],
            [['name'], 'string', 'max'=> 100],
            [['date_from', 'date_to'], 'safe'],
        ];
    }

    public function attributeLabels(){
        return [
            'author_id' => 'Автор: ',
            'name' => 'Название: ',
            'date_from' => 'Дата выхода книги с: ',
            'date_to' => 'по: ',
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Book::find();
        $query->joinWith('author');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $dataProvider->sort->attributes['author.name'] = [
            'asc' => ['{{%author.name}}' => SORT_ASC],
            'desc' => ['{{%author.name}}' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if($this->author_id){
            $query->andFilterWhere(['{{%book.author_id}}' => $this->author_id]);
        }
        if($this->name){
            $query->andFilterWhere(['like', '{{%book.name}}', $this->name]);
        }
        if($this->date_from){
            $query->andWhere('{{%book.date}} > :date_from', ['date_from' => strtotime($this->date_from)]);
        }
        if($this->date_to){
            $query->andWhere('{{%book.date}} < :date_to', ['date_to' => strtotime($this->date_to)]);
        }
        return $dataProvider;
    }
}