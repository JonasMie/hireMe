<?php

namespace frontend\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "geo".
 *
 * @property integer $id
 * @property integer $plz
 * @property string $lon
 * @property string $lat
 * @property string $city
 */
class Geo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'plz'], 'integer'],
            [['lon', 'lat'], 'number'],
            [['city'], 'string', 'max' => 35]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plz' => 'Plz',
            'lon' => 'Lon',
            'lat' => 'Lat',
            'city' => 'City',
        ];
    }

    public static function getAutocompleteGeo($q)
    {
        $query = Geo::find()
            ->where('plz LIKE "%' . $q . '%" OR city LIKE "%'. $q .'%"')
//            ->orderBy('fullName')
            ->all();
        $out = [];
        foreach ($query as $city) {
            $out[] = ['plz' => (string)$city->plz, 'id'=> $city->id, 'city' => $city->city];
        }
        return Json::encode($out);

    }
}
