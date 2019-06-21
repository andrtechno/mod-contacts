<?php

use panix\engine\CMS;
use panix\engine\Html;
use yii\bootstrap4\ActiveForm;
use panix\mod\contacts\models\SettingsForm;

$config = Yii::$app->settings->get('contacts');


?>
<?php foreach ($config->schedule as $key => $schedule) { ?>
    <div class="mb-1">
        <strong><?= SettingsForm::getDayList()[$key]; ?>.</strong>

        <?php if (!empty($schedule['start_time']) || !empty($schedule['end_time'])) { ?>

            с <?= $schedule['start_time']; ?> до <?= $schedule['end_time']; ?>
        <?php } else { ?>
            <?= SettingsForm::t('DAY_OFF'); ?>
        <?php } ?>
        <?php if (date('N') == $key + 1) { ?>
            <?php if (time() >= strtotime($schedule['end_time'])) { ?>
                <span class="font-italic text-danger">закрыто</span>
            <?php } else { ?>
                <span class="font-italic text-success">открыто</span>
            <?php } ?>
        <?php } ?>
    </div>
<?php } ?>

<?php foreach ($config->phone as $phone) { ?>
    <div class="mb-1"><?= Html::tel($phone['number'], ['class' => 'phone']); ?> <?= $phone['name']; ?>
        (<?= CMS::phoneOperator($phone['number']); ?>)
    </div>

    <?php


    $phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();

    // $phoneNumberObject = $phoneNumberUtil->parse('0117 496 0123', 'GB');
    $phoneNumberObject = $phoneNumberUtil->parse($phone['number']);
    // $phoneNumberObject = $phoneNumberUtil->parse('00 44 117 496 0123', 'FR');
    // $phoneNumberObject = $phoneNumberUtil->parse('117 496 0123', 'GB');
    //   print_r($phoneNumberObject);


    // var_dump($phoneNumberUtil->getRegionCodeForNumber($phoneNumberObject));
    // var_dump($phoneNumberUtil->format($phoneNumberObject, \libphonenumber\PhoneNumberFormat::INTERNATIONAL));
    ?>
<?php } ?>
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
        <?php if (Yii::$app->user->isGuest) { ?>
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'email') ?>
        <?php } ?>

        <?php
        if(!Yii::$app->user->phone)
            echo $form->field($model, 'phone')->widget(\panix\ext\inputmask\InputMask::class);
        ?>
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
