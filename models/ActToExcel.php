<?php
namespace app\models;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;
use PHPExcel_Writer_Excel5;
use yii\base\Model;
use yii\db\ActiveRecord;
use app\models\SendAct;
use app\models\GetAct;
use app\models\ServiceSend;
use app\models\ServiceGet;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use yii\i18n\Formatter;
use app\models\Cartridges;

class ActToExcel extends Model{

    public static function saveSendActToExcel($act_id){
        $formatter = new Formatter();
        $filepath = 'export/send-act.xls';

        $inputFileType = PHPExcel_IOFactory::identify($filepath);  // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
        $objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
        $objPHPExcel = $objReader->load($filepath); // загружаем данные файла в объект
        $sheet = $objPHPExcel->getActiveSheet();

        $act = ServiceSend::find()->where(['send_act_id' => $act_id])->joinWith('customer')->joinWith('contractor')->one();

        $sheet->setCellValue('A1', 'АКТ № '.$act->send_act_id. ' ОТ '. date('d.m.Y', $act->create_at));
        $sheet->setCellValue('A4', 'Мы, нижеподписавшиеся, представитель Заказчика Министерство экономического развития Республики Крым в лице '.$act->customer->nameRP.' с одной стороны и представитель Исполнителя – '.$act->contractor->person.' с другой стороны, составили настоящий акт о том, что Заказчиком было передано Исполнителю для выполнения ремонта/заправки следующее оборудование/комплектующие:');
        $sheet->getStyle('A4')->applyFromArray(['alignment' => ['wrap' => true, 'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,]]);

        $sendActs = SendAct::find()->where(['act_id' => $act_id])->joinWith('cartridges')->all();
        $number = 1;
        $line = 11;
        foreach ($sendActs as $sendAct) {
            $sheet->setCellValue('A'.$line, $number);
            $sheet->setCellValue('B'.$line, $sendAct->cartridges->model);
            $sheet->setCellValue('C'.$line, $sendAct->cartridges->serial);
            $sheet->setCellValue('D'.$line, $sendAct->cartridges->inv_number);
            $sheet->setCellValue('E'.$line, $sendAct->problem);
            $sheet->getStyle('E'.$line)->applyFromArray(['alignment' => ['wrap' => true, 'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,]]);
            $sheet->setCellValue('F'.$line, $sendAct->cartridges->inv_service);
            $sheet->setCellValue('G'.$line, $sendAct->komplekt);
            $sheet->getRowDimension($line)->setRowHeight(-1);
            $line++;
            $number++;
        }

        $sheet->getStyle('A11:G'.($line-1))->getAlignment()->setHorizontal(
            PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $style_wrap = array(
            //рамки
            'borders'=>array(
                //внешняя рамка
                'outline' => array(
                    'style'=>PHPExcel_Style_Border::BORDER_THIN
                ),
                //внутренняя
                'allborders'=>array(
                    'style'=>PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'rgb'=>'696969'
                    )
                )
            )
        );
//применяем массив стилей к ячейкам
        $sheet->getStyle('A11:G'.($line-1))->applyFromArray($style_wrap);
        $sheet->getStyle('A1')->applyFromArray(['font' => ['bold' => true]]);

        $line++;
        $sheet->mergeCells('A'.$line.':G'.($line+1));
        $sheet->setCellValue('A'.$line, 'Заявка на ремонт/заправку картриджей была направлена по электронной почте на адрес: '.$act->contractor->e_mail.' и продублирована по телефону: '.$act->contractor->phone.' в '.date('H:i', $act->create_at).' '.date('d.m.Y', $act->create_at));
        $sheet->getStyle('A'.$line)->applyFromArray(['alignment' => ['wrap' => true, 'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,]]);

        $line++;
        $line++;

        $sheet->setCellValue('A'.$line, 'Передача оборудования/комплектующих в ремонт состоялась:');

        $line++;
        $line++;
        $sheet->setCellValue('A'.$line, 'Дата: ______________________');
        $sheet->setCellValue('E'.$line, 'Время передачи: ____________');

        $line++;
        $line++;
        $sheet->setCellValue('A'.$line, 'От Заказчика:');
        $sheet->setCellValue('E'.$line, 'От Исполнителя: ');

        $line++;
        $line++;
        $line++;
        $sheet->setCellValue('A'.$line, '___________________');
        $sheet->setCellValue('E'.$line, '___________________');

        $actDate = date('d.m.Y', $act->create_at);
        $outputFileName = "Send_act_№". $act->send_act_id. "_from_" .$actDate;
        header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
        header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
        header ( "Cache-Control: no-cache, must-revalidate" );
        header ( "Pragma: no-cache" );
        header ( "Content-type: application/vnd.ms-excel" );
        header ( "Content-Disposition: attachment; filename=$outputFileName" );
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save('php://output');
    }


    public static function saveGetActToExcel($act_id){
        $filepath = 'export/get-act.xls';

        $inputFileType = PHPExcel_IOFactory::identify($filepath);  // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
        $objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
        $objPHPExcel = $objReader->load($filepath); // загружаем данные файла в объект
        $sheet = $objPHPExcel->getActiveSheet();

        $act = ServiceGet::find()->where(['get_act_id' => $act_id])->joinWith('customer')->joinWith('contractor')->one();

        $sheet->setCellValue('A1', 'АКТ № '.$act->get_act_id. ' ОТ '. date('d.m.Y', $act->create_at));
        $sheet->setCellValue('A4', 'Мы, нижеподписавшиеся, представитель Заказчика Министерство экономического развития Республики Крым в лице '.$act->customer->nameRP.' с одной стороны и представитель Исполнителя – '.$act->contractor->person.' с другой стороны, составили настоящий акт о том, что Исполнителем было передано Заказчику после выполнения ремонта/заправки следующее оборудование/комплектующие:');
        $sheet->getStyle('A4')->applyFromArray(['alignment' => ['wrap' => true, 'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,]]);

        $getActs = GetAct::find()->where(['act_id' => $act_id])->joinWith('cartridges')->joinWith('serviceSend')->all();
        $number = 1;
        $line = 11;
        foreach ($getActs as $getAct) {
            $sendAct = "Акт № ".$getAct->serviceSend->send_act_id. " от ".date('d.m.Y' , $getAct->serviceSend->create_at);
            $sheet->setCellValue('A'.$line, $number);
            $sheet->setCellValue('B'.$line, $getAct->cartridges->model);
            $sheet->setCellValue('C'.$line, $getAct->cartridges->serial);
            $sheet->setCellValue('D'.$line, $getAct->cartridges->inv_number);
            $sheet->setCellValue('E'.$line, $sendAct);
            $sheet->getStyle('E'.$line)->applyFromArray(['alignment' => ['wrap' => true, 'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,]]);
            $sheet->setCellValue('F'.$line, $getAct->cartridges->inv_service);
            $sheet->setCellValue('G'.$line, $getAct->komplekt);
            $sheet->setCellValue('H'.$line, $getAct->works);
            $sheet->getStyle('H'.$line)->applyFromArray(['alignment' => ['wrap' => true, 'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,]]);
            $sheet->getRowDimension($line)->setRowHeight(-1);
            $line++;
            $number++;
        }

        $sheet->getStyle('A11:H'.($line-1))->getAlignment()->setHorizontal(
            PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);;
        $style_wrap = array(
            //рамки
            'borders'=>array(
                //внешняя рамка
                'outline' => array(
                    'style'=>PHPExcel_Style_Border::BORDER_THIN
                ),
                //внутренняя
                'allborders'=>array(
                    'style'=>PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'rgb'=>'696969'
                    )
                )
            )
        );
//применяем массив стилей к ячейкам
        $sheet->getStyle('A11:H'.($line-1))->applyFromArray($style_wrap);
        $sheet->getStyle('A1')->applyFromArray(['font' => ['bold' => true]]);

        $line++;
        //$sheet->mergeCells('A'.$line.':H'.($line+1));
        $sheet->setCellValue('A'.$line, 'Передача оборудования/комплектующих из ремонта состоялась:');
        //$sheet->getStyle('A'.$line)->applyFromArray(['alignment' => ['wrap' => true, 'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,]]);


        $line++;
        $line++;
        $sheet->setCellValue('A'.$line, 'Дата: ______________________');
        $sheet->setCellValue('E'.$line, 'Время передачи: ____________');

        $line++;
        $line++;
        $sheet->setCellValue('A'.$line, 'От Заказчика:');
        $sheet->setCellValue('E'.$line, 'От Исполнителя: ');

        $line++;
        $line++;
        $line++;
        $sheet->setCellValue('A'.$line, '___________________');
        $sheet->setCellValue('E'.$line, '___________________');

        $actDate = date('d.m.Y', $act->create_at);
        $outputFileName = "Get_act_№". $act->get_act_id. "_from_" .$actDate;
        header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
        header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
        header ( "Cache-Control: no-cache, must-revalidate" );
        header ( "Pragma: no-cache" );
        header ( "Content-type: application/vnd.ms-excel" );
        header ( "Content-Disposition: attachment; filename=$outputFileName" );
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save('php://output');
    }

    public static function saveReportPlace(){
        $filepath = 'export/location-report-export.xls';

        $inputFileType = PHPExcel_IOFactory::identify($filepath);  // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
        $objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
        $objPHPExcel = $objReader->load($filepath); // загружаем данные файла в объект
        $sheet = $objPHPExcel->getActiveSheet();

        $cartridges = Cartridges::find()->where(['service' => true])->orderBy(['inv_number' => SORT_ASC])->all();
        $sheet->getStyle('A4:F4')->applyFromArray(['font' => ['bold' => true]]);
        $index = 6;
        foreach ($cartridges as $cartridge) {
            $sendAct = SendAct::find()->where(['cartridge_id' => $cartridge->id])->orderBy(['id' => SORT_DESC])->limit(1)->one();
            $serviceSend = ServiceSend::find()->where(['send_act_id' => $sendAct->act_id])->one();
            $act =  "Акт № " . $serviceSend->send_act_id . " от " . date('d-m-Y', $serviceSend->create_at);
            $sheet->setCellValue('A'.$index, $cartridge->model);
            $sheet->setCellValue('B'.$index, $cartridge->serial);
            $sheet->setCellValue('C'.$index, $cartridge->inv_number);
            $sheet->setCellValue('D'.$index, $cartridge->inv_service);
            $sheet->setCellValue('E'.$index, $sendAct->problem);
            $sheet->setCellValue('F'.$index, $act);
            $sheet->getStyle('A'.$index.':F'.$index)->applyFromArray(['alignment' => ['wrap' => true, 'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,]]);
            $sheet->getRowDimension($index)->setRowHeight(-1);
            $index++;
        }

        $sheet->getStyle('A6:F'.($index-1))->getAlignment()->setHorizontal(
            PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);;
        $style_wrap = array(
            //рамки
            'borders'=>array(
                //внешняя рамка
                'outline' => array(
                    'style'=>PHPExcel_Style_Border::BORDER_THIN
                ),
                //внутренняя
                'allborders'=>array(
                    'style'=>PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'rgb'=>'696969'
                    )
                )
            )
        );
//применяем массив стилей к ячейкам
        $sheet->getStyle('A6:F'.($index-1))->applyFromArray($style_wrap);


        $outputFileName = "Location-report";
        header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
        header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
        header ( "Cache-Control: no-cache, must-revalidate" );
        header ( "Pragma: no-cache" );
        header ( "Content-type: application/vnd.ms-excel" );
        header ( "Content-Disposition: attachment; filename=$outputFileName" );
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save('php://output');
    }

}
