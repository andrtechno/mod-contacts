<?php

namespace panix\mod\contacts\controllers\admin;

use Yii;
use panix\mod\contacts\models\Maps;
use panix\mod\contacts\models\MapsSearch;
use panix\engine\controllers\AdminController;

/**
 * Class MapsController
 * @package panix\mod\contacts\controllers\admin
 */
class MapsController extends AdminController
{
    public $icon = 'location-map';

    public function actions()
    {
        return [
            'delete' => [
                'class' => 'panix\engine\actions\DeleteAction',
                'modelClass' => Maps::class,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->pageName = Yii::t('contacts/admin', 'MAPS');
        if (Yii::$app->user->can("/{$this->module->id}/{$this->id}/*") || Yii::$app->user->can("/{$this->module->id}/{$this->id}/create")) {
            $this->buttons[] = [
                'label' => Yii::t('contacts/admin', 'CREATE_MAP'),
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


        $isNew = $model->isNewRecord;


        if ($isNew) {
            $this->pageName = Yii::t('contacts/admin', 'CREATE_MAP');
        } else {
            $this->pageName = Yii::t('contacts/admin', 'UPDATE_MAP', ['name' => $model->name]);
        }

        $this->view->params['breadcrumbs'] = [
            [
                'label' => Yii::t('contacts/default', 'MODULE_NAME'),
                'url' => ['/admin/contacts'],
            ],
            [
                'label' => Yii::t('contacts/admin', 'MAPS'),
                'url' => ['index'],
            ],
            $this->pageName
        ];


        //$model->setScenario("admin");
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
