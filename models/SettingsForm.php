<?php

namespace panix\mod\contacts\models;

use panix\engine\SettingsModel;


class SettingsForm extends SettingsModel {

    protected $category = 'contacts';
    protected $module = 'contacts';
    public $email;
    public $phone;
    public $feedback_tpl_body;

    public function rules() {
        return [
            [['email'], "required"],
            [['feedback_tpl_body'], 'string'],
            
  
            
        ];
    }

}