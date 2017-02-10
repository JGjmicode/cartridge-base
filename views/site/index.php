<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Учет картриджей';
?>
<div class="site-index">
    <div class="col-md-4">
        <h2>Акты</h2>
        <div class="col-md-3">
            <?=Html::a(Html::img('/../image/clipboard.png', ['width' => '75px']),['/service/send'])?>
        </div>
        <div class="col-md-9">
            <h4><?=Html::a('Акты передачи в сервис',['/service/send'])?></h4>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-3">
            <?=Html::a(Html::img('/../image/clipboard.png', ['width' => '75px']),['/service/get'])?>
        </div>
        <div class="col-md-9">
            <h4><?=Html::a('Акты возврата из сервиса',['/service/get'])?></h4>
        </div>
        <div class="clearfix"></div>
        <h2>Ремонты</h2>
        <div class="col-md-3">
            <?=Html::a(Html::img('/../image/repair.png', ['width' => '75px']),['/repairs/index'])?>
        </div>
        <div class="col-md-9">
            <h4><?=Html::a('Список техники в ремонт',['/repairs/index'])?></h4>
        </div>
    </div>
    <div class="col-md-4">
        <h2>Справочники</h2>
        <div class="col-md-4">
            <?=Html::a(Html::img('/../image/cartridges.png', ['width' => '75px']),['/cartridges/index'])?>
        </div>
        <div class="col-md-8">
            <h4><?=Html::a('Картриджи',['/cartridges/index'])?></h4>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4">
            <?=Html::a(Html::img('/../image/printertypes.png', ['width' => '75px']),['/printers-types/index'])?>
        </div>
        <div class="col-md-8">
            <h4><?=Html::a('Типы принтеров',['/printers-types/index'])?></h4>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4">
            <?=Html::a(Html::img('/../image/customer.png', ['width' => '75px']),['/customer/index'])?>
        </div>
        <div class="col-md-8">
            <h4><?=Html::a('Заказчики',['/customer/index'])?></h4>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4">
            <?=Html::a(Html::img('/../image/contractor.png', ['width' => '75px']),['/contractor/index'])?>
        </div>
        <div class="col-md-8">
            <h4><?=Html::a('Исполнители',['/contractor/index'])?></h4>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4">
            <?=Html::a(Html::img('/../image/supplier.png', ['width' => '75px']),['/supplier/index'])?>
        </div>
        <div class="col-md-8">
            <h4><?=Html::a('Поставщики',['/supplier/index'])?></h4>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4">
            <?=Html::a(Html::img('/../image/departament.png', ['width' => '75px']),['/departaments/index'])?>
        </div>
        <div class="col-md-8">
            <h4><?=Html::a('Отделы',['/departaments/index'])?></h4>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="col-md-4">
        <h2>Отчеты</h2>
        <div class="col-md-4">
            <?=Html::a(Html::img('/../image/repair.png', ['width' => '75px']),['/reports/departament-report'])?>
        </div>
        <div class="col-md-8">
            <h4><?=Html::a('Отчет по ремонту',['/reports/departament-report'])?></h4>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4">
            <?=Html::a(Html::img('/../image/cartridges.png', ['width' => '75px']),['/reports/cartridge-report'])?>
        </div>
        <div class="col-md-8">
            <h4><?=Html::a('Отчет по картриджу',['/reports/cartridge-report'])?></h4>
        </div>
        <div class="clearfix"></div>

        <div class="col-md-4">
            <?=Html::a(Html::img('/../image/location.png', ['width' => '75px']),['/reports/location-report'])?>
        </div>
        <div class="col-md-8">
            <h4><?=Html::a('Отчет по местонахождению',['/reports/location-report'])?></h4>
        </div>
        <div class="clearfix"></div>

    </div>
</div>
