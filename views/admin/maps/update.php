<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>



<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Html::encode($this->context->pageName) ?></h3>
    </div>
    <div class="panel-body">


<?php
$form = ActiveForm::begin([
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-4',
                    'offset' => 'col-sm-offset-4',
                    'wrapper' => 'col-sm-8',
                    'error' => '',
                    'hint' => '',
                ],
            ],
            'options' => ['class' => 'form-horizontal']
        ]);
?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'zoom')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'width')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'height')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'center')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'grayscale')->checkbox() ?>
        <?= $form->field($model, 'night_mode')->hint('Пожалуйста, введите имя')->checkbox() ?>


<?php
$morning = "Доброе утро!";
$day = "Добрый день!";
$evening = "Добрый вечер!";
$night = "Доброй ночи!";

$minute = date("i");
$hour = date("H");

if ($hour >= 04) {
    $hello = $morning;
}
if ($hour >= 10) {
    $hello = $day;
}
if ($hour >= 16) {
    $hello = $evening;
}
if ($hour >= 22 or $hour < 04) {
    $hello = $night;
}

echo "Время: $minute:$minute, $hello";
?> 

        <div class="form-group text-center">
<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'CREATE') : Yii::t('app', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

<?php ActiveForm::end(); ?>



    </div>
</div>
