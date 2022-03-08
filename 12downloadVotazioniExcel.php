<?
	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;

	include_once("database/databaseii.php");
	$annoscolastico_cov = $_GET['annoscolastico_cov'];
	$classe_cov = $_GET['classe_cov'];
	$sezione_cov = $_GET['sezione_cov'];

	$ID_aluA = array();
	$nome_aluA = array();
	$cognome_aluA = array();
	$file_name = date('Ymd_h.i.s').'_VotazioniPerAlunno_cl'.$classe_cov.$sezione_cov.'xlsx';
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateVotazioniExcel.xlsx");
	$spreadsheet->getProperties()
		->setTitle('SWAPP')
		->setSubject('SWAPP')
		->setDescription('Export File From SWAPP')
		->setCreator('Nicola Cardi')
		->setLastModifiedBy('Nicola Cardi');
	$styleWhite = [
		'borders' => [
			'outline' => [
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			],
		],
	];
	$styleGrey = [
		'borders' => [
			'outline' => [
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			],
		],
		'fill' => [
			'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
			'color'	=> array('argb' => 'FFCCFFCC'),
		],
	];

	




	$spreadsheet->setActiveSheetIndex(0);
	//metto in array i valori degli alunni della classe
	$sql2 = "SELECT DISTINCT ID_alu, nome_alu, cognome_alu FROM (tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) WHERE annoscolastico_cla = ? AND classe_cla = ? AND sezione_cla = ? AND ritirato_cla = 0 AND listaattesa_cla = 0 ORDER BY cognome_alu";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "sss", $annoscolastico_cov, $classe_cov, $sezione_cov);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $ID_alu, $nome_alu, $cognome_alu);
	$alunni = 1;
	while (mysqli_stmt_fetch($stmt2)) {
		$ID_aluA[$alunni]= $ID_alu;
		$nome_aluA[$alunni]= $nome_alu;
		$cognome_aluA[$alunni]= $cognome_alu;
		$alunni++;
	}

	function clean($string) {
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	 }
	//$spreadsheet->getActiveSheet()->SetCellValue("B3", "Classe: ".$classe_cla." ".$sezione_cla);
	//$spreadsheet->getActiveSheet()->SetCellValue("B4", "Mese: ".$mese_desc);
	for ($alunno = 2; $alunno < $alunni+1; $alunno++) {
		$clonedWorksheet = clone $spreadsheet->getSheetByName('XX');




		$clonedWorksheet->setTitle(clean($nome_aluA[$alunno])." ".clean($cognome_aluA[$alunno]));
		$spreadsheet->addSheet($clonedWorksheet);
		$spreadsheet->setActiveSheetIndex($alunno);
		$spreadsheet->getActiveSheet()->SetCellValue("B1", $nome_aluA[$alunno]." ".$cognome_aluA[$alunno]);
		$spreadsheet->getActiveSheet()->SetCellValue("B2", "anno scolastico ". $annoscolastico_cov." - classe ".$classe_cov);


		//Seleziona i Voti dell'alunno
		$sql2 = "SELECT ID_alu_vcc, ID_cov_vcc, voto_vcc, codmat_cov, argomento_cov, tipo_cov, data_cov, descmateria_mtt FROM (tab_voticompitiverifiche LEFT JOIN tab_compitiverifiche ON ID_cov_vcc = ID_cov) LEFT JOIN tab_materie ON codmat_mtt = codmat_cov WHERE annoscolastico_cov = ? AND ID_alu_vcc = ?  ORDER BY codmat_cov, tipo_cov, data_cov " ;
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "si", $annoscolastico_cov, $ID_aluA[$alunno]);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $ID_alu_vcc, $ID_cov_vcc, $voto_vcc, $codmat_cov, $argomento_cov, $tipo_cov, $data_cov, $descmateria_mtt);
		$row = 5;
		while (mysqli_stmt_fetch($stmt2)) {
			$spreadsheet->getActiveSheet()->SetCellValue("B".$row, $data_cov);
			$spreadsheet->getActiveSheet()->SetCellValue("C".$row, $argomento_cov);
			$spreadsheet->getActiveSheet()->SetCellValue("D".$row, $descmateria_mtt);
			$spreadsheet->getActiveSheet()->SetCellValue("E".$row, $tipo_cov);
			$spreadsheet->getActiveSheet()->SetCellValue("F".$row, $voto_vcc);
			$row++;
		}
	}











	 $spreadsheet->setActiveSheetIndex(0);
	 $rigabase = 3;
	// //INIZIO PAGINA VOTAZIONI COMPLESSIVE *******************************************************************************************************************
	$col_numero = "B"; 
	$col_nomecognome = "C";

	 $col_voti = array("idle", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
	 for ($x = 65; $x < 70; $x++) {
		 // A, B, C, D, E, F
		for ($y = 65; $y < 91; $y++) {
			//DA A A Z
		 	array_push($col_voti,chr($x).chr($y));
		}
	 }

	// //metto in vari array i valori dei compiti della classe/sezione/annoscolastico
	 $sql1 = "SELECT DISTINCT ID_cov, codmat_cov, tipo_cov, data_cov, argomento_cov, descmateria_mtt FROM tab_compitiverifiche LEFT JOIN tab_materie ON codmat_mtt =  codmat_cov WHERE classe_cov = ? AND sezione_cov = ? AND annoscolastico_cov = ? ORDER BY codmat_cov, tipo_cov, data_cov";
	 $stmt1 = mysqli_prepare($mysqli, $sql1);
	 mysqli_stmt_bind_param($stmt1, "sss", $classe_cov, $sezione_cov, $annoscolastico_cov);
	 mysqli_stmt_execute($stmt1);
	 mysqli_stmt_bind_result($stmt1, $ID_cov, $codmat_cov, $tipo_cov, $data_cov, $argomento_cov, $descmateria_mtt);
	 $compiti = 1;
	 $tipoback = " ";
	 $materiaback = " ";
	 while (mysqli_stmt_fetch($stmt1)) {
		$ID_covA[$compiti]= $ID_cov;
		//data
		$spreadsheet->getActiveSheet()->SetCellValue($col_voti[$compiti].($rigabase+3), $data_cov);
		$spreadsheet->getActiveSheet()->getStyle($col_voti[$compiti].($rigabase+3))->applyFromArray($styleWhite);
		//materia
		if ($descmateria_mtt != $materiaback) { if ($color == 'FFFFFFFF') {$color= 'FF999999';} else {$color= 'FFFFFFFF';}}
		$spreadsheet->getActiveSheet()->SetCellValue($col_voti[$compiti].($rigabase+1), $descmateria_mtt);

		//applico stili
		$spreadsheet->getActiveSheet()->getStyle($col_voti[$compiti].($rigabase+1))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
		$spreadsheet->getActiveSheet()->getStyle($col_voti[$compiti].($rigabase+1))->getFill()->getStartColor()->setARGB($color);
		$spreadsheet->getActiveSheet()->SetCellValue($col_voti[$compiti].($rigabase+2), $tipo_cov);
		$spreadsheet->getActiveSheet()->getStyle($col_voti[$compiti].($rigabase+1))->applyFromArray($styleWhite);
		$spreadsheet->getActiveSheet()->getStyle($col_voti[$compiti].($rigabase+2))->applyFromArray($styleWhite);
		$spreadsheet->getActiveSheet()->getStyle($col_voti[$compiti].($rigabase-1))->applyFromArray($styleWhite);
		$spreadsheet->getActiveSheet()->getStyle($col_voti[$compiti].($rigabase-1))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
		$spreadsheet->getActiveSheet()->getStyle($col_voti[$compiti].($rigabase-1))->getFill()->getStartColor()->setARGB('FFFF0000');
		$spreadsheet->getActiveSheet()->getStyle($col_voti[$compiti].($rigabase-1))->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

		$materiaback = $descmateria_mtt;

	 	$tipoback = $tipo_cov;
	
	 	$codmat_covA[$compiti] = $codmat_cov;
	 	$tipocovA[$compiti] = $tipo_cov;
	 	$datacov[$compiti] = $data_cov;
	 	$argomento_covA[$compiti] = $argomento_cov;
	 	$compiti++;
	 }

	 //metto in vari array i valori degli alunni della classe (non serve qui filtrare anche sul maestro)
	 $sql2 = "SELECT DISTINCT ID_alu, nome_alu, cognome_alu FROM (tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) WHERE annoscolastico_cla = ? AND classe_cla = ? AND sezione_cla = ? AND listaattesa_cla = 0 ";
	 $stmt2 = mysqli_prepare($mysqli, $sql2);
	 mysqli_stmt_bind_param($stmt2, "sss", $annoscolastico_cov, $classe_cov, $sezione_cov);
	 mysqli_stmt_execute($stmt2);
	 mysqli_stmt_bind_result($stmt2, $ID_alu, $nome_alu, $cognome_alu);
	 $alunni = 1;
	 $color = 'ffdaecef';
	 while (mysqli_stmt_fetch($stmt2)) {
	 	$ID_aluA[$alunni]= $ID_alu;
		 $spreadsheet->getActiveSheet()->SetCellValue($col_nomecognome.($alunni+($rigabase+5)), $nome_alu." ".$cognome_alu);
		 $spreadsheet->getActiveSheet()->SetCellValue($col_numero.($alunni+($rigabase+5)), $alunni);

		 //applico stili
		 $spreadsheet->getActiveSheet()->getStyle($col_nomecognome.($alunni+($rigabase+5)))->applyFromArray($styleWhite);
		 $spreadsheet->getActiveSheet()->getStyle($col_numero.($alunni+($rigabase+5)))->applyFromArray($styleWhite);
		 if (fmod($alunni, 2) == 1) {
			$spreadsheet->getActiveSheet()->getStyle($col_numero.($alunni+($rigabase+5)))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
			$spreadsheet->getActiveSheet()->getStyle($col_numero.($alunni+($rigabase+5)))->getFill()->getStartColor()->setARGB($color);
			$spreadsheet->getActiveSheet()->getStyle($col_nomecognome.($alunni+($rigabase+5)))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
			$spreadsheet->getActiveSheet()->getStyle($col_nomecognome.($alunni+($rigabase+5)))->getFill()->getStartColor()->setARGB($color);
		 }
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
			if ($voto_vcc != "") {$spreadsheet->getActiveSheet()->SetCellValue($col_voti[$compito].($row+2), $voto_vcc);}
			$spreadsheet->getActiveSheet()->getStyle($col_voti[$compito].($row+2))->applyFromArray($styleWhite);
	 		$row++;
	 	}
	 }

	 for ($alunno = 9; $alunno <= ($alunni+7); $alunno++) {
	 	$spreadsheet->getActiveSheet()->setCellValue(
        'D'.$alunno,
        '=IFERROR(SUMPRODUCT(F'.$alunno.':FZ'.$alunno.'*F$2:FZ$2)/SUMPRODUCT(F$2:FF$2*NOT(ISBLANK(F'.$alunno.':FF'.$alunno.'))),"")'
		);
		$spreadsheet->getActiveSheet()->getStyle('D'.$alunno)->applyFromArray($styleWhite);
	}

	$spreadsheet->removeSheetByIndex(1);




	
	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
	exit;
?>











