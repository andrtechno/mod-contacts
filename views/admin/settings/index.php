<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
use panix\engine\bootstrap\Modal;

$form = ActiveForm::begin();
?>
    <div class="card">
        <div class="card-header">
            <h5><?= $this->context->pageName ?></h5>
        </div>
        <div class="card-body">
            <?php
            echo yii\bootstrap4\Tabs::widget([
                'items' => [
                    [
                        'label' => $model::t('TAB_GENERAL'),
                        'content' => $this->render('_main', ['form' => $form, 'model' => $model]),
                        'active' => true,
                    ],
                    [
                        'label' => $model::t('TAB_SCHEDULE'),
                        'content' => $this->render('_schedule', ['form' => $form, 'model' => $model]),
                    ],
                ],
            ]);
            ?>
        </div>
        <div class="card-footer text-center">
            <?= Html::submitButton(Yii::t('app/default', 'SAVE'), ['class' => 'btn btn-success']) ?>
            <?php
            Modal::begin([
                'title' => 'Предварительный просмотр',
                'size'=>Modal::SIZE_LARGE,
                'toggleButton' => ['label' => 'Пред. просмотр шаблона','class'=>'btn btn-outline-secondary'],
            ]);
            ?>
            <div class="embed-responsive embed-responsive-4by3">
                <iframe class="embed-responsive-item" src="<?= \yii\helpers\Url::to(['preview-mail','view'=>Yii::$app->settings->get('contacts','feedbackMailBody')]); ?>"></iframe>
            </div>
            <?php Modal::end(); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>