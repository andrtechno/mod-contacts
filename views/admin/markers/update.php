<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
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
        <?= $form->field($model, 'coords')->textInput(['maxlength' => 255]) ?>

        <?php
        echo $form->field($model, 'map_id')->dropDownList(ArrayHelper::map(panix\mod\contacts\models\Maps::find()->all(), 'id', 'name'), [
            'prompt' => '--- Укажите карту ---'
        ]);
        ?>
        <?php
        echo $form->field($model, 'opacity')->dropDownList($model->getOpacityList(), [
            'prompt' => '--- Укажите прозрачность ---'
        ]);
        ?>
        <?=
        $form->field($model, 'content_body')->widget(panix\ext\tinymce\TinyMce::class, ['options' => ['rows' => 6]]);
        ?>

        <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'CREATE') : Yii::t('app', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

            <?php ActiveForm::end(); ?>



    </div>
</div>
