<?php
/**
 * @var \panix\mod\contacts\models\Maps $model
 * @var \panix\engine\bootstrap\ActiveForm $form
 */
?>

<?= $form->field($model, 'fullscreenControl')->checkbox() ?>
<?= $form->field($model, 'streetViewControl')->checkbox() ?>
<?= $form->field($model, 'mapTypeControl')->checkbox() ?>
<?= $form->field($model, 'zoomControl')->checkbox() ?>
<?= $form->field($model, 'scaleControl')
    ->checkbox()
    ->hint('элемент управления Scale, который обеспечивает простой масштаб карты. По умолчанию этот элемент управления не отображается. Когда он включен, он всегда будет отображаться в правом нижнем углу карты.') ?>
<?= $form->field($model, 'rotateControl')->checkbox() ?>


