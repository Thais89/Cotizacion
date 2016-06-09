<?php

// Create new PHPExcel object
$objPHPExcel = new \PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Prueba Cotizacion")
							 ->setTitle("Cotizacion ". $model->nombre)
							 ->setCategory("Cotizacion");
// Add some data
// 
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nombre Cliente')
            ->setCellValue('A2', $model->nombre)
            ->setCellValue('B1', 'Apellido')
            ->setCellValue('B2', $model->apellido)
            ->setCellValue('C1', 'Fecha Cotización')
            ->setCellValue('C2', $model->fecha);

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A4', 'Vendedor')
			->setCellValue('B4', $model->fkUsuario->nombre);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', 'Nombre Paquete')
									->setCellValue('B6', 'Cantidad Paquete')
									->setCellValue('C6', 'Costo Paquete');
$i = 7;
$acumulado = 0;
foreach ($model->fkPaquetes as $paquete)
{
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $paquete->nombre)
										->setCellValue('B'.$i, $paquete->cantidad)
										->setCellValue('C'.$i, $paquete->monto);
	$acumulado += $paquete->monto;
	$i++;
}
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, 'Sub-Total')
									->setCellValue('C'.$i, $acumulado);
$i++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, 'Descuento')
									->setCellValue('C'.$i, $model->descuento.'%');
$i++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, 'Total')
									->setCellValue('C'.$i, $model->total);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle("Cotizacion ". $model->nombre);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Cotizacion_"'.$model->nombre.'".xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 31 Dec 2020 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;