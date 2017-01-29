<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = 'Добавление/изменение исполнителя';
?>


    <h2 align="center">Добавление/изменение исполнителя</h2>


<?php
$form = ActiveForm::begin();
?>
<?=$form->field($model, 'title')?>
<?=$form->field($model, 'person')?>
<?=$form->field($model, 'e_mail')?>
<?=$form->field($model, 'phone')?>
<?=Html::submitButton('Сохранить', ['class' => 'btn btn-primary'])?>
<?php ActiveForm::end();?>
