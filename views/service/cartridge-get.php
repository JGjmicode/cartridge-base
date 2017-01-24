
<?php
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<div>
    <h4>Выбор картриджей</h4>
</div>


<?php Pjax::begin(['id' => 'cartridge_select']) ?>
<?= GridView::widget([
    'dataProvider' => $CartridgeProvider,
    'filterModel' => $CartridgeSearchModel,
    'columns' => [
        ['attribute' => 'model',
            'label' => 'Модель картриджа'],
        ['attribute' => 'serial',
            'label' => 'Серийный номер'],
        ['attribute' => 'inv_number',
            'label' => 'Инвентарный номер'],
        ['attribute' => 'printersTypes.types',
            'label' => 'Тип принтера'],
        [
            'label' => 'Выбрать',
            'format' => 'raw',
            'value' => function($data){
                return Html::a(
                    'Выбрать',
                    '#',
                    [
                        'data-toggle' => 'modal',
                        'data-target' => '#service_modal',
                        'class' => 'btn btn-warning',
                        'onclick' => "getId($data->id, '', '', 'Картридж + чип')",
                    ]
                );
            }
        ],

    ],
])?>

<?php
echo 'Картриджей добавлено в акт: ' .count($basket);
?>
<?php Pjax::end() ?>
<?php
echo HTML::a('Продолжить', ['/service/new-get-act'], ['class' => 'btn btn-primary']);
?>



<?php Modal::begin([
    'size' => 'modal-lg',
    'options' => [
        'id' => 'service_modal',
    ]
//    'toggleButton' => [
//        'label' => 'модальное окно'
//    ]

]);?>
<?php Pjax::begin(['id' => 'cartridge_service']) ?>
<?php $form = ActiveForm::begin(['options' => ['data-pjax' => true, 'id' => 'add-to-basket']]);?>
<?=$form->field($model, 'works')?>
<?=$form->field($model, 'komplekt')?>
<?=$form->field($model, 'weidth')?>
<?= $form->field($model, 'cartridge_id', ['template' => '{input}'])->hiddenInput(); ?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'onclick' => 'saveToBasket()'])?>
<?php ActiveForm::end();?>
<?php Pjax::end() ?>
<?php

?>

<?php Modal::end();?>
<?= Html::jsFile('@web/js/service.js') ?>




