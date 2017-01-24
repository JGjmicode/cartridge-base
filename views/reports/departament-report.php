<?php
use yii\grid\GridView;
use app\models\Departaments;
use app\models\GetAct;
use app\models\ServiceGet;
?>

<?= $this->render('_departament-search', ['model' => $searchModel]) ?>

<div>
    <h3 align="center">Отчет <?=empty($searchModel->departament_id)? 'по всем отделам' : 'по '.Departaments::findOne($searchModel->departament_id)->name?><?=empty($searchModel->date_from)? '' : ' c '.$searchModel->date_from?><?=empty($searchModel->date_to) ? '' : ' по '.$searchModel->date_to?></h3>
</div>
<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'cartridges.model',
            'label' => 'Модель картриджа'],
        ['attribute' => 'cartridges.inv_number',
            'label' => 'Инвентарный номер'],
        ['attribute' => 'cartridges.resource',
            'label' => 'Ресурс картриджа'],
        ['attribute' => 'problem',
            'label' => 'Неисправность'],


        [
            'label' => 'Акт передачи в сервис',
            'format' => 'raw',
            'value' => function($data){
                return "Акт № ".$data->serviceSend->send_act_id. " от ".date('d-m-Y' , $data->serviceSend->create_at);
            }
        ],
        [
            'label' => 'Выполненые работы',
            'format' => 'raw',
            'value' => function($data){

                $getAct = GetAct::find()->where(['send_act_id' => $data->serviceSend->send_act_id])->andWhere(['cartridge_id' => $data->cartridge_id])->one();
                if(is_null($getAct)){
                    return '<span class="not-set">Картридж еще в сервисе</span>';
                }
                return $getAct->works;
            }
        ],
        [
            'label' => 'Акт возврата из сервиса',
            'format' => 'raw',
            'value' => function($data){

                $getAct = GetAct::find()->where(['send_act_id' => $data->serviceSend->send_act_id])->andWhere(['cartridge_id' => $data->cartridge_id])->one();
                if(is_null($getAct)){
                    return '<span class="not-set">Картридж еще в сервисе</span>';
                }else{
                    $serviceGet = ServiceGet::find()->where(['get_act_id' => $getAct->act_id])->one();
                    return "Акт № ".$serviceGet->get_act_id. " от ".date('d-m-Y' , $serviceGet->create_at);
                }

            }
        ],
        [
            'label' => 'Отдел',
            'format' => 'raw',
            'value' => function($data){

                return Departaments::findOne($data->departament_id)->name;
            }
        ],



    ],
])?>
<?php

$cartridges = $dataProvider->getModels();
$total = 0;
foreach ($cartridges as $cartridge) {
    $total = $total + $cartridge->cartridges->resource;

}

?>
<div>
    <h4 align="right">Всего страниц напечатано: <?=$total?></h4>
</div>

