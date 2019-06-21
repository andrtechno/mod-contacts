<?php
/**
 * @var panix\mod\contacts\models\SettingsForm $model
 * @var panix\engine\bootstrap\ActiveForm $form
 */

\yii\helpers\VarDumper::dump(Yii::$app->settings->get('contacts'),10,true);
?>

<?=
$form->field($model, 'email')
    ->widget(\panix\ext\taginput\TagInput::class, ['placeholder' => 'E-mail'])
    ->hint('Введите E-mail и нажмите Enter');
?>
<?= $form->field($model, 'address'); ?>
<?php //echo $form->field($model, 'phone')->widget(\panix\ext\telinput\PhoneInput::class); ?>
<?= $form->field($model, 'feedback_captcha')->checkbox() ?>
<?=
$form->field($model, 'feedback_tpl_body')->widget(\panix\ext\tinymce\TinyMce::class, [
    'options' => ['rows' => 6],
]);


?>
<?php echo $form->field($model, 'phone')->widget(\unclead\multipleinput\MultipleInput::class, [
    'model' => $model,
    'attribute' => 'phone',
    'max' => 5,
    'min' => 1, // should be at least 2 rows
    'allowEmptyList' => false,
    //'enableGuessTitle' => true,
    'sortable' => true,
    'addButtonPosition' => \unclead\multipleinput\MultipleInput::POS_ROW, // show add button in the header
    'columns' => [
        [
            'name' => 'number',
            'type' => panix\ext\telinput\PhoneInput::class,
            // 'title' => 'phone',
            // 'value' => function ($data) {
            //     return $data['day'];
            // },

            'headerOptions' => [
                'style' => 'width: 250px;',
            ],
        ],
        [
            'name' => 'name',
            'title' => 'Имя',
            // 'value' => function ($data) {
            //     return $data['day'];
            // },

        ],

    ]
]);


