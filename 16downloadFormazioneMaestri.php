<?

	require_once('vendor/autoload.php');
	include_once("assets/functions/functions.php");
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	include_once("database/databaseii.php");
	$file_name = date('Ymd_h.i.s').'_FormazioneMaestri.xlsx';
	$campo =  array(27);
	$colonna = ["idle", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB"];
	$sql = "SELECT ID_mae, nome_mae, cognome_mae, ID_tit, cat_tit, nome_tit, desc_tit, data_tit, scad_tit, showscad_tit, ckformagg_tit FROM tab_titolimaestri LEFT JOIN tab_anagraficamaestri ON ID_mae = ID_mae_tit WHERE in_organico_mae = 1 ORDER BY cognome_mae, cat_tit, ckformagg_tit DESC";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_mae, $nome_mae, $cognome_mae, $ID_tit, $cat_tit, $nome_tit, $desc_tit, $data_tit, $scad_tit, $showscad_tit, $fckormagg_tit); 
	

		
		
		
	$objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExportFormazioneMaestri.xlsx");
	//$objPHPExcel = PHPExcel_IOFactory::load("TemplateExportFormazioneMaestri.xlsx");
	$objPHPExcel->setActiveSheetIndex(0); // Comincia da 0
    $styleArray = array(
        'borders' => array(
            'outline' => array(
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
            ),
        ),
    );
	$j = 4;
	while (mysqli_stmt_fetch($stmt)) { 
		$j++;
		$objPHPExcel->getActiveSheet()->SetCellValue("A".$j, $j-4 );
		$objPHPExcel->getActiveSheet()->SetCellValue("B".$j, $nome_mae );
		$objPHPExcel->getActiveSheet()->SetCellValue("C".$j, $cognome_mae );
		$objPHPExcel->getActiveSheet()->SetCellValue("D".$j, $cat_tit );

		$objPHPExcel->getActiveSheet()->SetCellValue("E".$j, $nome_tit );
		$objPHPExcel->getActiveSheet()->SetCellValue("F".$j, $desc_tit );
		$objPHPExcel->getActiveSheet()->SetCellValue("G".$j, timestamp_to_ggmmaaaa($data_tit) );
		if (($scad_tit != "1970-01-01") && ($showscad_tit != 1)){$objPHPExcel->getActiveSheet()->SetCellValue("H".$j, timestamp_to_ggmmaaaa($scad_tit) );};
		$objPHPExcel->getActiveSheet()->SetCellValue("I".$j, $fckormagg_tit );


		if ($cat_tit == "Sicurezza") {
			for ($x = 1; $x <= 9; $x++) {
				$objPHPExcel->getActiveSheet()->getStyle($colonna[$x].$j)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle($colonna[$x].$j)->getFill()->getStartColor()->setARGB('FFffeea6');
			}
		}
	}
	$writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
	//header('Location: 16FormazioneMaestri.php');
?>