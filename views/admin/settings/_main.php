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
<?= $form->field($model, 'phone')->widget(\panix\ext\telinput\PhoneInput::class); ?>
<?= $form->field($model, 'feedback_captcha')->checkbox() ?>
<?=
$form->field($model, 'feedback_tpl_body')->widget(\panix\ext\tinymce\TinyMce::class, [
    'options' => ['rows' => 6],
]);
?>