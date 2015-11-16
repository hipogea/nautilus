<?php
class TestController extends Controller{
 
     // no layouts here
     public $layout = '';
 
     public function actionTest()
     {
     //
     // get a reference to the path of PHPExcel classes 
     $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
 
     // Turn off our amazing library autoload 
      spl_autoload_unregister(array('YiiBase','autoload'));        
 
     //
     // making use of our reference, include the main class
     // when we do this, phpExcel has its own autoload registration
     // procedure (PHPExcel_Autoloader::Register();)
    include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
 
     // Create new PHPExcel object
     $objPHPExcel = new PHPExcel();
 
     // Set properties
     $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
    ->setLastModifiedBy("Maarten Balliauw")
    ->setTitle("PDF Test Document")
    ->setSubject("PDF Test Document")
    ->setDescription("Test document for PDF, generated using PHP classes.")
    ->setKeywords("pdf php")
    ->setCategory("Test result file");
 
 
     // Add some data
     $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');
 
      // Miscellaneous glyphs, UTF-8
     $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'יאטשגךמפûכןüÿהצüח');
 
      // Rename sheet
      $objPHPExcel->getActiveSheet()->setTitle('Simple');
 
      // Set active sheet index to the first sheet, 
      // so Excel opens this as the first sheet
     $objPHPExcel->setActiveSheetIndex(0);
 
      // Redirect output to a client’s web browser (Excel2007)
      header('Content-Type: application/pdf');
      header('Content-Disposition: attachment;filename="01simple.pdf"');
      header('Cache-Control: max-age=0');
 
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
      $objWriter->save('php://output');
      Yii::app()->end();
 
       // 
       // Once we have finished using the library, give back the 
       // power to Yii... 
       spl_autoload_register(array('YiiBase','autoload'));
       }
}
?>