<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\i18n\Formatter;
use yii\grid\GridView;
use yii\widgets\Pjax;


$this->title = 'Типы принтеров';
?>
<div>
    <h2 align="center">Типы принтеров</h2>
</div>

<?php
echo Html::a('Добавить новый тип', ['printers-types/add'], ['class' => 'btn btn-primary']);  

echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'types',
            'label' => 'Типы принтеров'],
            ['attribute' => 'total',
            'label' => 'Количество картриджей'],
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

