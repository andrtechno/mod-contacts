<?php
/**
 * @var panix\mod\contacts\models\SettingsForm $model
 * @var panix\engine\bootstrap\ActiveForm $form
 */


print_r(Yii::$app->settings->get('contacts', 'address'));
?>

<?=
$form->field($model, 'email')
    ->widget(\panix\ext\taginput\TagInput::class, ['placeholder' => 'E-mail'])
    ->hint('Введите E-mail и нажмите Enter');
?>
<?php //echo $form->field($model, 'address'); ?>
<?= $form->field($model, 'map_api_key'); ?>
<?= $form->field($model, 'feedback_captcha')->checkbox() ?>
<?=
$form->field($model, 'feedback_tpl_body')->widget(\panix\ext\tinymce\TinyMce::class, [
    'options' => ['rows' => 6],
]);


?>
<?php echo $form->field($model, 'phone')->widget(\panix\ext\multipleinput\MultipleInput::class, [
    'max' => 5,
    'min' => 1, // should be at least 2 rows
    'allowEmptyList' => false,
    //'enableGuessTitle' => true,
    'sortable' => true,
    'addButtonPosition' => \panix\ext\multipleinput\MultipleInput::POS_ROW, // show add button in the header
    'columns' => [
        [
            'name' => 'number',
            'type' => panix\ext\telinput\PhoneInput::class,
            'enableError' => false,
            'title' => $model::t('PHONE'),
            'headerOptions' => [
                'style' => 'width: 250px;',
            ],
        ],
        [
            'name' => 'name',
            'enableError' => false,
            'title' => 'Имя',
            'options' => [
                'placeholder' => 'Ваше Имя',
            ],
        ],
    ]
]);

echo $form->field($model, 'address')->widget(\panix\ext\multipleinput\MultipleInput::class, [
    'max' => count(Yii::$app->languageManager->languages),
    'min' => count(Yii::$app->languageManager->languages),
    'allowEmptyList' => false,

    'rendererClass' => \panix\ext\multipleinput\renderers\TableLanguageRenderer::class,
    'columns' => [
        [
            'name' => 'address',
            //'enableError' => true,
            'type' => \panix\ext\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
            'options' => [
                'class' => 'input-lang',
                'placeholder' => 'Адрес',
            ],
        ],
    ]
]);


