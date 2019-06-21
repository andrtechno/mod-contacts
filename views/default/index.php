<?php

use panix\engine\CMS;
use panix\engine\Html;
use yii\bootstrap4\ActiveForm;


$config = Yii::$app->settings->get('contacts');
print_r($config->phone);
$phones = $config->phone;
$schedules = $config->schedule;

print_r($schedules);
?>

<?php foreach ($phones as $phone) { ?>
    <div class="mb-1"><?= Html::tel($phone['phone'], ['class' => 'phone']); ?> <?= $phone['name']; ?> (<?= CMS::phoneOperator($phone['phone']); ?>)</div>

    <?php


    $phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();

   // $phoneNumberObject = $phoneNumberUtil->parse('0117 496 0123', 'GB');
    $phoneNumberObject = $phoneNumberUtil->parse($phone['phone']);
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

<?php
$list = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

foreach ($list as $day) {
    $activeClass = ($day === strtolower(date('l'))) ? 'text-bold' : '';
    $start = $config->{$day . '_time'};
    $end = $config->{$day . '_time_end'}
    ?>
    <div class="<?= $activeClass; ?>">
        <?= $model->getAttributeLabel('monday_time'); ?>
        с <?= $start; ?> до <?= $end; ?></div>
<?php }
