<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавление/редактирование типа принтеров';
?>
        <div>
                <h2 align="center">Добавление/редактирование типа принтеров</h2>
        </div>

<?php $form = ActiveForm::begin(
//        [
//            'fieldConfig' => [
//                'template' => '<div class="clearfix"><div class="label-left">{label}</div><div class="input-left">{input}</div></div>',
//                'labelOptions' => [],
//            ],
//        ]
        ); 
?>

<?= $form->field($model, 'types') ?>  
<?= $form->field($model, 'total') ?> 
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary'])?>

<?php ActiveForm::end(); ?>