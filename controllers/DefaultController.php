<?php

namespace panix\contacts\controllers;

use Yii;
use panix\engine\controllers\WebController;
use panix\contacts\models\Pages;
use yii\web\NotFoundHttpException;

class DefaultController extends WebController {

    public $model;

    public function actionIndex() {
        $all = Pages::find()->all();
        $one = Pages::findOne(3);
        echo Yii::$app->request->getQueryParam('language');
        return $this->render('index', [
                    'model' => $all,
                    'one' => $one
                ]);
    }

    public function actionView($url) {

        $this->findModel($url);
        return $this->render('view', ['model' => $this->model]);
    }

    protected function findModel($url) {
        $model = Yii::$app->getModule("contacts")->model("Pages");
        if (($this->model = $model::find()->where(['seo_alias' => $url])->one()) !== null) {
            return $this->model;
        } else {
            throw new NotFoundHttpException('page not found');
        }
    }

}
