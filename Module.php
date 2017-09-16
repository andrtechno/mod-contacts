<?php

namespace panix\mod\contacts;

use Yii;
use panix\engine\WebModule;

class Module extends WebModule {

    public $icon = 'phone';
    public $routes = [
        'contacts/captach' => 'contacts/default/captcha'
    ];

    public function getAdminMenu() {
        return [
            'modules' => [
                'items' => [
                    [
                        'label' => Yii::t('contacts/default', 'MODULE_NAME'),
                        'url' => ['/admin/contacts'],
                        'icon' => $this->icon,
                        'items' => [
                            [
                                'label' => Yii::t('contacts/default', 'MAPS'),
                                'url' => ['/admin/contacts/maps'],
                                'icon' => 'location-map',
                            ],
                            [
                                'label' => Yii::t('contacts/default', 'MARKERS'),
                                'url' => ['/admin/contacts/markers'],
                                'icon' => 'location-marker',
                            ],
                            [
                                'label' => Yii::t('app', 'SETTINGS'),
                                "url" => ['/admin/contacts/settings'],
                                'icon' => 'settings'
                            ]
                        ]
                    ],
                ],
            ],
        ];
    }

    public function getAdminSidebar() {
        $menu = $this->getAdminMenu();
        //  $mod = new \panix\engine\widgets\nav\Nav;
        //   $items = $mod->findMenu($this->id);
        return \yii\helpers\ArrayHelper::merge($menu['modules']['items'],$menu['modules']['items'][0]['items']);
    }

    public function getInfo() {
        return [
            'label' => Yii::t('contacts/default', 'MODULE_NAME'),
            'author' => 'andrew.panix@gmail.com',
            'version' => '1.0',
            'icon' => $this->icon,
            'description' => Yii::t('contacts/default', 'MODULE_DESC'),
            'url' => ['/admin/contacts'],
        ];
    }

}
