<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use app\models\PrintersTypes;

$this->title = 'Добавление/редактирование отдела';
?>
<div>
    <h2 align="center">Добавление/редактирование отдела</h2>
</div>

<?php
    $form = ActiveForm::begin();
?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'cabinet') ?>
<?php
$print_types = empty($model->printer_types_id) ? 'Выберите тип принтера' : is_null(PrintersTypes::findOne($model->printer_types_id)) ? 'Тип не выбран' : PrintersTypes::findOne($model->printer_types_id)->types;
$get_types = Url::to(['/printers-types/get-types']);
echo $form->field($model, 'printer_types_id')->label('Тип принтера:&nbsp')->widget(Select2::classname(), [
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
        //'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        //'templateResult' => new JsExpression('function(city) { return city.text; }'),
        //'templateSelection' => new JsExpression('function (city) { return city.text; }'),
    ],
]);
?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary'])?>

<?php ActiveForm::end(); ?>
