<?php

namespace panix\mod\contacts\controllers\admin;

use Yii;
use yii\helpers\Json;
use panix\engine\controllers\AdminController;
use panix\mod\contacts\models\SettingsForm;

/**
 * Class SettingsController
 * @package panix\mod\contacts\controllers\admin
 */
class SettingsController extends AdminController
{

    public $icon = 'settings';

    public function actionIndex()
    {
        $this->pageName = Yii::t('app', 'SETTINGS');
        $this->breadcrumbs = [
            [
                'label' => $this->module->info['label'],
                'url' => $this->module->info['url'],
            ],
            $this->pageName
        ];
        $model = new SettingsForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
            }else{
                print_r($model->getErrors());
                die('error');
            }
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }

}
