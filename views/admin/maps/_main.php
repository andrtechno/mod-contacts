<?php
/**
 * @var \panix\mod\contacts\models\Maps $model
 * @var \panix\engine\bootstrap\ActiveForm $form
 */
?>

<?= $form->field($model, 'api_key')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'center')->textInput(['maxlength' => 255])->hint('12.345678, 98.765432') ?>
<?= $form->field($model, 'zoom')->dropDownList($model->getZoomList()) ?>
<?= $form->field($model, 'type')->dropDownList($model->getTypeList()) ?>
<?= $form->field($model, 'width')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'height')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'boundMarkers')->checkbox() ?>
<?= $form->field($model, 'scrollwheel')->checkbox() ?>

<?= $form->field($model, 'trafficLayer')->checkbox() ?>
<?= $form->field($model, 'transitLayer')->checkbox() ?>
<?= $form->field($model, 'bikeLayer')->checkbox() ?>
