<?php

require(dirname(__FILE__) . '/PHPExcel_Library.php');

class PHPExcel extends PHPExcelBase {

    private $_type = null;
    private $_url = null;
    private $_types = [ 'xlsx' => 'Excel2007', 'xls' => 'Excel5' ];
    
    private $_path = null;
    private $_filename = null;
    private $_extension = null;
    
    private $_cells = [ 'A', 'B', 'C', 'D', 'E', 'F' ,'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N' ,'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' ];
    
    public function setPropertie($properties = array()){
        if (!empty($properties)) {
            foreach ($properties as $propertie => $value) {
                exec('$this->' . ucfirst($propertie) . '(' . $value . ')');
            }
        }
    }
    public function setCells($cells = array()){
        if (!empty($cells)) {
            foreach ($cells as $sheet => $cell) {
                if(!empty($cell['items'])){
                    if ($sheet > 0){
                        $this->createSheet();
                    }
                    $sheet = $this->setActiveSheetIndex($sheet);
                    if(!empty($cell['header'])){
                        foreach ($cell['header'] as $col => $header) {
                            $sheet->setCellValue($this->getColumn($col) . '1', $header);
                        }
                    }
                    foreach ($cell['items'] as $row => $items) {
                        foreach ($items as $col => $text) {
                            $record = (($row + 1) + 1);
                            $sheet->setCellValue($this->getColumn($col).$record, $text);
                        }
                    }
                    $this->getActiveSheet()->setTitle(!empty($cell['title']) ? $cell['title'] : "Sheet");
                }
            }
        }
        
    }
    
    public function Output($obj = array(), $file = null, $format = 'S'){
        $newGetFile = $this->getFile($file);
        if (!empty($newGetFile)) {
            $writer = PHPExcel_IOFactory::createWriter($obj, $this->_type); // Excel2007 (xlsx), Excel5 (xls)
            if ($format == 'S') {
                $writer->save($this->_path);
                if ($this->_extension == 'xlsx') {
                    header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8");
                } else {
                    header("Content-type: application/vnd.ms-excel; charset=utf-8");
                }
                header("Content-Disposition: attachment; filename=" . $this->_filename . "." . $this->_extension);
                readfile($this->_path);
            } else if ($format == 'D') {
                if ($this->_extension == 'xlsx') {
                    header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8");
                } else {
                    header("Content-type: application/vnd.ms-excel; charset=utf-8");
                }
                header("Content-Disposition: attachment; filename=" . $this->_filename . "." . $this->_extension);
                $writer->save('php://output');
            } else if ($format == 'L') {
                $writer->save($this->_path);
                return '<p>Download Files: <a href="' . $this->_url . '" target="_blank">' . $this->_url . '</a></p>';
            }
        }
    }
   
    private function getColumn($col){
        $level = 0; // A
        if ( $col <= 25 ) {
            return $this->_cells[$col];
        }
        if ( $col > 25 && $col <= 50) {
            $col = $col - 26;
            return $this->_cells[$level] . $this->_cells[$col];
        }
    }
    
    private function getFile($file = nul){
        $rootDir = Yii::getAlias('@webroot') . '/';
        $files = explode('/', $file);
        $current = (count($files)-1);
        if (!empty($files[$current])) {
            list($this->_filename, $this->_extension) = explode('.', $files[$current]);
            $this->_type = $this->_types[$this->_extension];
            $this->_path = $rootDir . $file;
            $this->_url = Yii::$app->urlManager->createAbsoluteUrl('/') . $file;
            return true;
        }
        return false;
    }
    
}