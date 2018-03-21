<?php
/**
 * Created by PhpStorm.
 * User: Kogomar
 * Date: 20.03.2018
 * Time: 0:06
 */

namespace app\models;


use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model
{
public $image;

public function rules()
{
    return [
        [['image'], 'required'],
        [['image'], 'file', 'extensions' => 'jpg, png'],
    ];
}

    public function uploadFile(UploadedFile $file, $currentImage )

{
    $this->image=$file;

     if($this->validate())
       {
         $this->deleteCurrentImage($currentImage);
         return $this->saveImage();
       }
}

private function getFoolder()
{
    return Yii::getAlias('@web').'uploads/';
}

private function generateFilename()
{
   return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
}
public function deleteCurrentImage($currentImage)
{

    if($this->fileExists($currentImage))
    {
        unlink($this->getFoolder().$currentImage);
    }
}
public function fileExists($currentImage)
{
    if(!empty($currentImage) && $currentImage != null)
    {
        return file_exists($this->getFoolder() . $currentImage);
    }
}
public function saveImage()
{
   $filename =$this->generateFilename();

    $this->image->saveAs($this->getFoolder().$filename);
    return $filename;
}


}