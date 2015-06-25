<?php
namespace frontend\models;

use yii\base\Model;
use Yii;

/**
 * Upload Form
 */

class UploadForm extends Model
{
    /**
     * @var UploadedFile|Null file attribute
     */
    public $file;
    public $title;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
           [['file'], 'file'],
           ['file','required'],
           ['title', 'string'],
           ['title', 'required'],

        ];
    }
}