<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\datetime\DateTimePicker;
use app\models\Customer;
use app\models\Contractor;
use yii\widgets\ActiveForm;
$this->title = "Акт передачи/приема  оборудования из ремонта № $serviceGet->get_act_id от ".date("d-m-Y", $serviceGet->create_at);
?>

<?=Html::a('Новый акт', ['service/new-get'], ['class' => 'btn btn-primary'])?>

<div>
    <h1>Акт передачи/приема  оборудования из ремонта № <?=$serviceGet->get_act_id?> от <?=date("d-m-Y", $serviceGet->create_at)?></h1>
</div>
<?php
$form = ActiveForm::begin();
?>
<div class="col-md-3">
    <?=$form->field($model, 'customer_id')->dropdownList(
        Customer::find()->select(['name', 'id'])->indexBy('id')->column(),
        ['prompt'=>'Заказчик'])?>
</div>
<div class="col-md-3">
    <?=$form->field($model, 'contractor_id')->dropdownList(
        Contractor::find()->select(['title', 'id'])->indexBy('id')->column(),
        ['prompt'=>'Исполнитель'])?>
</div>
<div class="col-md-3">
    <?=$form->field($model, 'create_at')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Дата и время акта...'],
        'removeButton' => false,
        'convertFormat' => true,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'php:d-m-Y H:i',
        ]
    ])?>
</div>
<div class="clearfix"></div>

<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'cartridges.model',
            'label' => 'Модель картриджа'],
        ['attribute' => 'cartridges.serial',
            'label' => 'Серийный номер'],
        ['attribute' => 'cartridges.inv_number',
            'label' => 'Инв №'],
        ['attribute' => 'cartridges.inv_service',
            'label' => 'Инв № сервиса'],
        [
            'label' => 'Акт передачи',
            'format' => 'raw',
            'value' => function($data){
                if(!is_null($data->serviceSend)) {
                    return "Акт № " . $data->serviceSend->send_act_id . " от " . date('d-m-Y', $data->serviceSend->create_at);
                }else {
                    return '<span class="not-set">Акт передачи не найден</span>';
                }
            }
        ],
        ['attribute' => 'works',
            'label' => 'Выполненые работы'],
        ['attribute' => 'weidth',
            'label' => 'Вес, грамм'],
        ['attribute' => 'komplekt',
            'label' => 'Комплектность'],

    ],
])?>
<div class="col-md-2">
    <?=Html::submitButton('Сохранить',['class' => 'btn btn-primary'])?>
    <?php ActiveForm::end(); ?>
</div>
<div class="col-md-2">
    <?=Html::a('Распечатать акт', ['/service/get-excel', 'act_id' => $serviceGet->get_act_id], ['class' => 'btn btn-primary'])?>
</div>
<div class="col-md-2">
<?=Html::a('Вернуться к списку актов', ['/service/get'], ['class' => 'btn btn-primary'])?>
</div>
<div class="clearfix"></div>
