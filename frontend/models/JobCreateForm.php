<?php
namespace frontend\models;

use app\models\Company;
use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Job Create form
 */

class JobCreateForm extends Model
{
    public $title;
    public $description;
    public $zip;
    public $job_begin;
    public $job_end;
    public $sector;
    public $type;
    public $city;
    public $time;
    public $checkLocationBased;
    public $visibility;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['title', 'required'],
            ['title', 'string', 'min' => 2, 'max' => 255],

            ['description', 'required'],
            ['description', 'string', 'min' => 2, 'max' => 500],

            ['sector', 'required'],
            [['sector','time','zip'], 'integer'],
            ['city','string'],
            ['type', 'required'],
            ['type', 'integer'],  
          
            [['city', 'zip'], 'required', 'when' => function ($model) {
                return $model->checkLocationBased == true;
            }, 'whenClient' => 'function(attribute,value){
                    return $("#checkLocationBased").prop("checked");
                }'
            ],
             ['visibility', 'default', 'value' => 0],
            ['checkLocationBased', 'boolean'],
            ['checkLocationBased','default','value' => false],

        ];
    }

    public function attributeLabels()
    {
        return [
            'checkLocationBased' => '',
        ];
    }

    /**
     * Creates job.
     *
     */
    public function create()
    {

        $user = Yii::$app->user->identity;

        if ($this->validate()) {
            Yii::trace("User: ".$user->getName());

            $job = new Job();
            $jobs = Job::find()->orderBy('id')->all();
            if (count($jobs) == 0) {
                $job->id = 0;
            }
            else {
                $highestID = $jobs[count($jobs)-1];
                $job->id = $highestID->id+1;
            }
           

            $job->description = $this->description;
            $job->job_begin = $this->job_begin;
            $job->job_end = $this->job_end;
            $job->sector = $this->sector;
            $job->company_id = $user->company_id;
            $job->active = 0;
            $job->title = $this->title;
            $job->type = $this->type;
            $job->allocated = 0;
            $job->time = $this->time;
            $job->zip = 12;
            $job->city = "asd";

            Yii::trace("ID: ".$job->id);
            Yii::trace("desc: ".$job->description);
            Yii::trace("begin: ".$job->job_begin);
            Yii::trace("end: ".$job->job_end);
            Yii::trace("sec: ".$job->sector);
            Yii::trace("comp: ".$job->company_id);
            Yii::trace("act: ".$job->active);
            Yii::trace("title: ".$job->title);
            Yii::trace("alloc: ".$job->allocated);
            Yii::trace("time: ".$job->time);
            Yii::trace("zip: ".$job->zip);
            Yii::trace("city: ".$job->city);




            if($this->checkLocationBased) {
                $job->zip = $this->zip;
                $job->city = $this->city;
                Yii::trace("check loaction is activated");
            }
            else {
            Yii::trace("check loaction is deactivated");

            }
            if($job->save()) {
                Yii::trace("saved");
                return true;
            }


        }

        else {

            return false;
        }



    }
}
