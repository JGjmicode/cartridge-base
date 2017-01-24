<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
$this->title = 'Акты приема/передачи оборудования в ремонт'
?>

<?=Html::a('Новый акт', ['service/new-send'], ['class' => 'btn btn-primary'])?>

<div>
    <h2 align="center">Акты приема/передачи оборудования в ремонт</h2>
</div>

<?=GridView::widget([
    'dataProvider' => $ServiceSendProvider,
    'filterModel' => $ServiceSendSearchModel,
    'columns' => [
        ['attribute' => 'send_act_id',
        'label' => 'Номер акта'],

        [
            'filter' => DatePicker::widget([
                'language' => 'ru',
                'model' => $ServiceSendSearchModel,
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

                return count($data->sendAct);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url,$model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-eye-open"></span>',
                    ['/service/view-send-act', 'act_id' => $model->send_act_id]);
                },
            ],
        ],
    ],
])?>
