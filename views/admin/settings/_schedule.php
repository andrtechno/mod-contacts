<?php
use panix\engine\jui\DatetimePicker;
use yii\helpers\Html;

/**
 * @var panix\mod\contacts\models\SettingsForm $model
 * @var panix\engine\bootstrap\ActiveForm $form
 */


$list = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']
?>
<div class="alert alert-info">Если поле оставить пустым, то это будет выходной.</div>
<table class="table table-striped">
    <tr>
        <th>День</th>
        <th>Начало работы</th>
        <th>Время окончания</th>
    </tr>
    <?php foreach ($list as $day) { ?>
        <tr>
            <td><?= Html::activeLabel($model, "{$day}_time"); ?></td>
            <td>
                <?php
                echo DatetimePicker::widget([
                    'model' => $model,
                    'attribute' => "{$day}_time",
                    'mode' => 'time',
                    'timeFormat'=>'hh:mm'
                ])
                ?>
                <?= Html::error($model, "{$day}_time"); ?>
            </td>
            <td>
                <?php
                echo DatetimePicker::widget([
                    'model' => $model,
                    'attribute' => "{$day}_time_end",
                    'mode' => 'time',
                    'timeFormat'=>'hh:mm'
                ])
                ?>
                <?= Html::error($model, "{$day}_time_end"); ?>
            </td>
        </tr>
    <?php } ?>
</table>
