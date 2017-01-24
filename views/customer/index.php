<?php
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Заказчики';
?>

<h2 align="center">Заказчики</h2>

<?=\yii\helpers\Html::a('Добавить заказчика', ['/customer/add'], ['class' => 'btn btn-primary'])?>

<?=GridView::widget([
    'filterModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        ['attribute' => 'name',
        'label' => 'Ф.И.О.'],
        ['attribute' => 'nameRP',
        'label' => 'Ф.И.О. в род.падеже'],
        ['attribute' => 'position',
         'label' => 'Должность'],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
        ],

    ]
])?>
