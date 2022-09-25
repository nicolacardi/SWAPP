<?	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExportAnagraficaSoci.xlsx");
	include_once("database/databaseii.php");

	$file_name = date('Ymd_h.i.s').'_AnagraficaSoci';

	$campo =  array(19);

	//per foglio famiglie
	$sql = "SELECT 
	tipo_soc, dataiscrizione_soc, cognome_soc, nome_soc, telefono_soc, altrotel_soc, email_soc, 
	datanascita_soc, comunenascita_soc, provnascita_soc, paesenascita_soc, cf_soc, indirizzo_soc, comune_soc, CAP_soc, prov_soc, paese_soc
	FROM tab_anagraficasoci
	ORDER BY cognome_soc";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5], $campo[6], $campo[7], $campo[8], $campo[9], $campo[10], $campo[11], $campo[12], $campo[13], $campo[14], $campo[15], $campo[16], $campo[17]); 
	$colonna = ["idle", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR", "BS", "BT", "BU", "BV", "BW", "BX", "BY", "BZ", "CA", "CB", "CC", "CD"];


	$spreadsheet->setActiveSheetIndex(0); // Comincia da 0
	

	$spreadsheet->getActiveSheet()->SetCellValue("B1", "Elenco Soci al ".date('d/m/Y'));

	$j = 5; //j corrisponde al numero di riga di excel
	$date1=date_create("1900-01-01");
	$tiposocA = array(0=>"Fruitore", 1=>"Lavoratore",  2=>"Volontario", 3=>"Altro");

	while (mysqli_stmt_fetch($stmt)) { 
		$j++;
		$spreadsheet->getActiveSheet()->SetCellValue("A".$j, $j-5 );
		for ($x = 1; $x <= 17; $x++) {

			switch ($x) {
				case 1 :
					$spreadsheet->getActiveSheet()->SetCellValue($colonna[$x].$j, $tiposocA[$campo[$x]] );
					break;
				case 2 :
				case 8 :
					$date2=date_create($campo[$x]);
					$diff=date_diff($date1,$date2);
					$days=$diff->format("%a");
					$days+=2; // add boundary days
					$spreadsheet->getActiveSheet()->setCellValue($colonna[$x].$j,$days); 
					break;
				default:
					$spreadsheet->getActiveSheet()->SetCellValue($colonna[$x].$j, $campo[$x] );

					break;
			}



		}
	}

	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
?>