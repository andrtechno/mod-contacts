<?php

namespace panix\mod\contacts;

use Yii;
use panix\engine\WebModule;

class Module extends WebModule {


    public $routes = [
        'page/<url>' => 'contacts/default/view',
        'contacts/captach'=>'contacts/default/captcha'
    ];

    public function getNav() {
        return [
            [
                'label' => 'Станицы',
                "url" => ['/admin/contacts'],
                'icon' => 'icon-phone'
            ],
            [
                'label' => 'Настройки',
                "url" => ['/admin/contacts/settings'],
                'icon' => 'icon-settings'
            ]
        ];
    }

    public function getInfo() {
        return [
            'name' => Yii::t('contacts/default', 'MODULE_NAME'),
            'author' => 'andrew.panix@gmail.com',
            'version' => '1.0',
            'icon' => 'icon-phone',
            'description' => Yii::t('contacts/default', 'MODULE_DESC'),
            'url' => ['/admin/contacts'],
        ];
    }

    protected function getDefaultModelClasses() {
        return [
            'Pages' => 'panix\mod\contacts\models\Pages',
            'PagesSearch' => 'panix\mod\contacts\models\PagesSearch',
        ];
    }

}
