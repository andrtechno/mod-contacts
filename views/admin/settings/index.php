<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
use panix\ext\taginput\TagInput;
use panix\engine\widgets\inputmask\InputMask;
use panix\ext\tinymce\TinyMce;

?>
<?php
$form = ActiveForm::begin([
    //  'id' => 'form',
    'options' => ['class' => 'form-horizontal'],
]);
?>
    <div class="card bg-light">
        <div class="card-header">
            <h5><?= $this->context->pageName ?></h5>
        </div>
        <div class="card-body">
            <?=
            $form->field($model, 'email')
                ->widget(TagInput::class, ['placeholder' => 'E-mail'])
                ->hint('Введите E-mail и нажмите Enter');
            ?>
            <?= $form->field($model, 'address'); ?>
            <?php //echo $form->field($model, 'phone')->widget(InputMask::class); ?>

            <?= $form->field($model, 'phone')->widget(\panix\ext\telinput\TelInput::class); ?>


            <?= $form->field($model, 'feedback_captach')->checkbox() ?>
            <?=
            $form->field($model, 'feedback_tpl_body')->widget(TinyMce::class, [
                'options' => ['rows' => 6],
            ]);
            ?>

        </div>
        <div class="card-footer text-center">
            <?= Html::submitButton(Yii::t('app', 'SAVE'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>