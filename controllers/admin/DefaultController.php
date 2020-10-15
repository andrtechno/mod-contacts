<?php

namespace panix\mod\contacts\controllers\admin;

use Yii;
use panix\mod\contacts\models\Pages;
use panix\mod\contacts\models\PagesSearch;
use panix\engine\controllers\AdminController;

/**
 * Class DefaultController
 * @package panix\mod\contacts\controllers\admin
 */
class DefaultController extends AdminController
{


    public function actionIndex()
    {
        $this->pageName = Yii::t('contacts/default', 'MODULE_NAME');
        $this->view->params['breadcrumbs'][] = [
            $this->pageName
        ];

        // $searchModel = new PagesSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            //      'dataProvider' => $dataProvider,
            //     'searchModel' => $searchModel,
        ]);
    }


}
