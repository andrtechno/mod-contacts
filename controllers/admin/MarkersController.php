<?php

namespace panix\mod\contacts\controllers\admin;

use Yii;
use panix\mod\contacts\models\Markers;
use panix\mod\contacts\models\MarkersSearch;
use panix\engine\controllers\AdminController;

class MarkersController extends AdminController {

    public function actionIndex() {
        $this->pageName = Yii::t('contacts/default', 'MODULE_NAME');
        $this->buttons = [
            [
                'label' => '<i class="icon-add"></i> ' . Yii::t('contacts/admin', 'CREATE_MARKER'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->breadcrumbs = [
            $this->pageName
        ];

        $searchModel = new MarkersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionUpdate($id = false) {

        if ($id === true) {
            $model = Yii::$app->getModule("contacts")->model("Markers");
        } else {
            $model = $this->findModel($id);
        }

        $this->pageName = Yii::t('contacts/admin', 'CREATE_MARKER');
        $this->buttons = [
            [
                'label' => '<i class="icon-add"></i> ' . Yii::t('contacts/admin', 'CREATE_MARKER'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->breadcrumbs[] = [
            'label' => Yii::t('contacts/default', 'MODULE_NAME'),
            'url' => ['index']
        ];
        $this->breadcrumbs[] = $this->pageName;



        //$model->setScenario("admin");
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $model->save();
            return Yii::$app->getResponse()->redirect(['/admin/contacts/markers']);
        }
        echo $this->render('update', [
                    'model' => $model,
        ]);
    }

    protected function findModel($id) {
        $model = Yii::$app->getModule("contacts")->model("Markers");
        if (($model = $model::findOne($id)) !== null) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('app/error', '404'));
        }
    }

}
