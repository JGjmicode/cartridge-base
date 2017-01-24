<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Добавление/изменение заказчика';
?>

<h2 align="center">Добавление/изменение заказчика</h2>


<?php
    $form = ActiveForm::begin();
?>
<?=$form->field($model, 'name')?>
<?=$form->field($model, 'nameRP')?>
<?=$form->field($model, 'position')?>
<?=Html::submitButton('Сохранить', ['class' => 'btn btn-primary'])?>
<?php ActiveForm::end();?>
