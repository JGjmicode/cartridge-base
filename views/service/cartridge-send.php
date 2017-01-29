
<?php
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use app\models\Departaments;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;

$this->title = 'Новый акт';
?>

<?php
    //$CartridgeProvider->pagination->pageParam = 'cartridge-page';
    //$CartridgeProvider->sort->sortParam = 'cartridge-sort';
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
                'onclick' => "sendId($data->id, '', '', 'Картридж + чип')",
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
echo HTML::a('Продолжить', ['/service/new-send-act'], ['class' => 'btn btn-primary']);
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
<?= Html::jsFile('@web/js/service.js') ?>






