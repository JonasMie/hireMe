<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 25.05.15
 * Time: 14:17
 * Project: hireMe
 */

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

// set image dimension constants
define("IMGWIDHT", 500);
define("IMGHEIGHT", 500);
define("THUMBHEIGHT", 50);
define("THUMBWIDTH", 50);

class SettingsModel extends Model
{

    public $visibility;
    public $email;
    public $password;
    public $password_repeat;
    public $oldPassword;
    public $picture;
    public $plz;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'visibility'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'filter' => function ($query) {
                $query->andWhere(['id' => '!=' . Yii::$app->user->identity->getId()]);
            }],
            ['email', 'filter', 'filter' => 'trim'],


            ['password', 'string', 'min' => 6],
//            ['password', 'compare'],
            ['password_repeat', 'required', 'when' => function ($model) {
                return !empty($model->password);
            }, 'whenClient'                        => "function(attribute,value){
                    return $('#settingsmodel-password').val()!='';
            }"],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['oldPassword', 'required', 'when' => function ($model) {
                return !empty($model->password);
            }, 'whenClient'                    => "function(attribute,value){
                    return $('#settingsmodel-password').val()!='';
            }"],
            ['oldPassword', function ($attribute, $param) {
                if (!User::findIdentity(Yii::$app->user->identity->getId())->validatePassword($this->$attribute)) {
                    $this->addError($attribute, 'Das Passwort stimmt nicht mit deinem aktuellen Passwort überein.');
                }
            }],

            ['visibility', 'in', 'range' => [0, 1, 2]],
            ['picture', 'file', 'extensions' => ['jpg', 'png', 'jpeg']],
            ['plz', 'exist', 'targetClass' => Geo::className(), 'targetAttribute' => 'plz'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'visibility'      => Yii::t('settings', 'Visibility'),
            'oldPassword'     => Yii::t('settings', 'Old Password'),
            'password'        => Yii::t('settings', 'Password'),
            'password_repeat' => Yii::t('settings', 'Password Repeat'),
            'picture'         => Yii::t('settings', 'Picture'),
            'plz'             => Yii::t('geo', 'Plz')
        ];
    }

    /**
     * updates user settings
     *
     * @return User|null
     */
    public function update()
    {
        if ($this->validate()) {
            $user = User::findIdentity(Yii::$app->user->identity->getId());
            $imageId = $this->uploadImage($this);
            if (isset($imageId) && $imageId) {
                $user->picture_id = $imageId;
            } else if (isset($imageId) && !$imageId) {
                return false;
            }
            if (isset($this->plz) && !empty($this->plz)) {
                $geo = Geo::findOne(['plz' => $this->plz]);
                $user->geo_id = $geo->id;
            }
            $user->email = $this->email;
            $user->visibility = $this->visibility;

            if (!empty($this->password)) {
                $user->setPassword($this->password);
            }
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        } else {
            return null;
        }
    }

    private function uploadImage($model)
    {
        $model->picture = UploadedFile::getInstance($model, 'picture');
        $param = Yii::$app->request->post();
        if ($model->picture) {
            if ($model->validate()) {
                $profilePic = new File();
                $profilePic->path = "/" . uniqid("profile_");
                $profilePic->extension = $model->picture->extension;
                $profilePic->size = $model->picture->size;
                $profilePic->title = $model->picture->baseName;
                if ($profilePic->save() && $model->picture->saveAs(Yii::getAlias('@webroot') . '/uploads/profile/temp' . $profilePic->path . '.' . $profilePic->extension) && $this->cropImage($profilePic->path, $profilePic->extension, $param) && $this->saveThumbnail($profilePic->path)) {
                    return $profilePic->id;
                }
                return false;
            }
            return false;
        }
        return null;
    }

    private function cropImage($path, $extension, $param)
    {
        $imagefile = Yii::getAlias('@webroot') . '/uploads/profile/temp' . $path . "." . $extension;
        $imagesize = getimagesize($imagefile);
        $imagetype = $imagesize[2];
        switch ($imagetype) {
            case 1: // GIF
                $image = imagecreatefromgif($imagefile);
                break;
            case 2: // JPEG
                $image = imagecreatefromjpeg($imagefile);
                break;
            case 3: // PNG
                $image = imagecreatefrompng($imagefile);
                break;
            default:
                die('Unsupported imageformat');
        }

        // Crop Original Image
        $vDstImg = @imagecreatetruecolor(IMGWIDHT, IMGHEIGHT);

        // copy and resize part of an image with resampling
        imagecopyresampled($vDstImg, $image, 0, 0, $param['x'], $param['y'], IMGWIDHT, IMGHEIGHT, $param['w'], $param['h']);

        // define a result image filename
        $sResultFileName = Yii::getAlias('@webroot') . '/uploads/profile' . $path . ".jpg";

        // output image to file
        imagejpeg($vDstImg, $sResultFileName);
        @unlink($imagefile);

        return true;
    }

    private function saveThumbnail($path)
    {
        $imagefile = Yii::getAlias('@webroot') . '/uploads/profile' . $path . ".jpg";
        $imagesize = getimagesize($imagefile);
        $imagewidth = $imagesize[0];
        $imageheight = $imagesize[1];
        $image = imagecreatefromjpeg($imagefile);

        // Ausmaße kopieren, wir gehen zuerst davon aus, dass das Bild schon Thumbnailgröße hat
        $thumbwidth = $imagewidth;
        $thumbheight = $imageheight;
        // Breite skalieren falls nötig
        if ($thumbwidth > THUMBWIDTH) {
            $factor = THUMBWIDTH / $thumbwidth;
            $thumbwidth *= $factor;
            $thumbheight *= $factor;
        }
        // Höhe skalieren, falls nötig
        if ($thumbheight > THUMBHEIGHT) {
            $factor = THUMBHEIGHT / $thumbheight;
            $thumbwidth *= $factor;
            $thumbheight *= $factor;
        }
        // Thumbnail erstellen
        $thumb = imagecreatetruecolor($thumbwidth, $thumbheight);

        imagecopyresampled(
            $thumb,
            $image,
            0, 0, 0, 0,
            $thumbwidth, $thumbheight,
            $imagewidth, $imageheight
        );


        imagejpeg($thumb, Yii::getAlias('@webroot') . '/uploads/profile/thumbnails' . $path . ".jpg");
        imagedestroy($thumb);
        return true;
    }
}