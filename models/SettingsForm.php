<?php

namespace panix\mod\contacts\models;

use panix\engine\SettingsModel;


class SettingsForm extends SettingsModel {

    public static $category = 'contacts';
    protected $module = 'contacts';
    public $email;
    public $phone;
    public $address;
    public $feedback_tpl_body;
    public $feedback_captcha;


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

    public function rules() {
        return [
            [['email','feedback_captcha'], "required"],
            [['feedback_tpl_body','phone','address'], 'string'],

            //[['monday_time','tuesday_time','wednesday_time','thursday_time','friday_time','saturday_time','sunday_time'], 'string','max'=>5],
            //[['monday_time_end','tuesday_time_end','wednesday_time_end','thursday_time_end','friday_time_end','saturday_time_end','sunday_time_end'], 'string','max'=>5],
            [['monday_time','tuesday_time','wednesday_time','thursday_time','friday_time','saturday_time','sunday_time'], 'time'],
            [['monday_time_end','tuesday_time_end','wednesday_time_end','thursday_time_end','friday_time_end','saturday_time_end','sunday_time_end'], 'time'],
        ];
    }

}