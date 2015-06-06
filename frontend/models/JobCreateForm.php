<?php
namespace frontend\models;

use app\models\Company;
use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class JobCreateForm extends Model
{
    public $id;
    public $title;
    public $description;
    public $job_begin;
    public $job_end;
    public $zip;
    public $sector;
    public $company_id;
    public $active;
    public $created_at;
    public $updated_at;
    public $type;
    public $city;
    public $time;
    public $allocated;
    public $checkLocationBased;


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
            ['sector', 'integer'],

            ['type', 'required'],
            ['type', 'integer'],   



            [['city', 'zip'], 'required', 'when' => function ($model){
                return $model->checkLocationBased == true;
            }, 'whenClient' => 'function(attribute,value){
                    return $("#checkLocationBased").prop("checked");
                }'
            ],
            ['checkLocationBased', 'boolean'],

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
            $job->zip = $this->zip;
            $job->sector = $this->sector;
            $job->company_id = $user->company_id;
            $job->active = 0;
            $job->title = $this->title;
            $job->type = $this->type;
            $job->city = $this->city;
            $job->allocated = 0;
            $job->time = 100;

            if($this->checkLocationBased) {

                Yii::trace("check loaction is activated");

            }

            Yii::trace("ID: ".$job->id);
            Yii::trace("Desc.: ".$job->description);
            Yii::trace("begin.: ".$job->job_begin);
            Yii::trace("end.: ".$job->job_end);
            Yii::trace("zip.: ".$job->zip);
            Yii::trace("sect.: ".$job->sector);
            Yii::trace("Desc.: ".$job->description);
            Yii::trace("comp.: ".$job->company_id);
            Yii::trace("active.: ".$job->active);
            Yii::trace("created:.: ".$job->created_at);
            Yii::trace("title.: ".$job->title);
            Yii::trace("type.: ".$job->type);
            Yii::trace("city.: ".$job->city);
            Yii::trace("tim.: ".$job->time);

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
