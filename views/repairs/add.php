<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Добавление новой неисправности в список';
?>

<h2 align="center">Добавление новой неисправности в список</h2>


<div class="container">
    <?php $form = ActiveForm::begin();?>
    <div class="col-md-6">
        <?= $form->field($model, 'model')?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'invNumber')?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'cabinet')?>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <?= $form->field($model, 'problem')->textarea(['rows' => '2', 'cols' => 5])?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'note')->textarea(['rows' => '2', 'cols' => 5])?>
    </div>
    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary'])?>
    <?php ActiveForm::end();?>
</div>
