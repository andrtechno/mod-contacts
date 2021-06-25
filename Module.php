<?php

namespace panix\mod\contacts;

use Yii;
use panix\engine\WebModule;
use yii\base\BootstrapInterface;

/**
 * Class Module
 * @package panix\mod\contacts
 *
 * @property array $requireFields
 * @property yii\validators\Validator $phoneValidator
 * @property string $mailPath
 */
class Module extends WebModule implements BootstrapInterface
{

    public $icon = 'phone';
    public $mailPath = '@contacts/mail';
    public $phoneValidator = 'panix\ext\telinput\PhoneInputValidator';
    public $requireFields = ['name', 'phone', 'text'];

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
                        'visible' => Yii::$app->user->can('/contacts/admin/default/index') || Yii::$app->user->can('/contacts/admin/default/*'),
                        'items' => [
                            [
                                'label' => Yii::t('contacts/admin', 'MAPS'),
                                'url' => ['/admin/contacts/maps'],
                                'icon' => 'location-map',
                                'visible' => Yii::$app->user->can('/contacts/admin/maps/index') || Yii::$app->user->can('/contacts/admin/maps/*')
                            ],
                            [
                                'label' => Yii::t('contacts/admin', 'MARKERS'),
                                'url' => ['/admin/contacts/markers'],
                                'icon' => 'location-marker',
                                'visible' => Yii::$app->user->can('/contacts/admin/markers/index') || Yii::$app->user->can('/contacts/admin/markers/*')
                            ],
                            [
                                'label' => Yii::t('app/default', 'SETTINGS'),
                                "url" => ['/admin/contacts/settings'],
                                'icon' => 'settings',
                                'visible' => Yii::$app->user->can('/contacts/admin/settings/index') || Yii::$app->user->can('/contacts/admin/settings/*')
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
