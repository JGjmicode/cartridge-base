<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Список неисправностей печатающей техники';
?>
<h2 align="center">Список неисправностей печатающей техники</h2>
<?=Html::a('Добавить запись', ['repairs/add'], ['class' => 'btn btn-primary'])?>
<?=Html::a('Сохранить отчет', ['repairs/save-repairs'], ['class' => 'btn btn-warning'])?>

<?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'model'],
            ['attribute' => 'invNumber'],
            ['attribute' => 'cabinet'],
            ['attribute' => 'problem'],
            ['attribute' => 'note'],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ]
    ]);
?>


