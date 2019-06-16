<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;


$config = Yii::$app->settings->get('contacts');
?>
<div class="row">
    <div class="col-sm-6">
        <?php
        echo panix\mod\contacts\widgets\map\MapWidget::widget(['map_id' => 1]);
        ?>


        <?php
        /* $coords = [];
          $coords[] = new LatLng(['lat' => 46.468252, 'lng' => 30.740576]);
          $coords[] = new LatLng(['lat' => 46.453163, 'lng' => 30.751179]);

          $coord = new LatLng(['lat' => 46.458252, 'lng' => 30.742576]);
          $map = new Map([
          'center' => $coord,
          'zoom' => 14,
          ]);
          $markers = [];
          foreach ($coords as $coord) {

          $markers = new Marker([
          'position' => $coord,
          'title' => 'My Home Town',
          ]);

          $markers->attachInfoWindow(
          new InfoWindow([
          'content' => '<p>This is my super cool content</p>'
          ])
          );

          $map->addOverlay($markers);
          }

          echo $map->display(); */
        ?>
    </div>
    <div class="col-sm-6">
        <?php if (Yii::$app->session->hasFlash('success')) { ?>
            <div class="alert alert-success">
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php } ?>

        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'phone')->widget(\panix\ext\inputmask\InputMask::class); ?>
        <?= $form->field($model, 'text')->textArea(['rows' => 6]) ?>
        <?php if ($config->feedback_captcha || Yii::$app->user->isGuest) { ?>
            <?=
            $form->field($model, 'verifyCode')->widget(yii\captcha\Captcha::class, [
                'captchaAction' => 'default/captcha',
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            ])
            ?>
        <?php } ?>
        <?= $form->field($model, 'reCaptcha')->widget(\panix\engine\widgets\recaptcha\ReCaptcha::class) ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'SEND'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>

