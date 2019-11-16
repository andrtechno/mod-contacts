<?php

use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * @var \panix\mod\contacts\models\Markers $model
 */
$form = ActiveForm::begin();
?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title"><?= Html::encode($this->context->pageName) ?></h5>
    </div>
    <div class="card-body">

        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'coords')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'draggable')->checkbox() ?>
        <?= $form->field($model, 'map_id')->dropDownList(ArrayHelper::map(panix\mod\contacts\models\Maps::find()->all(), 'id', 'name'), [
            'prompt' => html_entity_decode($model::t('SELECT_MAP_ID'))
        ]);
        ?>
        <?= $form->field($model, 'opacity')->dropDownList($model->getOpacityList(), [
            'prompt' => html_entity_decode($model::t('SELECT_OPACITY'))
        ]);
        ?>
        <?= $form->field($model, 'animation')->dropDownList($model->getAnimationList(), [
            'prompt' => html_entity_decode($model::t('SELECT_ANIMATION'))
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