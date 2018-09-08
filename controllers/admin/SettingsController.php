<?php

namespace panix\mod\contacts\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\contacts\models\SettingsForm;

class SettingsController extends AdminController {

    public $icon = 'settings';

    public function actionIndex() {
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
            $model->save();
        }
        return $this->render('index', [
                    'model' => $model
                ]);
    }

}
