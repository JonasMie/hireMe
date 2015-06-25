<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 01.06.15
 * Time: 11:03
 * Project: hireMe
 */

namespace common\behaviours;


use Yii;
use yii\base\Behavior;
use yii\helpers\Html;
use yii\helpers\Url;

class BodyClassBehaviour extends Behavior
{

    private $_classes = array();

    protected function _cleanClasses()
    {
        $this->_classes = array_unique($this->_classes);
    }

    protected function _isFrontPage()
    {
        $stripped_uri = (strpos(Url::current(), '?'))
            ? substr(Url::current(), 0, strpos(Url::current(), '?'))
            : Url::current();

        return "/site/index" === $stripped_uri;
    }

    public function addBodyClasses($classes)
    {
        if (!empty($classes)) {
            if (is_array($classes)) {
                foreach ($classes as $class) {
                    $this->addBodyClasses($class);
                }
            } else {
                $this->_classes[] = $classes;
            }
        }
    }

    public function getBodyClasses($classes = array())
    {
        $this->addBodyClasses($classes);

        $this->addBodyClasses('controller-' . Yii::$app->controller->id);
        $this->addBodyClasses('action-' . Yii::$app->controller->action->id);

        if (!empty(Yii::$app->controller->layout)) {
            $layout = Yii::$app->controller->layout;
            $layout = ltrim($layout, '/');
            $layout = str_replace('/', '-', $layout);
            $this->addBodyClasses($layout);
        } else if (!empty(Yii::$app->layout)) {
            $layout = Yii::$app->layout;
            $layout = ltrim($layout, '/');
            $layout = str_replace('/', '-', $layout);
            $this->addBodyClasses($layout);
        }

        if ($this->_isFrontPage())
            $this->addBodyClasses('front-page');

        if (Yii::$app->user->isGuest)
            $this->addBodyClasses('not-logged-in');
        else
            $this->addBodyClasses('logged-in');

        $actionParams = Yii::$app->controller->actionParams;
        if (!empty($actionParams)) {
            foreach ($actionParams as $key => $value) {
                $this->addBodyClasses($key . '-' . $value);
            }
        }

        $this->_cleanClasses();
        return Html::encode(implode(' ', $this->_classes));
    }
}