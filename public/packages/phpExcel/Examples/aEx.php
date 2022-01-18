<?php
$usuario      = "root";
$senha        = "";
$banco        = "pinboss";
$conexao = mysql_connect ('localhost',$usuario,$senha);
mysql_select_db ($banco, $conexao);
$sql = "select * from usuarios";
$result = mysql_query($sql);
require_once '../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$rowCount = 1;
$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Nombre');
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Apellido');
$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Email');
$rowCount++;
while($row = mysql_fetch_assoc($result)){
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['nombre']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['apellido']);
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['email']);
    $rowCount++;
}
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('some_excel_file.xlsx');
header('location: http://localhost/practicas/PHP/phpExcel/Examples/some_excel_file.xlsx')
?>