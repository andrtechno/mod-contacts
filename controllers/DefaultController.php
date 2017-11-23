<?php

namespace panix\mod\contacts\controllers;

use Yii;
use panix\engine\controllers\WebController;
use panix\mod\contacts\models\ContactForm;


class DefaultController extends WebController {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {
        $this->pageName = Yii::t('contacts/default', 'MODULE_NAME');
        $this->title = $this->pageName;
        $this->breadcrumbs = [
            $this->pageName
        ];
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->send(Yii::$app->settings->get('app','email'))) {
            Yii::$app->session->setFlash('success',Yii::t('contacts/default','SUCCESS_SEND_FORM'));

            return $this->refresh();
        } else {
            return $this->render('index', [
                        'model' => $model,
            ]);
        }
    }

}
