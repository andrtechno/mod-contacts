<?php

namespace panix\mod\contacts\controllers;

use Yii;
use panix\engine\controllers\WebController;
use panix\mod\contacts\models\ContactForm;
use yii\web\Response;
use yii\widgets\ActiveForm;


class DefaultController extends WebController
{

    public function actionIndex()
    {
        $this->pageName = Yii::t('contacts/default', 'MODULE_NAME');
        $this->view->title = $this->pageName;
        $this->view->params['breadcrumbs'] = [
            $this->pageName
        ];
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if($model->validate()){
                $emails = explode(',',Yii::$app->settings->get('contacts', 'email'));
                foreach ($emails as $email){
                    $model->send($email);
                }

                Yii::$app->session->setFlash('success', Yii::t('contacts/default', 'SUCCESS_SEND_FORM'));

                return $this->refresh();
            }
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
