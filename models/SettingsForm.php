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
    public $feedback_captach;

    public function rules() {
        return [
            [['email','feedback_captach'], "required"],
            [['feedback_tpl_body','phone','address'], 'string'],
            
  
            
        ];
    }

}