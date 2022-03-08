<?
	include_once("database/databaseii.php");
	$annoscolastico_cla = $_GET['annoscolastico_cla'];
	$file_name = date('Ymd_h.i.s').'_RettePerFamiglia_'.$annoscolastico_cla.'.xlsx';
	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	$objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExportRettePerFamiglia.xlsx");

	$sql = "SELECT cognomepadre_fam, ID_fam, COUNT(ID_alu)/12 as fratelli, SUM(default_ret) as TOTD, SUM(concordato_ret) as TOTC, SUM(pagato_ret) as TOTP, (SUM(default_ret) - SUM(concordato_ret)) as TOTD_C, (SUM(concordato_ret) - SUM(pagato_ret)) as TOTC_P FROM ((tab_anagraficaalunni LEFT JOIN tab_famiglie ON ID_fam = ID_fam_alu) LEFT JOIN tab_mensilirette ON ID_alu = ID_alu_ret) WHERE annoscolastico_ret = ? GROUP BY ID_fam_alu ORDER BY TOTD_C DESC, cognomepadre_fam ASC;";
	$stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $cognomepadre_fam, $ID_fam, $fratelli, $TOTD, $TOTC, $TOTP, $TOTD_C, $TOTC_P); 
	$objPHPExcel->setActiveSheetIndex(0); // Comincia da 0
	$objPHPExcel->getActiveSheet()->SetCellValue("A1", $annoscolastico_cla);
	$j = 4; //j è un numero che cresce di una unità ogni volta che scrivo un alunno-corrisponde al numero di riga di excel
	while (mysqli_stmt_fetch($stmt)) {	
		$j++;   
		$objPHPExcel->getActiveSheet()->SetCellValue("A".$j, $cognomepadre_fam);
		$objPHPExcel->getActiveSheet()->SetCellValue("B".$j, $fratelli);
		$objPHPExcel->getActiveSheet()->SetCellValue("C".$j, $TOTD);
		$objPHPExcel->getActiveSheet()->SetCellValue("D".$j, $TOTC);
		$objPHPExcel->getActiveSheet()->SetCellValue("E".$j, $TOTP);
		$objPHPExcel->getActiveSheet()->SetCellValue("F".$j, $TOTD_C);
		$objPHPExcel->getActiveSheet()->SetCellValue("G".$j, $TOTC_P);
	}

	$writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');

?>