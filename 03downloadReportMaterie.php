<?	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	include_once("database/databaseii.php");
	$campo = array();
	$file_name = date('Ymd_h.i.s').'_ReportMaterie.xlsx';
	$colonna = ["idle", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB"];
	$sql = "SELECT ID_mae, nome_mae, cognome_mae, descmateria_mtt, classe_cma, sezione_cma, annoscolastico_cma FROM tab_classimaestri LEFT JOIN tab_anagraficamaestri ON ID_mae = ID_mae_cma LEFT JOIN tab_materie ON codmat_cma = codmat_mtt ORDER BY annoscolastico_cma DESC, cognome_mae, classe_cma";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_mae, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5], $campo[6]);	
	$objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExportReportMaterie.xlsx");

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
		for ($x = 1; $x <= 6; $x++) {
			$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x+1].$j, $campo[$x] );
		}
	}
	$writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');

?>