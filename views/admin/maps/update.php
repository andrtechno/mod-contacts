<?php

use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;

?>
<div class="row">
    <div class="col-md-7">
        <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-header">
                <h5><?= Html::encode($this->context->pageName) ?></h5>
            </div>
            <div class="card-body">
                <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
                <?= $form->field($model, 'center')->textInput(['maxlength' => 255]) ?>
                <?= $form->field($model, 'zoom')->dropDownList($model->getZoomList()) ?>
                <?= $form->field($model, 'width')->textInput(['maxlength' => 255]) ?>
                <?= $form->field($model, 'height')->textInput(['maxlength' => 255]) ?>
            </div>
            <div class="card-footer text-center">
                <?= $model->submitButton(); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="col-md-5">
        <?php if(!$model->isNewRecord){ ?>
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