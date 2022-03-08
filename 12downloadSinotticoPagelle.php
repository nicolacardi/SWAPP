<?
	include_once("database/databaseii.php");
	require_once('vendor/autoload.php');
	//include_once("assets/functions/functions.php");questa include impediva la creazione del file

	use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateSinotticoPagelle.xlsx");

	$classe_cla = $_GET['classe_cla'];
	$sezione_cla = $_GET['sezione_cla'];
	$annoscolastico_cla = $_GET['annoscolastico_cla'];
	$file_name = date('Ymd_h.i.s').'_SinotticoPagelle_'.$classe_cla.$sezione_cla."-".$annoscolastico_cla;
	$colonna = array("idle", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC");


	$objPHPExcel->getProperties()
	->setTitle('SWAPP')
	->setSubject('SWAPP')
	->setDescription('Export File From SWAPP')
	->setCreator('Nicola Cardi')
	->setLastModifiedBy('Nicola Cardi');

	$styleArray = array(
        'borders' => array(
            'outline' => array(
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
            ),
        ),
	);






	// Estraggo prima la tabella tab_classialunni, che serve per il frontespizio
	$sql = "SELECT DISTINCT nome_alu, cognome_alu, classe_cla, sezione_cla, ggassenza1_cla, ggassenza2_cla, datapagella1_cla, datapagella2_cla, hafreq_cla, votofinale_cla, ammesso_cla, giuquad1_cla, giuquad2_cla, desc_cls ".
	" FROM tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla LEFT JOIN tab_classi ON classe_cla = classe_cls WHERE classe_cla = ? AND sezione_cla = ? AND annoscolastico_cla = ? ORDER BY cognome_alu, nome_alu;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "sss", $classe_cla, $sezione_cla, $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $nome_alu, $cognome_alu, $classe_cla, $sezione_cla, $ggassenza1_cla, $ggassenza2_cla, $datapagella1_cla, $datapagella2_cla, $hafreq_cla, $votofinale_cla, $ammesso_cla, $giuquad1_cla, $giuquad2_cla, $desc_cls);
	while (mysqli_stmt_fetch($stmt)) {
	}


	//Ora estraggo tab_classialunnivoti per voti e giudizi.
	//mi serve prima tipodoc_mat
	//estraggo dunque prima aselme per la classe
	$sql = "SELECT aselme_cls FROM tab_classi WHERE classe_cls = ? ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $classe_cla);	
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $aselme_cls);
	mysqli_stmt_store_result($stmt);
	while (mysqli_stmt_fetch($stmt))
	{}

	//con aselme entro nei parametri per estrarre il tipodoc
	$sql = "SELECT val_paa FROM tab_parametrixanno WHERE annoscolastico_paa = ? AND parname_paa = 'tipopagella_".$aselme_cls."'";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $val_paa);
	while (mysqli_stmt_fetch($stmt))
	{}

	//scrivo le materie nella prima riga in alto
	$sql1 = "SELECT DISTINCT codmat_cla, descmateria_mat, ord_mat FROM
	(tab_materievoti LEFT JOIN tab_classialunnivoti ON codmat_cla = codmat_mat AND aselme_mat = ?  AND tipodoc_mat = ? )
	WHERE classe_cla = ? AND sezione_cla = ? AND annoscolastico_cla = ?
	ORDER BY ord_mat
	";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "sisss", $aselme_cls, $val_paa, $classe_cla, $sezione_cla, $annoscolastico_cla);
	mysqli_stmt_execute($stmt1);
	mysqli_stmt_bind_result($stmt1, $codmat_cla, $descmateria_mat, $ord_mat);
	$colvot1 = 8;
	$materieA = array();
	$descmaterieA = array();
	while (mysqli_stmt_fetch($stmt1)){
		$descmaterieA[$colvot1-7] =  $descmateria_mat;
		$materieA[$colvot1-7] =  $codmat_cla;
		$colvot1++;
	}

	$sql = "SELECT ID_alu, nome_alu, cognome_alu, classe_cla, sezione_cla, codmat_cla, vot1_cla, giu1_cla, vot2_cla, giu2_cla, codmat_mat, descmateria_mat, ord_mat FROM
	((tab_materievoti LEFT JOIN tab_classialunnivoti ON codmat_cla = codmat_mat AND aselme_mat = ?  AND tipodoc_mat = ? )
	LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_cla)
	WHERE classe_cla = ? AND sezione_cla = ? AND annoscolastico_cla = ?
	ORDER BY cognome_alu, nome_alu, ord_mat;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "sisss", $aselme_cls, $val_paa, $classe_cla, $sezione_cla, $annoscolastico_cla);

	mysqli_stmt_bind_result($stmt, $ID_alu, $nome_alu, $cognome_alu, $classe_cla, $sezione_cla, $codmat_cla, $vot1_cla, $giu1_cla, $vot2_cla, $giu2_cla, $codmat_mat, $descmateria_mat, $ord_mat );

	// voti primo quadrimestre
	$row = 3;
	$objPHPExcel->setActiveSheetIndex(0);
	for ($colvot1 = 8; $colvot1 < (count($materieA)+8); $colvot1++) {
		$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colvot1]."3", $descmaterieA[$colvot1-7]);
	}
	mysqli_stmt_execute($stmt);
	while (mysqli_stmt_fetch($stmt)){
		if ($ID_alu != $ID_aluprec) {
			$row++;
			$objPHPExcel->getActiveSheet()->SetCellValue("C".$row, $nome_alu." ".$cognome_alu);
		}
		$ID_aluprec = $ID_alu;
		$colvot1 = array_search($codmat_cla, $materieA);
		if ($vot1_cla != "0" ) {$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colvot1+7].$row, $vot1_cla);}
	}

	for ($col = 8; $col < (count($materieA)+8); $col++) {
		for ($row = 3; $row <= 31; $row++) {
			$objPHPExcel->getActiveSheet()->getStyle($colonna[$col].$row)->applyFromArray($styleArray);
		}
	}

	$objPHPExcel->getActiveSheet()->SetCellValue("C3", "Classe: ".$classe_cla." ".$sezione_cla);

	//voti secondo quadrimestre
	$row = 3;
	$objPHPExcel->setActiveSheetIndex(1);
	for ($colvot1 = 8; $colvot1 < (count($materieA)+8); $colvot1++) {
		$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colvot1]."3", $descmaterieA[$colvot1-7]);
	}

	mysqli_stmt_execute($stmt);
	while (mysqli_stmt_fetch($stmt)){
		if ($ID_alu != $ID_aluprec) {
			$row++;
			$objPHPExcel->getActiveSheet()->SetCellValue("C".$row, $nome_alu." ".$cognome_alu);
		}
		$ID_aluprec = $ID_alu;
		$colvot1 = array_search($codmat_cla, $materieA);
		if ($vot2_cla != "0" ) {$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colvot1+7].$row, $vot2_cla);}
	}

	for ($col = 8; $col < (count($materieA)+8); $col++) {
		for ($row = 3; $row <= 31; $row++) {
			$objPHPExcel->getActiveSheet()->getStyle($colonna[$col].$row)->applyFromArray($styleArray);
		}
	}

	$objPHPExcel->getActiveSheet()->SetCellValue("C3", "Classe: ".$classe_cla." ".$sezione_cla);
	

	// giudizi primo quadrimestre
	$row = 3;
	$objPHPExcel->setActiveSheetIndex(2);


	for ($colvot1 = 8; $colvot1 < (count($materieA)+8); $colvot1++) {
		$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colvot1]."3", $descmaterieA[$colvot1-7]);
	}
	mysqli_stmt_execute($stmt);
	while (mysqli_stmt_fetch($stmt)){
		if ($ID_alu != $ID_aluprec) {
			$row++;
			$objPHPExcel->getActiveSheet()->SetCellValue("C".$row, $nome_alu." ".$cognome_alu);
		}
		$ID_aluprec = $ID_alu;
		$colvot1 = array_search($codmat_cla, $materieA);
		$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colvot1+7].$row, str_replace( "@@", "\n", stripslashes(str_replace("\\n", "@@", $giu1_cla))));
	}

	for ($col = 8; $col < (count($materieA)+8); $col++) {
		for ($row = 3; $row <= 31; $row++) {
			$objPHPExcel->getActiveSheet()->getStyle($colonna[$col].$row)->applyFromArray($styleArray);
		}
	}

	$objPHPExcel->getActiveSheet()->SetCellValue("C3", "Classe: ".$classe_cla." ".$sezione_cla);

	//giudizi secondo quadrimestre
	$row = 3;
	$objPHPExcel->setActiveSheetIndex(3);
	for ($colvot1 = 8; $colvot1 < (count($materieA)+8); $colvot1++) {
		$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colvot1]."3", $descmaterieA[$colvot1-7]);
	}

	mysqli_stmt_execute($stmt);
	while (mysqli_stmt_fetch($stmt)){
		if ($ID_alu != $ID_aluprec) {
			$row++;
			$objPHPExcel->getActiveSheet()->SetCellValue("C".$row, $nome_alu." ".$cognome_alu);
		}
		$ID_aluprec = $ID_alu;
		$colvot1 = array_search($codmat_cla, $materieA);
		$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colvot1+7].$row, str_replace( "@@", "\n", stripslashes(str_replace("\\n", "@@", $giu2_cla))));
	}

	for ($col = 8; $col < (count($materieA)+8); $col++) {
		for ($row = 3; $row <= 31; $row++) {
			$objPHPExcel->getActiveSheet()->getStyle($colonna[$col].$row)->applyFromArray($styleArray);
		}
	}

	$objPHPExcel->getActiveSheet()->SetCellValue("C3", "Classe: ".$classe_cla." ".$sezione_cla);




	




	
	// // Ora estraggo tab_classialunnivoti.
	// $sql = "SELECT DISTINCT ID_alu, nome_alu, cognome_alu, classe_cla, sezione_cla, codmat_cla, vot1_cla, giu1_cla, vot2_cla, giu2_cla, codmat_mat, descmateria_mat ".
	// " FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunnivoti ON ID_alu = ID_alu_cla) LEFT JOIN tab_materievoti on codmat_cla = codmat_mat) LEFT JOIN tab_classi ON classe_cla = classe_cls WHERE classe_cla = ? AND sezione_cla = ? AND annoscolastico_cla = ? ORDER BY cognome_alu, nome_alu, ord_mat;";
	// $stmt = mysqli_prepare($mysqli, $sql);
	// mysqli_stmt_bind_param($stmt, "sss", $classe_cla, $sezione_cla, $annoscolastico_cla);
	// mysqli_stmt_execute($stmt);
	// mysqli_stmt_bind_result($stmt, $ID_alu, $nome_alu, $cognome_alu, $classe_cla, $sezione_cla, $codmat_cla, $vot1_cla, $giu1_cla, $vot2_cla, $giu2_cla, $codmat_mat, $descmateria_mat );
	// mysqli_stmt_store_result($stmt);
	// $row = 3;
	// $ID_aluprec = 0;
	// $colonna = array("idle", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC");
	
	
	// $objPHPExcel->setActiveSheetIndex(2);
	// $colvot1 = 8;
	// $colvot2 = 22;
	// $j = 1;
	// while (mysqli_stmt_fetch($stmt)){
	// 	if ($ID_alu != $ID_aluprec) {
	// 		$row++;
	// 		$colvot1=8;
	// 		$colvot2 = 22;
	// 		$objPHPExcel->getActiveSheet()->SetCellValue("C".$row, $nome_alu." ".$cognome_alu);

	// 		//$objPHPExcel->getActiveSheet()->SetCellValue("C".$row, $classe_cla);
	// 		//$objPHPExcel->getActiveSheet()->SetCellValue("D".$row, $classe_cla);
	// 	}
	// 	$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colvot1]."3", $descmateria_mat);
	// 	$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colvot2]."3", $descmateria_mat);
	// 	$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colvot1].$row, $giu1_cla);
	// 	$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colvot2].$row, $giu2_cla);
	// 	$ID_aluprec = $ID_alu;
	// 	$colvot1++;
	// 	$colvot2++;
	// 	$j++;
	// }
	// $objPHPExcel->getActiveSheet()->SetCellValue("C3", "Classe: ".$classe_cla." ".$sezione_cla);
	//TENTATIVO DI GENERARE PDF
	//$writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($objPHPExcel);
	//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	//header('Content-Disposition: attachment;filename="'.$file_name.'.pdf"');
	//$writer->save('php://output');
    $writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
    $writer->save('php://output');

	
?>
