<?php
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
$this->title = 'Акты приема/передачи оборудования из ремонта';
?>

<?= Html::a('Новый Акт', ['/service/new-get'], ['class' => 'btn btn-primary'])?>

<div>
    <h2 align="center">Акты приема/передачи оборудования из ремонта</h2>
</div>

<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['attribute' => 'get_act_id',
            'label' => 'Номер акта'],
        [
            'filter' => DatePicker::widget([
                'language' => 'ru',
                'model' => $searchModel,
                'attribute' => 'date_from',
                'attribute2' => 'date_to',
                'type' => DatePicker::TYPE_RANGE,
                'separator' => '-',
                'pluginOptions' => ['format' => 'dd.mm.yyyy']
            ]),
            'attribute' => 'create_at',
            'format' =>  ['date', 'dd.MM.Y'],
            'label' => 'Дата акта'],
        [
            'label' => 'Количество картриджей',
            'format' => 'raw',
            'value' => function($data){

                return count($data->getAct);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url,$model) {
                 return Html::a(
                        '<span class="glyphicon glyphicon-eye-open"></span>',
                        ['/service/view-get-act', 'act_id' => $model->get_act_id]);
                },
            ],
        ],
    ],
])?>