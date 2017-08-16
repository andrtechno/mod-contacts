<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use panix\engine\grid\sortable\SortableGridView;
?>




<?php Pjax::begin(); ?>
<?=

yii\grid\GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layout' => $this->render('@app/web/themes/admin/views/layouts/_grid_layout', ['title' => $this->context->pageName]), //'{items}{pager}{summary}'
    'columns' => [
        'name',
        [
            'class' => 'panix\engine\grid\ActionColumn',

        ],

    ],
]);
?>
<?php Pjax::end(); ?>

