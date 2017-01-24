<?php
use yii\grid\GridView;
use app\models\Departaments;
use app\models\GetAct;
use app\models\ServiceGet;
$this->title = 'Отчет по ремонту';
?>

<?php
    if(!is_null($cartridge)) {
        ?>
        <div>
            <h3 align="center">Отчет по картриджу <?= $cartridge->model ?>, инвентарный номер
                №<?= $cartridge->inv_number ?></h3>
        </div>
        <?php
    }
?>
<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
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



    ],
])?>


