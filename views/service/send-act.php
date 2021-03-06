<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use app\models\Departaments;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;
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
            'label' => 'Инвентарный номер'],
        ['attribute' => 'problem',
            'label' => 'Описание неисправности'],
        ['attribute' => 'weidth',
            'label' => 'Вес, гр'],
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
                        'onclick' => "sendId($data->id, '$data->problem', '$data->weidth', '$data->komplekt', $data->departament_id)",
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
                        ['/service/delete', 'action' => 'send', 'id' => $model->id]
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


]);?>
<?php Pjax::begin(['id' => 'cartridge_service']) ?>
<?php $form = ActiveForm::begin(['options' => ['data-pjax' => true, 'id' => 'add-to-basket']]);?>
<?=$form->field($model, 'problem')?>
<?=$form->field($model, 'komplekt')?>
<?=$form->field($model, 'weidth')?>
<?= $form->field($model, 'cartridge_id', ['template' => '{input}'])->hiddenInput(); ?>
<?php
$departament = empty($model->departament_id) ? 'Выберите отдел' : is_null(Departaments::findOne($model->departament_id)) ? 'Отдел не выбран' : Departaments::findOne($model->departament_id)->name;
$get_departamnet = Url::to(['/departaments/get-departament']);
echo $form->field($model, 'departament_id')->label('Отдел:&nbsp')->widget(Select2::classname(), [
    'initValueText' => $departament, // set the initial display text
    'options' => ['placeholder' => 'Выбор отдела ...'],
    'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 1,
        'language' => [
            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
            'url' => $get_departamnet,
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
        //'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        //'templateResult' => new JsExpression('function(city) { return city.text; }'),
        //'templateSelection' => new JsExpression('function (city) { return city.text; }'),
    ],
]);
?>


<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'onclick' => 'saveToBasket()'])?>
<?php ActiveForm::end();?>
<?php Pjax::end() ?>
<?php

?>

<?php Modal::end();?>

<?=Html::a('Добавить картридж',['/service/new-send'], ['class' => 'btn btn-primary'])?>
<?=Html::a('Передать',['/service/send-to-service'], ['class' => 'btn btn-primary'])?>
<?= Html::jsFile('@web/js/service.js') ?>