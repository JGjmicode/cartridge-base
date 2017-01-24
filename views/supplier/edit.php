<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Добавление/изменение поставщика';
?>

<div>
    <h2 align="center">Добавление/изменение поставщика</h2>
</div>



<?php
$form = ActiveForm::begin();
?>
<?=$form->field($model, 'title')?>
<?=$form->field($model, 'note')?>
<?=Html::submitButton('Сохранить', ['class' => 'btn btn-primary'])?>
<?php ActiveForm::end();?>
