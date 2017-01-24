<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h1>Картриджи</h1>

<table>
                <div class="header"><h1>Список картриджей</h1></div>
                <tr>
                    <th>Принтер</th>
                    <th>Номер картриджа</th>
                    <th>Цвет</th>
                    <th>Где находится</th>
                    <th>Неисправность</th>
                    <th>Примечание</th>
                    <th>Редактировать</th>
                    <th>Ремонты</th>
                </tr>
                
                <?php foreach ($cartridges as $cartridge): ?>
                    <tr>
                    <td><?= Html::encode("{$cartridge->printer}") ?></td>
                    <td><?= Html::encode("{$cartridge->number}") ?></td>
                    <td><?= Html::encode("{$cartridge->color}") ?></td>
                    <td><?= Html::encode("{$cartridge->place}") ?></td>
                    <td><?= Html::encode("{$cartridge->problem}") ?></td>
                    <td><?= Html::encode("{$cartridge->note}") ?></td>
                    <td>Редактировать</td>
                    <td>Ремонты</td>
                    </tr>
                <?php endforeach; ?>
                
</table>
<?= LinkPager::widget(['pagination' => $pagination]) ?>
