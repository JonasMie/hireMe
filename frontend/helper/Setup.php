<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 08.06.15
 * Time: 21:29
 * Project: hireMe
 */

namespace frontend\helper;


class Setup {
    const DATE_FORMAT = 'php:Y-m-d';
    const DATETIME_FORMAT = 'php:Y-m-d H:i:s';
    const TIME_FORMAT = 'php:H:i:s';

    public static function convert($dateStr, $type='date', $format = null) {
        if (empty($dateStr)){
            return null;
        }
        if ($type === 'datetime') {
            $fmt = ($format == null) ? self::DATETIME_FORMAT : $format;
        }
        elseif ($type === 'time') {
            $fmt = ($format == null) ? self::TIME_FORMAT : $format;
        }
        else {
            $fmt = ($format == null) ? self::DATE_FORMAT : $format;
        }
        return \Yii::$app->formatter->asDate($dateStr, $fmt);
    }

    public static function verboseDate($datetime){
        $date = \Yii::$app->formatter->asDate($datetime);
        if($date == date("d.m.Y")){
            return "Heute, " .\Yii::$app->formatter->asTime($datetime,"php:H:i");
        } else if ($date == date("d.m.Y", time()- (24*60*60))){
            return "Gestern, " .\Yii::$app->formatter->asTime($datetime,"php:H:i");
        } else
            return \Yii::$app->formatter->asDatetime($datetime, "php:d.m.Y H:i");
    }
}