<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\i18n\Formatter;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

$this->title = 'Список картриджей';
?>

<h2 align="center">Список картриджей</h2>
<?php
echo Html::a('Добавить новый картридж', ['cartridges/add'], ['class' => 'btn btn-primary']);  

echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'model',
            'label' => 'Модель картриджа'],
            ['attribute' => 'serial',
            'label' => 'Серийный номер'],
            ['attribute' => 'inv_number',
                'label' => 'Инв №',
                //'contentOptions' => ['class' => 'note', 'style'=>'width:20px;'],
            ],
            ['attribute' => 'inv_service',
                'label' => 'Инв № сервиса',
            ],
            ['attribute' => 'printersTypes.types',
            'label' => 'Тип принтера'],
            ['attribute' => 'supplier.title',
                'label' => 'Поставщик'],
            ['attribute' => 'note',
            'label' => 'Примечание',],
            [
            'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
            [
            'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],

   
        ],
    ]);



