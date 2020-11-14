<?php

namespace panix\mod\contacts\controllers\admin;

use panix\mod\contacts\models\ContactForm;
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

    public function actions()
    {
        $fake = new ContactForm();
        $fake->email = 'example@' . Yii::$app->request->serverName;
        $fake->name = 'Andrew';
        $fake->text = 'My Text';
        $fake->phone = '+380689999999';

        return [
            'preview-mail' => [
                'class' => 'panix\engine\actions\PreviewMailAction',
                'data' => ['model' => $fake]
            ],
        ];
    }

    public function actionIndex()
    {
        $this->pageName = Yii::t('app/default', 'SETTINGS');
        $this->view->params['breadcrumbs'] = [
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
                Yii::$app->session->setFlash("success", Yii::t('app/default', 'SUCCESS_UPDATE'));
                return $this->refresh();
            }
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }

}
