<?php

namespace panix\mod\contacts\models;

use panix\engine\SettingsModel;

class SettingsForm extends SettingsModel {

    protected $category = 'contacts';
    protected $module = 'contacts';
    public $pagenum;

    public function rules() {
        return [
            [['pagenum'], "required"],
        ];
    }

}