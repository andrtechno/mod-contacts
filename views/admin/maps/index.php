<?php

use yii\widgets\Pjax;
use panix\engine\grid\GridView;

Pjax::begin([
    'id'=>  'pjax-grid-'.mb_strtolower((new \ReflectionClass($dataProvider->query->modelClass))->getShortName()),
]);
echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        'name',
        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
        ],
    ],
]);
Pjax::end();

