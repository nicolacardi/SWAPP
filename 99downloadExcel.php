<?	

	//INPUT
	$template = 		$_POST["template"];
	$filetitle = 		$_POST["filetitle"];
	$title = 			$_POST["title"];
	$from = 			$_POST["from"];
	$where = 			$_POST["where"];
	$orderBY = 			$_POST["orderBY"];
	$nomiCampiA = 		json_decode($_POST['nomiCampiA']);
	$dataNonDataA = 	json_decode($_POST['dataNonDataA']);
	$columnColoring = 	json_decode($_POST['columnColoring']);


	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExport".$template.".xlsx"); //0
	include_once("database/databaseii.php");

	$file_name = date('Ymd_h.i.s').'_'.$filetitle;

	$colonna = ["idle", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR", "BS", "BT", "BU", "BV", "BW", "BX", "BY", "BZ", "CA", "CB", "CC", "CD", "CE", "CF", "CG", "CH", "CI", "CJ", "CK", "CL", "CM", "CN", "CO", "CP", "CQ", "CR", "CS", "CT", "CU", "CV", "CW", "CX", "CY", "CZ"];

	$numcampi = count($nomiCampiA);
	$campiSQL = "";
	for ($c = 1; $c < $numcampi; $c++) {
		$campiSQL = $campiSQL.", ".$nomiCampiA[$c];
	}

	$campiSQL = substr($campiSQL, 2); 

	$sql = "SELECT ".$campiSQL." FROM ". $from." WHERE ".$where." ORDER BY ".$orderBY;
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);

	
	$resultFields = array(&$stmt);
	$campo =  array($numcampi);
	for ($c = 1; $c < $numcampi; $c++) {
		$resultFields[$c] = & $campo[$c]; 
	}
	call_user_func_array ("mysqli_stmt_bind_result", $resultFields);
	$stmt->execute();

	$spreadsheet->setActiveSheetIndex(0);
	
	//6
	$spreadsheet->getActiveSheet()->SetCellValue("A1", $title." al ".date('d/m/Y'));

	$date1=date_create("1900-01-01");

	$j = 5;
	while (mysqli_stmt_fetch($stmt)) { 
		$j++;
		$spreadsheet->getActiveSheet()->SetCellValue("A".$j, $j-5 );
		for ($x = 1; $x < $numcampi; $x++) {
			if ($dataNonDataA[$x] == 0  || $dataNonDataA == NULL || $dataNonDataA == '' || $dataNonDataA == undefined) {
				$spreadsheet->getActiveSheet()->SetCellValue($colonna[$x].$j, $campo[$x] );
			} else {
				if ($campo[$x]!= NULL) {
					$date2=date_create($campo[$x]);
					$diff=date_diff($date1,$date2);
					$days=$diff->format("%a");
					$days+=2;
					$spreadsheet->getActiveSheet()->setCellValue($colonna[$x].$j,$days); 
				}
			}

			//se nel valore campo indicato come responsabile per la colorazione c'è 1..coloro la riga intera con il colore indicato in columnColoring[$x]
			if ($columnColoring != NULL && $columnColoring!= '' && $columnColoring!= undefined && $campo[$x] == "1" && $columnColoring[$x] != "0") {
				$spreadsheet->getActiveSheet()->getStyle("A".$j.":".$colonna[$numcampi-1].$j)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
				$spreadsheet->getActiveSheet()->getStyle("A".$j.":".$colonna[$numcampi-1].$j)->getFill()->getStartColor()->setARGB($columnColoring[$x]);
			}
		}
	}


	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');

?>