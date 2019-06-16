<?php

use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;

?>
<div class="row">
<div class="col-md-7">
    <div class="card bg-light">
        <div class="card-header">
            <h5><?= Html::encode($this->context->pageName) ?></h5>
        </div>
        <div class="card-body">
            <?php
            $form = ActiveForm::begin([
                   'fieldConfig'=>[
                       'horizontalCssClasses' => [
                           'label' => 'col-sm-4 col-lg-4 col-form-label',
                           'offset' => 'col-sm-offset-4',
                           'wrapper' => 'col-sm-8 col-lg-8',
                           'error' => '',
                           'hint' => '',
                       ],
                   ]
            ]);
            ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'center')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'zoom')->dropDownList($model->getZoomList()) ?>
            <?= $form->field($model, 'width')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'height')->textInput(['maxlength' => 255]) ?>
            <div class="form-group text-center">
                <?= $model->submitButton(); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="col-md-5">
    <div class="card bg-light">
        <div class="card-header">
            <h5><?= Html::encode($this->context->pageName) ?></h5>
        </div>
        <div class="card-body">
            <?php
            echo panix\mod\contacts\widgets\map\MapWidget::widget([
                'map_id' => Yii::$app->request->get('id'),
                'options' => [
                    'width' => '100%'
                ]
            ]);
            ?>
        </div>
    </div>
</div>
</div>