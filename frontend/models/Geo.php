<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use yii\helpers\Json;

/**
 * This is the model class for table "geo".
 *
 * @property integer $id
 * @property integer $plz
 * @property string  $lon
 * @property string  $lat
 * @property string  $city
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
            'id'   => 'ID',
            'plz'  => Yii::t('geo', 'Plz'),
            'lon'  => Yii::t('geo', 'Lon'),
            'lat'  => Yii::t('geo', 'Lat'),
            'city' => Yii::t('geo', 'City'),
        ];
    }

    public static function getAutocompleteGeo($q)
    {
        $query = Geo::find()
            ->where('plz LIKE "%' . $q . '%" OR city LIKE "%' . $q . '%"')
//            ->orderBy('fullName')
            ->all();
        $out = [];
        foreach ($query as $city) {
            $out[] = ['plz' => (string)$city->plz, 'id' => $city->id, 'city' => $city->city];
        }
        return Json::encode($out);

    }

    public static function computeRadius($dist)
    {
        $earthRadius = 6371;
//        $geo = Geo::findOne(['id' => Yii::$app->user->geo]);

        $lat = 49.3152621576;
        $lon = 11.00055702379;


        // first-cut bounding box (in degrees)
        $maxLat = $lat + rad2deg($dist / $earthRadius);
        $minLat = $lat - rad2deg($dist / $earthRadius);

        // compensate for degrees longitude getting smaller with increasing latitude
        $maxLon = $lon + rad2deg($dist / $earthRadius / cos(deg2rad($lat)));
        $minLon = $lon - rad2deg($dist / $earthRadius / cos(deg2rad($lat)));

        $lat = deg2rad($lat);
        $lon = deg2rad($lon);

        $_rows = Yii::$app->db->createCommand("Select id, plz, city, lat, lon
                From geo
                Where lat Between $minLat And $maxLat
                  And lon Between $minLon And $maxLon")->queryAll();

        $rows = Yii::$app->db->createCommand("
          Select id, plz, city, lat, lon,
                acos(sin($lat)*sin(radians(lat)) + cos($lat)*cos(radians(lat))*cos(radians(lon)-$lon)) * $earthRadius As D
            From (
                Select id, plz, city, lat, lon
                From geo
                Where lat Between $minLat And $maxLat
                  And lon Between $minLon And $maxLon
            ) As FirstCut
          Where acos(sin($lat)*sin(radians(lat)) + cos($lat)*cos(radians(lat))*cos(radians(lon)-$lon)) * $earthRadius < $dist
            Order by D
        ")->queryAll();
    }
}
