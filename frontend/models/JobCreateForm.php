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
            ['description', 'string', 'min' => 2, 'max' => 10000],

            ['sector', 'required'],
            [['sector','time','zip'], 'integer'],
            ['city','string'],
            ['type', 'integer'],  
            ['job_begin','safe'],
            ['job_end','safe'],

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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'description' => Yii::t('job', 'Description'),
            'job_begin'   => Yii::t('job', 'Job Begin'),
            'job_end'     => Yii::t('job', 'Job End'),
            'zip'         => Yii::t('geo', 'Zip'),
            'sector'      => Yii::t('company', 'Sector'),
            'company_id'  => Yii::t('company', 'Company ID'),
            'active'      => Yii::t('job', 'Active'),
            'created_at'  => Yii::t('job', 'Created At'),
            'updated_at'  => Yii::t('job', 'Updated At'),
            'title'       => Yii::t('job', 'Title'),
            'type'        => Yii::t('job', 'Type'),
            'city'        => Yii::t('geo', 'City'),
            'time'        => Yii::t('job', 'Time'),
            'allocated'   => Yii::t('job', 'Allocated'),
            'checkLocationBased' => 'Ortsbasiert',
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
            $job->type = 0;
            $job->allocated = 0;
            $job->time = 0;
            $job->zip = $this->zip;
            $job->city = $this->city;


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
