<?php
/**
 * @var panix\mod\contacts\models\SettingsForm $model
 * @var panix\engine\bootstrap\ActiveForm $form
 */
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
<?php echo $form->field($model, 'phone')->widget(\unclead\multipleinput\MultipleInput::class,[
    'model' => $model,
    'attribute' => 'phone',
    'data'=>$model->getPhone(),
    'max' => 5,
    'min' => 1, // should be at least 2 rows
    'allowEmptyList' => false,
    'enableGuessTitle' => true,
    //'sortable'=>true,
    'addButtonPosition' => \unclead\multipleinput\MultipleInput::POS_HEADER, // show add button in the header
    'columns' => [
        [
            'name' => 'phone',
            'type' => panix\ext\telinput\PhoneInput::class,
            'title' => 'phone',
            // 'value' => function ($data) {
            //     return $data['day'];
            // },

            'headerOptions' => [
                'style' => 'width: 250px;',
            ],
        ],

    ]
]); ?>

