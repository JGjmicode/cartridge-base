<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\i18n\Formatter;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

$this->title = 'Выбор картриджа';
?>

    <h2 align="center">Выбор картриджа для отчета</h2>
<?php

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['attribute' => 'model',
            'label' => 'Модель картриджа'],
        ['attribute' => 'serial',
            'label' => 'Серийный номер'],
        ['attribute' => 'inv_number',
            'label' => 'Инвентарный номер'],
        ['attribute' => 'printersTypes.types',
            'label' => 'Тип принтера'],
        ['attribute' => 'supplier.title',
            'label' => 'Поставщик'],
        ['attribute' => 'note',
            'label' => 'Примечание'],
        [
            'label' => 'Выбрать',
            'format' => 'raw',
            'value' => function($data){
                return Html::a(
                    'Выбрать',[
                    '/reports/cartridge-report',
                    'id' => $data->id],
                    ['class' => 'btn btn-primary']
                );
            }
        ],



    ],
]);