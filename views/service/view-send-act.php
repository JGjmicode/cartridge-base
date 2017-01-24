<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Customer;
use app\models\Contractor;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
$this->title = 'Акт передачи/приема  оборудования в ремонт № '.$serviceSend->send_act_id.' от '.date("d-m-Y", $serviceSend->create_at);
?>

<?=Html::a('Новый акт', ['service/new-send'], ['class' => 'btn btn-primary'])?>

<div>
    <h1>Акт передачи/приема  оборудования в ремонт № <?=$serviceSend->send_act_id?> от <?=date("d-m-Y", $serviceSend->create_at)?></h1>
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
    'dataProvider' => $SendActProvider,
    'filterModel' => $SendActSearchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'cartridges.model',
            'label' => 'Модель картриджа'],
        ['attribute' => 'cartridges.serial',
            'label' => 'Серийный номер'],
        ['attribute' => 'cartridges.inv_number',
            'label' => 'Инвентарный номер'],
        ['attribute' => 'problem',
            'label' => 'Неисправность'],
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
    <?=Html::a('Распечатать акт', ['/service/send-excel', 'act_id' => $serviceSend->send_act_id], ['class' => 'btn btn-primary'])?>
</div>
<div class="col-md-2">
    <?=Html::a('Вернуться к списку актов', ['/service/send'], ['class' => 'btn btn-primary'])?>
</div>
<div class="clearfix"></div>