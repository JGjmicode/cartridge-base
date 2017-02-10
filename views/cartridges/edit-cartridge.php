<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use app\models\PrintersTypes;
use yii\widgets\DetailView;
use app\models\Supplier;


$this->title = 'Добавление/изменение картриджа';
?>
<h2 align="center">Добавление/изменение картриджа</h2>


<?php $form = ActiveForm::begin(
//        [
//            'fieldConfig' => [
//                'template' => '<div class="clearfix"><div class="label-left">{label}</div><div class="input-left">{input}</div></div>',
//                'labelOptions' => [],
//            ],
//        ]
        ); 
?>

<div class="col-md-3">
        <?= $form->field($model, 'model') ?>
</div>
<div class="col-md-3">
        <?= $form->field($model, 'serial') ?>
</div>
<div class="col-md-2">
        <?= $form->field($model, 'inv_number') ?>
</div>
<div class="col-md-2"style="top:25px;">
        <?= Html::Button('Новый номер', ['class' => 'btn btn-warning', 'onclick' => 'getMaxInvNumber()'])?>
</div>
<div class="clearfix"></div>

<div class="col-md-3">
<?php
        $print_types = empty($model->printer_id) ? 'Выберите тип принтера' : is_null(PrintersTypes::findOne($model->printer_id)) ? 'Тип не выбран' : PrintersTypes::findOne($model->printer_id)->types;
        $get_types = Url::to(['/printers-types/get-types']);
        echo $form->field($model, 'printer_id')->label('Тип принтера:&nbsp')->widget(Select2::classname(), [
        'initValueText' => $print_types, // set the initial display text
        'options' => ['placeholder' => 'Выберите тип принтера ...'],
        'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 1,
        'language' => [
            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
            'url' => $get_types,
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
        ],
        ]);
?>
</div>
<div class="col-md-3">
<?=$form->field($model, 'supplier_id')->dropdownList(
Supplier::find()->select(['title', 'id'])->indexBy('id')->column(),
['prompt'=>'Выберите поставщика'])?>
</div>
<div class="col-md-3">
<?= $form->field($model, 'resource') ?>
</div>
<div class="clearfix"></div>
<div class="col-md-9">
<?= $form->field($model, 'note') ?>
</div>
<div class="clearfix"></div>

<div class="text-center">
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary'])?>
</div>
<?php ActiveForm::end(); ?>

<script>
        function getMaxInvNumber(){
                var invNumber = "<?=$invNumber?>";
                $("#cartridges-inv_number").val(invNumber);
        }
</script>



