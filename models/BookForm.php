<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;
use yii\imagine\Image;

class BookForm extends Model
{
    public $book_id;
    public $name;
    public $preview;
    public $date;
    public $author_id;

    public $isNewRecord = 1;

    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['preview'], 'file', 'extensions' => Yii::$app->params['allowedImageExtensions']],
            [['date'], 'date', 'format' => 'd-M-yyyy'],
            [['name', 'date', 'author_id'], 'required'],
            [['isNewRecord'], 'safe' ],
        ];
    }

    public function loadBook($book_id){
        if($book = Book::findOne(['book_id' => $book_id])){
            $this->book_id = $book->book_id;
            $this->name = $book->name;
            $this->preview = $book->preview;
            $this->date = date('d-m-Y',$book->date);
            $this->author_id = $book->author_id;
            return true;
        }else{
            return null;
        }
    }

    public function insert()
    {
        $this->preview = UploadedFile::getInstance($this, 'preview');

        if ($this->validate()) {
            $book = new Book();
            $book->name = $this->name;
            $book->date = strtotime($this->date);
            $book->author_id = $this->author_id;
            if ($book->save()) {
                $dir = Yii::getAlias(Yii::$app->params['previewPath']);
                if (!is_dir($dir)) {
                    BaseFileHelper::createDirectory($dir,0777);
                }

                $uploaded = false;
                $filename = '';

                if ($this->preview) {
                    $filename = 'b' . $book->book_id . 'preview.' . $this->preview->extension;
                    $uploaded = $this->preview->saveAs($dir . '/' . $filename);
                    $img = Image::getImagine()->open($dir.'/'.$filename);
                    $size = $img->getSize();
                    $ratio = $size->getWidth()/$size->getHeight();
                    $width = 700;
                    $height = round($width/$ratio);
                    Image::thumbnail($dir.'/'.$filename, $width, $height)
                        ->save($dir.'/'.$filename, ['quality' => 80]);
                    $ratio = $size->getWidth()/$size->getHeight();
                    $width = 200;
                    $height = round($width/$ratio);
                    Image::thumbnail($dir.'/'.$filename, $width, $height)
                        ->save($dir.'/th_'.$filename, ['quality' => 80]);

                }
                if($uploaded){
                    $bookData = Book::findOne($book->book_id);
                    $bookData->preview = $filename;
                    $bookData->save();
                }

                return $book;
            }
        }

        return null;
    }

    public function update()
    {
        $this->preview = UploadedFile::getInstance($this, 'preview');

        if ($this->validate()) {


            $book = Book::findOne($this->book_id);
            $book->name = $this->name;
            $book->date = strtotime($this->date);
            $book->author_id = $this->author_id;
            $dir = Yii::getAlias(Yii::$app->params['previewPath']);
            $uploaded = false;
            if($this->preview) {
                $filename = 'b' . $this->book_id . 'preview.' . $this->preview->extension;
                $uploaded = $this->preview->saveAs($dir.'/'.$filename);
                $img = Image::getImagine()->open($dir.'/'.$filename);
                $size = $img->getSize();
                $ratio = $size->getWidth()/$size->getHeight();
                $width = 700;
                $height = round($width/$ratio);
                Image::thumbnail($dir.'/'.$filename, $width, $height)
                    ->save($dir.'/'.$filename, ['quality' => 80]);
                $ratio = $size->getWidth()/$size->getHeight();
                $width = 200;
                $height = round($width/$ratio);
                Image::thumbnail($dir.'/'.$filename, $width, $height)
                    ->save($dir.'/th_'.$filename, ['quality' => 80]);

            }else{
                $filename = '';
            }

            if($uploaded){
                if(is_file(Yii::getAlias(Yii::$app->params['previewPath']).'/'.$book->preview)){
                    unlink(Yii::getAlias(Yii::$app->params['previewPath']).'/'.$book->preview);
                }
                $book->preview = $filename;
            }

            $book->save();

            return $book;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function delete(){

        // удаляем файл превью с фтп
        if(is_file(Yii::getAlias(Yii::$app->params['previewPath']).'/'.$this->preview)){
            unlink(Yii::getAlias(Yii::$app->params['previewPath']).'/'.$this->preview);
        }

        Book::deleteAll(['book_id' => $this->book_id]);

        return false;
    }

}