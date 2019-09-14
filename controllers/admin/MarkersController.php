<?php

namespace panix\mod\contacts\controllers\admin;

use Yii;
use panix\mod\contacts\models\Markers;
use panix\mod\contacts\models\MarkersSearch;
use panix\engine\controllers\AdminController;

class MarkersController extends AdminController
{

    public function actionIndex()
    {
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

    public function actionUpdate($id = false)
    {

        $model = Markers::findModel($id);
        $this->pageName = Yii::t('contacts/admin', 'CREATE_MARKER');
        $this->buttons = [
            [
                'label' => Yii::t('contacts/admin', 'CREATE_MARKER'),
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
