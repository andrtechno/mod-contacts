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
                'label' => Yii::t('contacts/admin', 'CREATE_MAP'),
                'url' => ['create'],
                'icon' => 'add',
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->breadcrumbs[] = [
            'label' => Yii::t('contacts/default', 'MODULE_NAME'),
            'url' => ['index']
        ];
        $this->breadcrumbs[] = $this->pageName;

        $isNew = $model->isNewRecord;
        //$model->setScenario("admin");
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $model->save();
            $this->redirectPage($isNew, $post);

        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
