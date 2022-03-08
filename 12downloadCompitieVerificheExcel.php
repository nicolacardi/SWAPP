<?
	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	include_once("database/databaseii.php");
	$rigabase = 5;
	$annoscolastico_cla = $_GET['annoscolastico_cla'];
	$classe_cla = $_GET['classe_cla'];
	$sezione_cla = $_GET['sezione_cla'];
	$ID_mae = $_GET['ID_mae'];
	$codscuola = $_SESSION['codscuola'];
	//$ID_mae= $_SESSION['ID_mae'];
	$ID_covA = array();
	$codmat_covA = array();
	$tipocovA = array();
	$datacov = array();
	$argomento_covA = array();
	$ID_aluA = array();
	$file_name = date('Ymd_h.i.s').'_Votazioni_'.$ID_mae."_cl".$classe_cla.$sezione_cla;
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateCompitiVerifiche.xls");
	$spreadsheet->getProperties()
		->setTitle('SWAPP')
		->setSubject('SWAPP')
		->setDescription('Export File From SWAPP')
		->setCreator('Nicola Cardi')
		->setLastModifiedBy('Nicola Cardi');
	$styleArray = [
		'borders' => [
			'left' => [
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			],
		],
	];
	
	$styleArray2 = [
		'borders' => [

			'outline' => [
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				'color'=>['argb'=>'FF7030a0']
				,
			],
		],
	];
	
	//INIZIO PAGINA MATERIE *******************************************************************************************************************
	$spreadsheet->setActiveSheetIndex(4);
	$spreadsheet->getActiveSheet()->SetCellValue("H4", "anno scolastico ".$annoscolastico_cla);
	$sql3 = "SELECT ".
	" ID_cma, annoscolastico_cma, ruolo_cma, codmat_cma, descmateria_mtt, classe_cma, sezione_cma, aselme_cls, desc_cls  ".//campi di tab_classimaestri
	"FROM (tab_classimaestri LEFT JOIN tab_materie ON codmat_cma = codmat_mtt) LEFT JOIN tab_classi ON classe_cma = classe_cls WHERE codmat_mtt <> 'ESE' AND ID_mae_cma = ? AND annoscolastico_cma = ? ORDER BY  ord_cls ASC, descmateria_mtt ASC;";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "is", $ID_mae, $annoscolastico_cla);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_bind_result($stmt3, $ID_cma, $annoscolastico_cma, $ruolo_cma, $codmat_cma, $descmateria_mat, $classe_cma, $sezione_cma, $aselme_cls, $desc_cls);
	$k=7;
	while (mysqli_stmt_fetch($stmt3)) {
		$k++;
				//$spreadsheet->getActiveSheet()->SetCellValue("B".$k, $annoscolastico_cma);
				//$spreadsheet->getActiveSheet()->getStyle("B".$k)->applyFromArray($styleArray2);
				$spreadsheet->getActiveSheet()->SetCellValue("C".$k, $descmateria_mat);
				$spreadsheet->getActiveSheet()->mergeCells("C".$k.":F".$k);
				$spreadsheet->getActiveSheet()->getStyle("C".$k)->applyFromArray($styleArray2);
				$spreadsheet->getActiveSheet()->getStyle("D".$k)->applyFromArray($styleArray2);
				$spreadsheet->getActiveSheet()->getStyle("E".$k)->applyFromArray($styleArray2);
				$spreadsheet->getActiveSheet()->getStyle("F".$k)->applyFromArray($styleArray2);
				$spreadsheet->getActiveSheet()->SetCellValue("G".$k, $desc_cls);
				$spreadsheet->getActiveSheet()->mergeCells("G".$k.":H".$k);
				$spreadsheet->getActiveSheet()->getStyle("G".$k)->applyFromArray($styleArray2);
				$spreadsheet->getActiveSheet()->getStyle("H".$k)->applyFromArray($styleArray2);
				$spreadsheet->getActiveSheet()->SetCellValue("I".$k, "A");
				$spreadsheet->getActiveSheet()->getStyle("I".$k)->applyFromArray($styleArray2);
				//$spreadsheet->getActiveSheet()->SetCellValue("M".$k, $aselme_cls);



				switch ($aselme_cls) {
					case "AS" :
						//non possibile
						break;
					case "EL" :
						$spreadsheet->getActiveSheet()->SetCellValue("J".$k, "Scuola Primaria");
						break;
					case "ME" :
						$spreadsheet->getActiveSheet()->SetCellValue("J".$k, "Scuola Secondaria di primo grado");
						break;
					case "SU" :
						$spreadsheet->getActiveSheet()->SetCellValue("J".$k, "Scuola Secondaria di secondo grado");
						break;
				}


				$spreadsheet->getActiveSheet()->mergeCells("J".$k.":M".$k);
				$spreadsheet->getActiveSheet()->getStyle("J".$k)->applyFromArray($styleArray2);
				$spreadsheet->getActiveSheet()->getStyle("K".$k)->applyFromArray($styleArray2);
				$spreadsheet->getActiveSheet()->getStyle("L".$k)->applyFromArray($styleArray2);
				$spreadsheet->getActiveSheet()->getStyle("M".$k)->applyFromArray($styleArray2);

	}
	
	$drawing2 = new PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
	$indicetimbro = rand(1,9);
	$drawing2->setPath(__DIR__ . '/assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png');
	$drawing2->setHeight(80);
	$drawing2->setCoordinates('M56');  
	$drawing2->setWorksheet($spreadsheet->getActiveSheet());
	//FINE PAGINA MATERIE *******************************************************************************************************************
	
	
	
	//INIZIO PAGINA ORARIO *******************************************************************************************************************
	$spreadsheet->setActiveSheetIndex(5);
	//devo trovare una settimana di "campionamento" dove andare a guardare all'orario: scelgo non la prima settimana dell'anno, nemmeno la seconda ma la terza, dal lunedi al venerdi.
	//quindi guardo in tab_anniscolastici la data di inizio, e trovo non il unedi successivo ma due lunedi successivi (INTERVAL(16...)...) come datefrom
	
	//$sql = "SELECT datainizio_asc FROM tab_anniscolastici WHERE annoscolastico_asc = ?";
	//trovo la prima data del quadrimestre. Con la complessa sql qui sotto si ricava la data del PROSSIMO LUNEDI RISPETTO ALLA DATA DI INIZIO DELL'ANNO (che si trova in tab_anniscolastici).
	//$sql = "SELECT DATE_ADD(datainizio_asc, INTERVAL (9 - IF(DAYOFWEEK(datainizio_asc)=1, 8, DAYOFWEEK(datainizio_asc))) DAY) AS NEXTMONDAY FROM tab_anniscolastici WHERE annoscolastico_asc = ?" ;
	//trovo la prima data del quadrimestre. Con la complessa sql qui sotto si ricava la data di DUE LUNEDI SUCCESSIVI RISPETTO ALLA DATA DI INIZIO DELL'ANNO (che si trova in tab_anniscolastici).
	$sql = "SELECT DATE_ADD(datainizio_asc, INTERVAL (16 - IF(DAYOFWEEK(datainizio_asc)=1, 8, DAYOFWEEK(datainizio_asc))) DAY) AS NEXTMONDAY FROM tab_anniscolastici WHERE annoscolastico_asc = ?" ;
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $_SESSION['anno_corrente']);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $datefrom);
	while (mysqli_stmt_fetch($stmt)) {
	}
	$date = strtotime($datefrom);
	$date = strtotime("+4 day", $date);
	$dateto =  date('Y-m-d', $date); //data di fine 'campionamento' per la scrittura dell'orario
	
	//$spreadsheet->getActiveSheet()->SetCellValue("A1", $_SESSION['anno_corrente']. " ".$datefrom." ". $dateto);
	//vengono incluse sia le ore come primo amestro che come secondo maestro
	$colonna = ["idle", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB"];
	$sql = "SELECT ID_ora, data_ora, ora_ora, codmat_ora, classe_ora, sezione_ora, ID_mae_ora, firma_mae_ora, assente_ora, supplente_ora, datafirma_ora, argomento_ora, compitiassegnati_ora, ".
	" CONCAT (nome_mae , ' ', cognome_mae) as nomecognome_mae, descmateria_mtt, ID_mtt ".
	" FROM (tab_orario LEFT JOIN tab_anagraficamaestri ON ID_mae_ora = ID_mae) ".
	" LEFT JOIN tab_materie ON codmat_ora = codmat_mtt ".
	" WHERE (data_ora BETWEEN ? AND ? ) AND ID_mae = ? ORDER BY nomecognome_mae, data_ora, ora_ora";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssi", $datefrom, $dateto, $ID_mae);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ora, $data_ora, $ora_ora, $codmat_ora, $classe_ora, $sezione_ora, $ID_mae_ora, $firma_mae_ora, $assente_ora, $supplente_ora, $datafirma_ora, $argomento_ora, $compitiassegnati_ora, $nomecognome_mae, $descmateria_mtt, $ID_mtt); 
	$nomecognome_mae = preg_replace('/[^A-Za-z0-9\-]/', '', $nomecognome_mae); 
	$data_ora_prec = "1999-01-01";
	$colonna_indice = 4;
	while (mysqli_stmt_fetch($stmt)) {
			if ($data_ora != $data_ora_prec) { $colonna_indice++;}
			if ($ora_ora <=2 ) { $descmateria_mtt = "EPOCA";}
			$spreadsheet->getActiveSheet()->SetCellValue($colonna[$colonna_indice].(2*$ora_ora+4), $classe_ora);
			$spreadsheet->getActiveSheet()->SetCellValue($colonna[$colonna_indice].(2*$ora_ora+4-1), $descmateria_mtt);
			//$objPHPExcel->getActiveSheet()->SetCellValue("A1", $ID_mae);
			$data_ora_prec = $data_ora;
	}
	//FINE PAGINA ORARIO *******************************************************************************************************************
	
	
	
	
	//INIZIO PAGINA VOTAZIONI *******************************************************************************************************************
	$col_nomecognome = "C";
	$col_voti = array("idle", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ"  );
	//metto in vari array i valori dei compiti del maestro/classe/sezione/annoscolastico
	$sql1 = "SELECT DISTINCT ID_cov, codmat_cov, tipo_cov, data_cov, argomento_cov, descmateria_mtt FROM tab_compitiverifiche LEFT JOIN tab_materie ON codmat_mtt =  codmat_cov WHERE classe_cov = ? AND sezione_cov = ? AND annoscolastico_cov = ? AND ID_mae_cov = ? ORDER BY codmat_cov, tipo_cov, data_cov";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "sssi", $classe_cla, $sezione_cla, $annoscolastico_cla, $ID_mae);
	mysqli_stmt_execute($stmt1);
	mysqli_stmt_bind_result($stmt1, $ID_cov, $codmat_cov, $tipo_cov, $data_cov, $argomento_cov, $descmateria_mtt);
	$compiti = 1;
	$tipoback = " ";
	$materiaback = " ";
	$spreadsheet->setActiveSheetIndex(6);
	$spreadsheet->getActiveSheet()->SetCellValue("B1", "classe: ".$classe_cla." ".$sezione_cla);
	while (mysqli_stmt_fetch($stmt1)) {
		$ID_covA[$compiti]= $ID_cov;
		//$spreadsheet->getActiveSheet()->SetCellValue("AG".($compiti+7), $ID_cov); //TEMPORANEO DA CANCELLARE
		//$spreadsheet->getActiveSheet()->SetCellValue("AH".($compiti+7), $compiti); //TEMPORANEO DA CANCELLARE
		$spreadsheet->getActiveSheet()->SetCellValue($col_voti[$compiti].($rigabase+3), $data_cov);
		if ($descmateria_mtt != $materiaback) {
			$spreadsheet->getActiveSheet()->SetCellValue($col_voti[$compiti].($rigabase+1), $descmateria_mtt);
			$spreadsheet->getActiveSheet()->getStyle($col_voti[$compiti].($rigabase+1))->applyFromArray($styleArray);
		}
		$materiaback = $descmateria_mtt;
		if ($tipo_cov != $tipoback) {
			$spreadsheet->getActiveSheet()->SetCellValue($col_voti[$compiti].($rigabase+2), $tipo_cov);
			$spreadsheet->getActiveSheet()->getStyle($col_voti[$compiti].($rigabase+2))->applyFromArray($styleArray);
		}
		$tipoback = $tipo_cov;
	
		$codmat_covA[$compiti] = $codmat_cov;
		$tipocovA[$compiti] = $tipo_cov;
		$datacov[$compiti] = $data_cov;
		$argomento_covA[$compiti] = $argomento_cov;
		$compiti++;
	}
	//metto in vari array i valori degli alunni della classe (non serve qui filtrare anche sul maestro)
	$sql2 = "SELECT DISTINCT ID_alu, nome_alu, cognome_alu FROM (tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) WHERE annoscolastico_cla = ? AND classe_cla = ? AND sezione_cla = ?";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "sss", $annoscolastico_cla, $classe_cla, $sezione_cla);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $ID_alu, $nome_alu, $cognome_alu);
	$alunni = 1;
	while (mysqli_stmt_fetch($stmt2)) {
		$ID_aluA[$alunni]= $ID_alu;
		$spreadsheet->getActiveSheet()->SetCellValue($col_nomecognome.($alunni+($rigabase+3)), $nome_alu." ".$cognome_alu);
		$alunni++;
	}

	//ora compito per compito entro dentro tab_voticompitiverifiche e estraggo i voti da mettere nell'excel. Sembra la modalità più SICURA per non sbagliare con indici vari visto che molti compiti potrebbero non avere ancora valutazione (-> in tab_voticompitiverifiche non ci sarebbe un record per ogni alunno!)
	//se questa modalità risultasse onerosa si può anche estrarre tutti i valori dei voti e mettere ANCHE QUESTI in array (dei quali alcuni valori saranno nulli) e poi popolare il file excel ciclando sugli array
	for ($compito = 1; $compito <= ($compiti-1); $compito++) {
		$row =  ($rigabase+4);
		for ($alunno = 1; $alunno <= ($alunni-1); $alunno++) {
			$sql = "SELECT voto_vcc FROM tab_voticompitiverifiche WHERE ID_cov_vcc = ?  AND id_alu_vcc = ? ";
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_bind_param($stmt, "ii", $ID_covA[$compito], $ID_aluA[$alunno]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $voto_vcc);
			while (mysqli_stmt_fetch($stmt)) {
			}
			//$spreadsheet->getActiveSheet()->SetCellValue($col_voti[$compito].$row, $sql);
			if ($voto_vcc != "") {$spreadsheet->getActiveSheet()->SetCellValue($col_voti[$compito].$row, $voto_vcc);}
			$row++;
		}
	}
	//timbro nella pagina dei voti
	$drawing = new PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
	$indicetimbro = rand(1,9);
	$drawing->setPath(__DIR__ . '/assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png');
	$drawing->setHeight(80);
	$drawing->setCoordinates('AD37');  
	$drawing->setWorksheet($spreadsheet->getActiveSheet());
	//scrivo nel frontespizio
	$sql2 = "SELECT nome_mae, cognome_mae FROM tab_anagraficamaestri WHERE ID_mae = ? ";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "i", $ID_mae);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $nome_mae, $cognome_mae);
	while (mysqli_stmt_fetch($stmt2)) {
	}
	//FINE PAGINA VOTAZIONI *******************************************************************************************************************
	
	//INIZIO FRONTESPIZIO *******************************************************************************************************************
	//vado alla copertina per scriverci il nome del maestro, della classe e metterci il timbro
	$spreadsheet->setActiveSheetIndex(0);
	$spreadsheet->getActiveSheet()->SetCellValue("H10", $nome_mae." ".$cognome_mae);
	$spreadsheet->getActiveSheet()->SetCellValue("H12", "anno scolastico ".$annoscolastico_cla);
	$spreadsheet->getActiveSheet()->SetCellValue("K38", "(".$nome_mae." ".$cognome_mae.")");
	//logo grande sul frontespizio
	$logocolore = "logodefViolaScuro.png";
	$drawing3 = new PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
	$drawing3->setPath(__DIR__ . '/assets/img/logo/logo'.$codscuola.'/'.$logocolore);
	$drawing3->setHeight(130);
	$drawing3->setCoordinates('F3');  
	$drawing3->setWorksheet($spreadsheet->getActiveSheet());
	//timbro sul frontespizio
	$drawing1 = new PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
	$indicetimbro = rand(1,9);
	$drawing1->setPath(__DIR__ . '/assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png');
	$drawing1->setHeight(80);
	$drawing1->setCoordinates('L39');  
	$drawing1->setWorksheet($spreadsheet->getActiveSheet());
	//FINE FRONTESPIZIO *******************************************************************************************************************
	
	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
	exit;

?>










