<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

?>
<?php
$form = ActiveForm::begin([
    //  'id' => 'form',
    'options' => ['class' => 'form-horizontal'],
]);
?>
    <div class="card bg-light">
        <div class="card-header">
            <h5><?= $this->context->pageName ?></h5>
        </div>
        <div class="card-body">


            <?php
            echo yii\bootstrap4\Tabs::widget([
                'items' => [
                    [
                        'label' => 'Общие',
                        'content' => $this->render('_main', ['form' => $form, 'model' => $model]),
                        'active' => true,
                    ],
                    [
                        'label' => 'График работы',
                        'content' => $this->render('_schedule', ['form' => $form, 'model' => $model]),
                    ],
                ],
            ]);
            ?>



        </div>
        <div class="card-footer text-center">
            <?= Html::submitButton(Yii::t('app', 'SAVE'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>