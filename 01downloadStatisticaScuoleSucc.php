<?
//**************************NON DOVREBBE ESSERE PIU' UTILIZZATA*************************** */
//**************************SOSTITUITA DA 99downloadExcel.php*************************** */
	include_once("database/databaseii.php");
	
	$file_name = date('Ymd_h.i.s').'_StatisticaScuoleSuccessive';
	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	$objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExportStatisticheScuoleSucc.xlsx");

	$campo =  array(7);

	$sql = "SELECT nome_alu, cognome_alu, annoscolastico_cla, tiposcuolasucc_alu, sottotiposcuolasucc_alu, nomescuolasucc_alu, votoesamiVIII_alu
	FROM (tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla)
    WHERE tiposcuolasucc_alu <> '' AND classe_cla = 'VIII'
	ORDER BY annoscolastico_cla, cognome_alu ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5], $campo[6], $campo[7]); 
	$colonna = ["idle", "B", "C", "D", "E", "F", "G", "H"];


	$objPHPExcel->setActiveSheetIndex(0); // Comincia da 0
	$j = 4; //j è un numero che cresce di una unità ogni volta che scrivo un alunno-corrisponde al numero di riga di excel
	while (mysqli_stmt_fetch($stmt)) { 
		$j++;
		$objPHPExcel->getActiveSheet()->SetCellValue("A".$j, $j-4 );
		for ($x = 1; $x <= 7; $x++) {
			$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x].$j, $campo[$x] );
		}
	}


	$writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
?>