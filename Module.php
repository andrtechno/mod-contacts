<?php

namespace panix\mod\contacts;

use Yii;
use panix\engine\WebModule;
use yii\base\BootstrapInterface;

class Module extends WebModule implements BootstrapInterface
{

    public $icon = 'phone';


    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            'contacts' => 'contacts/default/index',
            'contacts/captcha' => 'contacts/default/captcha'
        ], true);

    }

    public function getPhones()
    {
        $cfg = Yii::$app->settings->get($this->id);
        if ($cfg['phone']) {
            return explode(',', $cfg['phone']);
        } else {
            return false;
        }
    }

    public function getEmails()
    {
        $cfg = Yii::$app->settings->get($this->id);
        if ($cfg['email']) {
            return explode(',', $cfg['email']);
        } else {
            return false;
        }
    }

    public function getAddress()
    {
        $cfg = Yii::$app->settings->get($this->id);
        if ($cfg['address']) {
            return $cfg['address'];
        } else {
            return false;
        }
    }

    public function getTodayOpen($key = 0)
    {
        $config = Yii::$app->settings->get($this->id);
        $now = strtotime('2020-04-02 08:01');
        if (date('N') == $key + 1) {
            if ($now <= strtotime($config->schedule[$key]['start_time']) || $now >= strtotime($config->schedule[$key]['end_time'])) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getAdminMenu()
    {
        return [
            'modules' => [
                'items' => [
                    [
                        'label' => Yii::t('contacts/default', 'MODULE_NAME'),
                        //'url' => ['/admin/contacts'],
                        'icon' => $this->icon,
                        'items' => [
                            [
                                'label' => Yii::t('contacts/admin', 'MAPS'),
                                'url' => ['/admin/contacts/maps'],
                                'icon' => 'location-map',
                            ],
                            [
                                'label' => Yii::t('contacts/admin', 'MARKERS'),
                                'url' => ['/admin/contacts/markers'],
                                'icon' => 'location-marker',
                            ],
                            [
                                'label' => Yii::t('app/default', 'SETTINGS'),
                                "url" => ['/admin/contacts/settings'],
                                'icon' => 'settings'
                            ]
                        ]
                    ],
                ],
            ],
        ];
    }

    public function getAdminSidebar()
    {
        $menu = $this->getAdminMenu();
        //  $mod = new \panix\engine\bootstrap\Nav;
        //   $items = $mod->findMenu($this->id);
        return \yii\helpers\ArrayHelper::merge($menu['modules']['items'], $menu['modules']['items'][0]['items']);
    }

    public function getInfo()
    {
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
