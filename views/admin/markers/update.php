<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

?>

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
<div class="card">
    <div class="card-header">
        <h5 class="card-title"><?= Html::encode($this->context->pageName) ?></h5>
    </div>
    <div class="card-body">

        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'coords')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'map_id')->dropDownList(ArrayHelper::map(panix\mod\contacts\models\Maps::find()->all(), 'id', 'name'), [
            'prompt' => html_entity_decode($model::t('SELECT_MAP_ID'))
        ]);
        ?>
        <?= $form->field($model, 'opacity')->dropDownList($model->getOpacityList(), [
            'prompt' => html_entity_decode($model::t('SELECT_OPACITY'))
        ]);
        ?>
        <?=
        $form->field($model, 'content_body')->widget(panix\ext\tinymce\TinyMce::class, ['options' => ['rows' => 6]]);
        ?>
    </div>
    <div class="card-footer text-center">
        <?= $model->submitButton(); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>