<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\nav\NavX;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Отдел компьютерных систем и информационных технологий',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [],
    ];
    if(!Yii::$app->user->isGuest) {
        $menuItems['items'][] = ['label' => 'Главная', 'url' => ['/site/index']];
        $menuItems['items'][] = ['label' => 'Ремонты', 'items' => [
            ['label' => 'Ремонт картриджей', 'items' => [
                ['label' => 'Передача в сервис', 'url' => ['/service/send']],
                ['label' => 'Возврат из сервиса', 'url' => ['/service/get']],
            ]],
            ['label' => 'Ремонт техники', 'items' => [
                    ['label' => 'Неисправности', 'url' => ['/repairs/index']],
            ]]
            ]];
        $menuItems['items'][] = ['label' => 'Справочники', 'items' => [
            ['label' => 'Картриджи', 'url' => ['/cartridges/index']],
            ['label' => 'Типы принтеров', 'url' => ['/printers-types/index']],
            ['label' => 'Отделы', 'url' => ['/departaments/index']],
            ['label' => 'Заказчики', 'url' => ['/customer/index']],
            ['label' => 'Исполнители', 'url' => ['/contractor/index']],
            ['label' => 'Поставщики', 'url' => ['/supplier/index']],
        ]];
        $menuItems['items'][] = ['label' => 'Отчеты', 'items' => [
            ['label' => 'Отчет по ремонту', 'url' => ['/reports/departament-report']],
            ['label' => 'Отчет по картриджу', 'url' => ['/reports/cartridge-report']],
            ['label' => 'Отчет по местонахождению', 'url' => ['/reports/location-report']],

        ]];
        $menuItems['items'][] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }else{
        $menuItems['items'][] = ['label' => 'Войти', 'url' => ['/site/login']];
    }

    //echo Nav::widget($menuItems);
    echo NavX::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems['items'],
        'activateParents' => true,
        'encodeLabels' => false
    ]);


    NavBar::end();
    ?>



    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Отдел компьютерных систем и информационных технологий <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
