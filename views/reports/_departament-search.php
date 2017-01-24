<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\models\Departaments;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;

$this->title = 'Отчет по ремонту';


?>
<div>
    <h2 align="center">Отчет по ремонту</h2>
</div>
<div class="post-search">
    <?php $form = ActiveForm::begin([
        'action' => ['departament-report'],
        'method' => 'get',
    ]); ?>
    <div class="col-md-3">
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
    </div>
    <div class="col-md-3">
        <label class="control-label">Выбор даты</label>
        <?=DatePicker::widget([
        'language' => 'ru',
        'model' => $model,
        //'placeholder' => 'Выбор даты',
        'attribute' => 'date_from',
        'attribute2' => 'date_to',
        'type' => DatePicker::TYPE_RANGE,
        'separator' => '-',
        'pluginOptions' => [
            'format' => 'dd.mm.yyyy',
            'autoclose'=>true,
        ]
        ])?>
    </div>
    <div class="clearfix"></div>

    <div class="form-group">
        <?= Html::submitButton('Сформировать отчет', ['class' => 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>
</div>