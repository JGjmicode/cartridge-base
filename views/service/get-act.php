<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
$this->title = 'Новый акт';
?>
<div>
    <h4>Новый акт</h4>
</div>
<?php Pjax::begin(['id' => 'cartridge_select']) ?>
<?= GridView::widget([
    'dataProvider' => $BasketProvider,
    'filterModel' => $BasketSearchModel,
    'columns' => [
        ['attribute' => 'cartridges.model',
            'label' => 'Модель картриджа'],
        ['attribute' => 'cartridges.serial',
            'label' => 'Серийный номер'],
        ['attribute' => 'cartridges.inv_number',
            'label' => 'Инв №'],
        ['attribute' => 'cartridges.inv_service',
            'label' => 'Инв № сервиса'],
        ['attribute' => 'works',
            'label' => 'Выполненые работы'],
        ['attribute' => 'komplekt',
            'label' => 'Комплектность'],
        [
            'label' => 'Изменить',
            'format' => 'raw',
            'value' => function($data){
                return Html::a(
                    'Изменить',
                    '#',
                    [
                        'data-toggle' => 'modal',
                        'data-target' => '#service_modal',
                        'class' => 'btn btn-warning',
                        'onclick' => "getId($data->id, '$data->problem', '$data->weidth', '$data->komplekt')",
                    ]
                );
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' =>[
                'delete' => function($url, $model){
                    return Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>',
                        ['/service/delete', 'action' => 'get', 'id' => $model->id]
                    );
                }
            ]
        ],

    ],
])?>
<?php Pjax::end() ?>

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

<?=Html::a('Добавить картридж',['/service/new-get'], ['class' => 'btn btn-primary'])?>
<?=Html::a('Принять работы',['/service/get-from-service'], ['class' => 'btn btn-primary'])?>
<?= Html::jsFile('@web/js/service.js') ?>