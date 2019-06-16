<?php

namespace panix\mod\contacts\controllers\admin;

use Yii;
use panix\mod\contacts\models\Maps;
use panix\mod\contacts\models\MapsSearch;
use panix\engine\controllers\AdminController;

class MapsController extends AdminController
{

    public function actionIndex()
    {
        $this->pageName = Yii::t('contacts/default', 'MODULE_NAME');
        $this->buttons = [
            [
                'label' => '<i class="icon-add"></i> ' . Yii::t('contacts/admin', 'CREATE_MAP'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->breadcrumbs = [$this->pageName];

        $searchModel = new MapsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionUpdate($id = false)
    {
        $model = Maps::findModel($id);


        $this->pageName = Yii::t('contacts/admin', ($id) ? 'UPDATE_MAP' : 'CREATE_MAP');
        $this->buttons = [
            [
                'label' => '<i class="icon-add"></i> ' . Yii::t('contacts/admin', 'CREATE_MAP'),
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

            Yii::$app->session->setFlash('success', Yii::t('app', 'SUCCESS_UPDATE'));
            $redirect = (isset($post['redirect'])) ? $post['redirect'] : Yii::$app->request->url;
            if (!Yii::$app->request->isAjax)
                return Yii::$app->getResponse()->redirect($redirect);

        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
