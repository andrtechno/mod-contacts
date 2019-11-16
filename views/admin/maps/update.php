<?php

use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;

$config = Yii::$app->settings->get('contacts');


/**
 * @var \panix\mod\contacts\models\Maps $model
 */
?>
<div class="row">
    <div class="col-md-7">
        <?php //if ($config->map_api_key) { ?>
            <?php $form = ActiveForm::begin(); ?>
            <div class="card">
                <div class="card-header">
                    <h5><?= Html::encode($this->context->pageName) ?></h5>
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'api_key')->textInput(['maxlength' => 255]) ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
                    <?= $form->field($model, 'center')->textInput(['maxlength' => 255])->hint('46.467991, 30.740668') ?>
                    <?= $form->field($model, 'zoom')->dropDownList($model->getZoomList()) ?>
                    <?= $form->field($model, 'width')->textInput(['maxlength' => 255]) ?>
                    <?= $form->field($model, 'height')->textInput(['maxlength' => 255]) ?>
                    <?= $form->field($model, 'boundMarkers')->checkbox() ?>
                </div>
                <div class="card-footer text-center">
                    <?= $model->submitButton(); ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        <?php //} else { ?>
            <div class="alert alert-info"><?= $model::t('NO_EXIST_MAP_API_KEY'); ?></div>
        <?php //} ?>
    </div>

    <div class="col-md-5">
        <?php if (!$model->isNewRecord) { ?>
            <div class="card">
                <div class="card-header">
                    <h5>Карта</h5>
                </div>
                <div class="card-body">
                    <?php
                    echo panix\mod\contacts\widgets\map\MapWidget::widget([
                        'map_id' => $model->id,
                        'options' => [
                            'width' => '100%'
                        ]
                    ]);
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>