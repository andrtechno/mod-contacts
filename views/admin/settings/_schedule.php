<?php
use panix\engine\jui\DatetimePicker;
use yii\helpers\Html;

/**
 * @var panix\mod\contacts\models\SettingsForm $model
 * @var panix\engine\bootstrap\ActiveForm $form
 */


$list = [0=>'monday', 1=>'tuesday', 2=>'wednesday', 3=>'thursday', 4=>'friday', 5=>'saturday', 6=>'sunday']
?>


<?php
echo \unclead\multipleinput\MultipleInput::widget([
    'model' => $model,
    'attribute' => 'schedule',
    'max' => 1,
    'min' => 1,
    'allowEmptyList' => false,
    'enableGuessTitle' => true,
    //'addButtonPosition' => \unclead\multipleinput\MultipleInput::POS_HEADER, // show add button in the header
    'columns' => [
        [
            'name' => 'static', // can be ommited in case of static column
            'title' => 'Day',
            'enableError' => false,
            'type' => \unclead\multipleinput\MultipleInputColumn::TYPE_STATIC,
            'value' => function ($data, $ss) use ($model) {
//\yii\helpers\VarDumper::dump($ss,10,true);die;
                return Html::tag('span', 'static content'.$ss['index'], ['class' => 'label label-info']);
            },
            'headerOptions' => [
                'style' => 'width: 70px;',
            ]
        ],
        /*[
            'type' => \unclead\multipleinput\MultipleInputColumn::TYPE_CHECKBOX_LIST,
            'name' => 'enable',
            'headerOptions' => [
                'style' => 'width: 80px;',
            ],
            'items' => [
                1 => 'Test 1',
                2 => 'Test 2',
                3 => 'Test 3',
                4 => 'Test 4'
            ],
            'options' => [
                // see checkboxList implementation in the BaseHtml helper for getting more detail
                'unselect' => 2
            ]
        ],*/
        [
            'name' => 'start_time',
            'type' => DatetimePicker::class,
            'title' => 'Start Time',
            //'value' => function ($data) {
               // return $data['start_time'];
           // },
            'options' => [
                'timeFormat' => 'hh:mm',
                'mode' => 'time',
            ],
            'headerOptions' => [
                'style' => 'width: 250px;',
            ],
        ],
        [
            'name' => 'end_time',
            'type' => DatetimePicker::class,
            'title' => 'end Time',
           // 'value' => function ($data) {
              //  return $data['day'];
           // },
            'options' => [
                'timeFormat' => 'hh:mm',
                'mode' => 'time',
            ],
            'headerOptions' => [
                'style' => 'width: 250px;',
            ],
        ]
    ]
]);

/*
echo DatetimePicker::widget([
    'model' => $model,
    'attribute' => "{$day}_time_end",
    'mode' => 'time',
    'timeFormat'=>'hh:mm'
])*/
?>
