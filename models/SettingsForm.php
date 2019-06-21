<?php

namespace panix\mod\contacts\models;

use yii\helpers\Json;
use panix\engine\SettingsModel;

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
            ['schedule', 'validateSchedule', 'skipOnEmpty' => false],
            [['email', 'feedback_captcha'], "required"],
            ['phone', 'validatePhones2'],
            [['feedback_tpl_body', 'address'], 'string'],
            [['monday_time', 'tuesday_time', 'wednesday_time', 'thursday_time', 'friday_time', 'saturday_time', 'sunday_time'], 'time'],
            [['monday_time_end', 'tuesday_time_end', 'wednesday_time_end', 'thursday_time_end', 'friday_time_end', 'saturday_time_end', 'sunday_time_end'], 'time'],
        ];
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


    public function validatePhones2($attribute)
    {
        $requiredValidator = new \yii\validators\RequiredValidator();
        // $attributes = Json::decode($this->$attribute);
        $attributes = $this->$attribute;
        // var_dump($attributes);die;
        foreach ($attributes as $index => $row) {
            $error = null;
            foreach (['number', 'name'] as $name) {
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

    public function validateSchedule($attribute)
    {
        $requiredValidator = new \yii\validators\RequiredValidator();
       // $attributes = Json::decode($this->$attribute);
        $attributes = $this->$attribute;
       // var_dump($attributes);die;
        foreach ($attributes as $index => $row) {
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