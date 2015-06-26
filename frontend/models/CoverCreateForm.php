<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Cover;

/**
 * ContactForm is the model behind the contact form.
 */
class CoverCreateForm extends Model
{
    public $text;
    public $created_at;
    public $app;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['app'], 'required'],
            [['created_at'], 'safe'],
            [['text'], 'string'],
            [['app'], 'integer'],

        ];
    }

    /**
     * @inheritdoc
     */
   public function attributeLabels()
    {
        return [
            'text' => Yii::t('app', 'Anschreiben'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function create()
    {
          $user = Yii::$app->user->identity;

        if ($this->validate()) {

            $cover = new Cover();
            $cover->id = 0;
            $cover->title = "cover_".$this->app;

            $possibleFile = File::find()
            ->where(['title' => $cover->title,'user_id' => $user->id])->one();

            if (count($possibleFile) == 1) {
            Yii::trace("File created already");

            $writeFile =  'uploads/covers/COVER_' .md5($user->id.'_'.$this->app). '.txt';
            $handle = fopen($writeFile, 'w');
            $txt = $this->text;
            fwrite($handle,$txt);
            fclose($handle);
            return true;

                
            }
            else {
            Yii::trace("First time... Creating file");
            
            $file = new File();
            $file->path = '/covers/COVER_' .md5($user->id.'_'.$this->app);
            $file->extension = "txt";
            $file->size = 100;
            $file->title = "cover_".$this->app;
            $file->user_id = $user->id;
            $file->save();

            $writeFile =  "uploads/".$file->path. '.txt';
            $handle = fopen($writeFile, 'w');
            $txt = $this->text;
            fwrite($handle,$txt);
            fclose($handle);
            $cover->attachment_id = $file->id;
            if($cover->save()) {
                return true;
            }

            }

        }

        else {

            return false;
        }


    }
}
