<?	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	include_once("database/databaseii.php");
	$campo = array();
	$file_name = date('Ymd_h.i.s').'_AnagraficaMaestri.xlsx';
	$colonna = ["idle", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB"];
	$sql = "SELECT ID_mae, nome_mae, cognome_mae, indirizzo_mae, citta_mae, CAP_mae, prov_mae, paese_mae, cf_mae, datanascita_mae, comunenascita_mae, provnascita_mae, paesenascita_mae, telefono_mae, email_mae, note_mae FROM tab_anagraficamaestri WHERE in_organico_mae = 1 AND tipo_per = 0 ORDER BY cognome_mae";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_mae, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5], $campo[6], $campo[7], $campo[8], $campo[9], $campo[10], $campo[11], $campo[12], $campo[13], $campo[14], $campo[15]);	
	$objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExportAnagraficaMaestri.xlsx");

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
		$objPHPExcel->getActiveSheet()->SetCellValue("A".$j, $j-4);
		for ($x = 1; $x <= 15; $x++) {
			$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x+1].$j, $campo[$x] );
		}
	}
	$writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
	//header('Location: 16FormazioneMaestri.php'); QUESTO DETERMINA UN PROBLEMA NEL FILE! DA TOGLIERE!
?>