<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\i18n\Formatter;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use app\models\SendAct;
use app\models\ServiceSend;
$this->title = 'Список картриджей';
?>

    <h2 align="center">Список картриджей</h2>
<div class="col-md-2">
    <?=Html::a('Распечатать акт', ['/reports/report-to-excel'], ['class' => 'btn btn-primary'])?>
</div>
<div class="clearfix"></div>
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
            'label' => 'Инв №'],
        ['attribute' => 'inv_service',
            'label' => 'Инв № сервиса'],
        ['attribute' => 'printersTypes.types',
            'label' => 'Тип принтера'],
        [   'label' => 'Неисправность',
            'format' => 'raw',
            'value' => function($data){
                if($data->service) {
                    $sendAct = SendAct::find()->where(['cartridge_id' => $data->id])->orderBy(['id' => SORT_DESC])->limit(1)->one();
                    return $sendAct->problem;
                }else {
                    return '';
                }
            }
        ],
        [   'label' => 'Акт передачи',
            'format' => 'raw',
            'value' => function($data){
                if($data->service) {
                    $sendAct = SendAct::find()->where(['cartridge_id' => $data->id])->orderBy(['id' => SORT_DESC])->limit(1)->one();
                    $serviceSend = ServiceSend::find()->where(['send_act_id' => $sendAct->act_id])->one();
                    return "Акт № " . $serviceSend->send_act_id . " от " . date('d-m-Y', $serviceSend->create_at);
                }else {
                    return '';
                }
            }
        ],
        [
            'label' => 'Местонахождение',
            'attribute'=>'location',
            'filter'=>array(true=> "В сервисе",false=>"На складе"),
            'format' => 'raw',
            'value' => function($data){
                if($data->service){
                    return Html::img('/../image/repair.png',[
                        'style' => 'width:50px;',
                    ]);
                }else{
                    return Html::img('/../image/storage.png',[
                        'style' => 'width:50px;'
                    ]);
                }
            },
        ],



    ],
]);




