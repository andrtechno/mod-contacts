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
        <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-header">
                <h5><?= Html::encode($this->context->pageName) ?></h5>
            </div>
            <div class="card-body">

                <?php
                echo panix\engine\bootstrap\Tabs::widget([
                    'items' => [
                        [
                            'label' => 'Общие',
                            'content' => $this->render('_main', ['form' => $form, 'model' => $model]),
                            'active' => true,
                        ],
                        [
                            'label' => 'Контроль панель',
                            'content' => $this->render('_control', ['form' => $form, 'model' => $model]),
                            'headerOptions' => [],
                        ],
                    ],
                ]);
                ?>


            </div>
            <div class="card-footer text-center">
                <?= $model->submitButton(); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
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