<?php
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Исполнители';
?>

<h2 align="center">Исполнители</h2>

<?=Html::a('Добавить исполнителя', ['/contractor/add'], ['class' => 'btn btn-primary'])?>

<?=GridView::widget([
    'filterModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        ['attribute' => 'title',
            'label' => 'Организация'],
        ['attribute' => 'person',
            'label' => 'Представитель'],
        ['attribute' => 'e_mail',
            'label' => 'E-Mail'],
        ['attribute' => 'phone',
            'label' => 'Номер телефона'],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
        ],

    ]
])?>
