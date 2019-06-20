<?php

namespace tasktracker\forms\task;

use tasktracker\entities\task\Tasks;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\imagine\Image;
use yii\web\UploadedFile;

class ImageForm extends Model
{
    /** @var UploadedFile */
    public $image;
    public $file;
    public $preview;
    public $alt;

    public function rules(): array
    {
        return [
            [['image'], 'image', 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if (!$this->validate()) {
            return false;
        }

        $path = \Yii::getAlias('@webroot');

        $this->file = '/img/task/full/' . $this->image->name;
        $pathFile = $path . $this->file;
        $this->alt = $this->image->baseName;

        if (file_exists($pathFile)) {
            return false;
        }

        if (!$this->image->saveAs($pathFile)) {
            throw new \DomainException('Image not upload');
        }

        $this->preview = '/img/task/preview/' . $this->image->name;
        Image::thumbnail($pathFile, 100, 100)
            ->save($path . $this->preview);

        return true;

    }

    public function search(Tasks $task): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $task->getImages(),
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);
    }
}