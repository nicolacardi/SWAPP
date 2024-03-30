<?	
//**************************NON DOVREBBE ESSERE PIU' UTILIZZATA*************************** */
//**************************SOSTITUITA DA 99downloadExcel.php*************************** */

	//INPUT
	$title = "AnagraficaSoci";
	$nomiCampiA = array("idle", "descrizione_tsc", "dataiscrizione_soc", "cognome_soc", "nome_soc", "telefono_soc", "altrotel_soc", "email_soc", "datanascita_soc", "comunenascita_soc", "provnascita_soc", "paesenascita_soc", "cittadinanza_soc", "cf_soc", "indirizzo_soc", "comune_soc", "CAP_soc", "prov_soc", "paese_soc");
	
	$from = " tab_anagraficasoci LEFT JOIN tab_tipisoci ON tipo_soc = ID_tsc ";
	$where = " 1=1 ";
	$orderBY = "dataiscrizione_soc, cognome_soc ";
	$dataNonDataA = array("idle", 0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0);




	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExport".$title.".xlsx"); //0
	include_once("database/databaseii.php");


	$file_name = date('Ymd_h.i.s').'_'.$title;

	$colonna = ["idle", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR", "BS", "BT", "BU", "BV", "BW", "BX", "BY", "BZ", "CA", "CB", "CC", "CD", "CE", "CF", "CG", "CH", "CI", "CJ", "CK", "CL", "CM", "CN", "CO", "CP", "CQ", "CR", "CS", "CT", "CU", "CV", "CW", "CX", "CY", "CZ"];

	$numcampi = count($nomiCampiA);

	$campiSQL = "";
	for ($c = 1; $c < $numcampi; $c++) {
		$campiSQL = $campiSQL.", ".$nomiCampiA[$c];
	}

	$campiSQL = substr($campiSQL, 2); 

	//4, 5
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
			if ($dataNonDataA[$x] == 1) {
				$date2=date_create($campo[$x]);
				$diff=date_diff($date1,$date2);
				$days=$diff->format("%a");
				$days+=2;
				$spreadsheet->getActiveSheet()->setCellValue($colonna[$x].$j,$days); 
			} else {
				$spreadsheet->getActiveSheet()->SetCellValue($colonna[$x].$j, $campo[$x] );
			}
		}
	}

	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
?>