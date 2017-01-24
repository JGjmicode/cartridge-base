<?php
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Поставщики';
?>
<div>
    <h2 align="center">Поставщики</h2>
</div>

<?=Html::a('Добавить поставщика', ['/supplier/add'], ['class' => 'btn btn-primary'])?>

<?=GridView::widget([
    'filterModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        ['attribute' => 'title',
            'label' => 'Название'],
        ['attribute' => 'note',
            'label' => 'Примечание'],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
        ],

    ]
])?>
