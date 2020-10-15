<?php

namespace panix\mod\contacts\controllers\admin;

use Yii;
use panix\mod\contacts\models\Markers;
use panix\mod\contacts\models\MarkersSearch;
use panix\engine\controllers\AdminController;

/**
 * Class MarkersController
 * @package panix\mod\contacts\controllers\admin
 */
class MarkersController extends AdminController
{
    public $icon = 'location-marker';

    public function actions()
    {
        return [
            'delete' => [
                'class' => 'panix\engine\actions\DeleteAction',
                'modelClass' => Markers::class,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->pageName = Yii::t('contacts/admin', 'MARKERS');
        if (Yii::$app->user->can("/{$this->module->id}/{$this->id}/*") || Yii::$app->user->can("/{$this->module->id}/{$this->id}/create")) {
            $this->buttons[] = [
                'label' => Yii::t('contacts/admin', 'CREATE_MARKER'),
                'url' => ['create'],
                'icon' => 'add',
                'options' => ['class' => 'btn btn-success']
            ];
        }
        $this->view->params['breadcrumbs'] = [
            [
                'label' => Yii::t('contacts/default', 'MODULE_NAME'),
                'url' => ['/admin/contacts'],
            ],
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
        $isNew = $model->isNewRecord;

        if ($isNew) {
            $this->pageName = Yii::t('contacts/admin', 'CREATE_MARKER');
        } else {
            $this->pageName = Yii::t('contacts/admin', 'UPDATE_MARKER', ['name' => $model->name]);
        }

        $this->breadcrumbs = [
            [
                'label' => Yii::t('contacts/default', 'MODULE_NAME'),
                'url' => ['/admin/contacts'],
            ],
            [
                'label' => Yii::t('contacts/admin', 'MARKERS'),
                'url' => ['index'],
            ],
            $this->pageName
        ];


        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $model->save();
            return $this->redirectPage($isNew, $post);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }



    public function actionCreate()
    {
        return $this->actionUpdate(false);
    }
}
