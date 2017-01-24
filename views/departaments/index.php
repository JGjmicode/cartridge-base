<?php
use yii\grid\GridView;

$this->title = 'Список отделов';
?>
<div>
    <h2 align="center">Список отделов</h2>
</div>
<?=\yii\helpers\Html::a('Добавить отдел',['/departaments/add'],['class' => 'btn btn-primary'])?>
<div>
<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['attribute' => 'name',
        'label' => 'Название отдела'],
        ['attribute' => 'cabinet',
        'label' => '№ кабинета'],
        ['attribute' => 'printersTypes.types',
        'label' => 'Тип принтера'],
        [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{update}',
        ],
        [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{delete}',
        ],

    ],
])
?>
</div>
