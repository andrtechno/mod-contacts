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
                'label' => Yii::t('contacts/default', 'MODULE_NAME'),
                "url" => ['/admin/contacts'],
                'icon' => 'icon-phone'
            ],
            [
                'label' => Yii::t('contacts/default', 'MAPS'),
                "url" => ['/admin/contacts/maps'],
                'icon' => 'icon-location-map'
            ],
            [
                'label' => Yii::t('contacts/default', 'MARKERS'),
                "url" => ['/admin/contacts/markers'],
                'icon' => 'icon-location-marker'
            ],
            [
                'label' => Yii::t('app','SETTINGS'),
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
            'Maps' => 'panix\mod\contacts\models\Maps',
            'MapsSearch' => 'panix\mod\contacts\models\MapsSearch',
            'Markers' => 'panix\mod\contacts\models\Markers',
            'MarkersSearch' => 'panix\mod\contacts\models\MarkersSearch',
            
        ];
    }

}
