<?php

namespace panix\mod\contacts\models;

use panix\engine\SettingsModel;
use Yii;

class SettingsForm extends SettingsModel
{

    public static $category = 'contacts';
    protected $module = 'contacts';
    public $email;
    public $phone;
    public $address;
    public $feedback_tpl_body;
    public $feedback_captcha;


    public $schedule;


    public $monday_time;
    public $tuesday_time;
    public $wednesday_time;
    public $thursday_time;
    public $friday_time;
    public $saturday_time;
    public $sunday_time;

    public $monday_time_end;
    public $tuesday_time_end;
    public $wednesday_time_end;
    public $thursday_time_end;
    public $friday_time_end;
    public $saturday_time_end;
    public $sunday_time_end;

    public function rules()
    {
        return [
            // ['schedule', 'validateSchedule', 'skipOnEmpty' => false],
            [['email', 'feedback_captcha'], "required"],
            ['phone', 'validatePhones'],
            [['feedback_tpl_body', 'phone', 'address'], 'string'],
            [['monday_time', 'tuesday_time', 'wednesday_time', 'thursday_time', 'friday_time', 'saturday_time', 'sunday_time'], 'time'],
            [['monday_time_end', 'tuesday_time_end', 'wednesday_time_end', 'thursday_time_end', 'friday_time_end', 'saturday_time_end', 'sunday_time_end'], 'time'],
        ];
    }

    public function getPhone()
    {

        return \yii\helpers\Json::decode(Yii::$app->settings->get('contacts','phone'));
    }

    public function init2()
    {

        parent::init();
        //  $this->setAttributes(['phone'=>\yii\helpers\Json::decode($this->phone)]);

        // print_r(\yii\helpers\Json::decode($this->phone));die;
        $this->phone = \yii\helpers\Json::decode(Yii::$app->settings->get('contacts','phone'));
    }

    public function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Phone number validation
     *
     * @param $attribute
     */
    public function validatePhones($attribute)
    {
        $items = $this->$attribute;
        if (!is_array($items)) {
            $items = [];
        }
        $multiple = true;
        if (!is_array($items)) {
            $multiple = false;
            $items = (array)$items;
        }
        foreach ($items as $index => $item) {
            $validator = new \yii\validators\NumberValidator();
            $error = null;
            $validator->validate($item, $error);
            if (!empty($error)) {
                $key = $attribute . ($multiple ? '[' . $index . ']' : '');
                $this->addError($key, $error);
            }
        }
    }

    public function validateSchedule($attribute)
    {
        $requiredValidator = new \yii\validators\RequiredValidator();
        foreach ($this->$attribute as $index => $row) {
            $error = null;
            foreach (['start_time', 'end_time'] as $name) {
                $error = null;
                $value = isset($row[$name]) ? $row[$name] : null;
                $requiredValidator->validate($value, $error);
                if (!empty($error)) {
                    $key = $attribute . '[' . $index . '][' . $name . ']';
                    $this->addError($key, $error);
                }
            }
        }
    }

    public function getDayList()
    {
        return ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    }
}