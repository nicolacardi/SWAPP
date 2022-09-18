<?
//scarica un report excel con il calcolo ore di assenza per ogni alunno della classe
	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	include_once("database/databaseii.php");
	$annoscolastico_cla = $_GET['annoscolastico_cla'];
	$classe_cla = $_GET['classe_cla'];
	$sezione_cla = $_GET['sezione_cla'];
	$date_from= $_GET['date_from'];
	$date_to= $_GET['date_to'];

	$file_name = date('Ymd_h.i.s').'_CalcoloAssenze_cl'.$classe_cla.$sezione_cla.'-'.$date_from.'-'.$date_to;
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateCalcoloAssenze.xlsx");
	$spreadsheet->getProperties()
		->setTitle('SWAPP')
		->setSubject('SWAPP')
		->setDescription('Export File From SWAPP')
		->setCreator('Nicola Cardi')
		->setLastModifiedBy('Nicola Cardi');
	$styleArray = [
		'fill' => [
			'fillType' => [
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
			],
		],
	];
	$spreadsheet->setActiveSheetIndex(0);
	//metto in vari array i valori degli alunni della classe (non serve qui filtrare anche sul maestro)
	/*
	La seguente MEGA query calcola ore di presenza e ore di assenza per ogni alunno di ogni classe nel 2018-19 per ciascuna materia
	
	
	
	SELECT tab_classialunni.classe_cla, nome_alu, cognome_alu, tab_orario.codmat_ora, descmateria_mtt, COUNT(tab_orario.ora_ora) as Orefatte, totassenze
	FROM (((tab_orario LEFT JOIN tab_classialunni ON classe_ora = classe_cla)
	LEFT JOIN tab_classi ON classe_cla= classe_cls)
	LEFT JOIN tab_anagraficaalunni ON ID_alu_cla = ID_alu
	LEFT JOIN 
	(SELECT ID_alu_ass, COUNT(ora_ass) AS totassenze, classe_cla, codmat_ora FROM (tab_assenze INNER JOIN tab_classialunni ON ID_alu_ass = ID_alu_cla) LEFT JOIN tab_orario ON data_ora = data_ass AND ora_ass = ora_ora AND classe_ora = classe_cla WHERE annoscolastico_cla = "2018-19" GROUP BY ID_alu_ass, codmat_ora ORDER BY ID_alu_ass, codmat_ora) AS totaleassenze ON totaleassenze.ID_alu_ass = ID_alu AND totaleassenze.codmat_ora = tab_orario.codmat_ora ) LEFT JOIN tab_materie ON tab_orario.codmat_ora = codmat_mtt WHERE tab_classialunni.annoscolastico_cla = "2018-19" AND tab_orario.codmat_ora <> "nom" AND tab_orario.codmat_ora <> "XX1" AND tab_orario.codmat_ora <>"XX2"  GROUP BY ID_alu_cla, codmat_ora  ORDER BY ord_cls, cognome_alu, ord_mtt
	
	********************SPIEGAZIONE DELLA QUERY****************
	La prima parte...
	SELECT tab_classialunni.classe_cla, nome_alu, cognome_alu, tab_orario.codmat_ora, descmateria_mtt, COUNT(tab_orario.ora_ora) as Orefatte, totassenze
	FROM (((tab_orario LEFT JOIN tab_classialunni ON classe_ora = classe_cla)
	LEFT JOIN tab_classi ON classe_cla= classe_cls)
	LEFT JOIN tab_anagraficaalunni ON ID_alu_cla = ID_alu
	...
	WHERE tab_classialunni.annoscolastico_cla = "2018-19" AND tab_orario.codmat_ora <> "nom" AND tab_orario.codmat_ora <> "XX1" AND tab_orario.codmat_ora <>"XX2"  GROUP BY ID_alu_cla, codmat_ora  ORDER BY ord_cls, cognome_alu, ord_mtt


	...mette insieme i valori delle ore frequentate da ciascun alunno
	
	...mentre quella inserita al posto dei puntini:
	(SELECT ID_alu_ass, COUNT(ora_ass) AS totassenze, classe_cla, codmat_ora FROM (tab_assenze INNER JOIN tab_classialunni ON ID_alu_ass = ID_alu_cla) LEFT JOIN tab_orario ON data_ora = data_ass AND ora_ass = ora_ora AND classe_ora = classe_cla WHERE annoscolastico_cla = "2018-19" GROUP BY ID_alu_ass, codmat_ora ORDER BY ID_alu_ass, codmat_ora) AS totaleassenze
	
	...viene messa in LEFT JOIN con la precedente sui seguenti campi...
	
	ON totaleassenze.ID_alu_ass = ID_alu AND totaleassenze.codmat_ora = tab_orario.codmat_ora
	...  e serve ad affiancare le ore totali di assenza
	
	
	
	
	
*/
	
	// $sql2 = "SELECT tab_classialunni.classe_cla, nome_alu, cognome_alu, tab_orario.codmat_ora, descmateria_mtt, COUNT(tab_orario.ora_ora) as Orefatte, totassenze
	// 		FROM (((tab_orario LEFT JOIN tab_classialunni ON classe_ora = classe_cla)
	// 		LEFT JOIN tab_classi ON classe_cla= classe_cls)
	// 		LEFT JOIN tab_anagraficaalunni ON ID_alu_cla = ID_alu
	// 		LEFT JOIN 
	// 		(SELECT ID_alu_ass, COUNT(ora_ass) AS totassenze, classe_cla, codmat_ora FROM (tab_assenze INNER JOIN tab_classialunni ON ID_alu_ass = ID_alu_cla) LEFT JOIN tab_orario ON data_ora = data_ass AND ora_ass = ora_ora AND classe_ora = classe_cla WHERE annoscolastico_cla = ? GROUP BY ID_alu_ass, codmat_ora ORDER BY ID_alu_ass, codmat_ora) AS totaleassenze ON totaleassenze.ID_alu_ass = ID_alu AND totaleassenze.codmat_ora = tab_orario.codmat_ora )
	// 		LEFT JOIN tab_materie ON tab_orario.codmat_ora = codmat_mtt 
	// 		WHERE tab_classialunni.annoscolastico_cla = ? 
	// 		AND tab_orario.codmat_ora <> 'nom'
	// 		AND tab_orario.codmat_ora <> 'XX1' 
	// 		AND tab_orario.codmat_ora <> 'XX3'
	// 		AND tab_orario.codmat_ora <> 'XX4'
	// 		AND tab_orario.codmat_ora <> 'XX2'  
	// 		GROUP BY ID_alu_cla, codmat_ora 
	// 		ORDER BY ord_cls, cognome_alu, ord_mtt	 ";



	$sql2= "SELECT tab_classialunni.classe_cla, ID_alu, nome_alu, cognome_alu, codmat_ora, descmateria_mtt, COUNT(ora_ora) as Orefatte FROM tab_orario LEFT JOIN tab_classialunni ON classe_ora = classe_cla LEFT JOIN tab_classi ON classe_cla = classe_cls LEFT JOIN tab_anagraficaalunni ON ID_alu_cla = ID_alu LEFT JOIN tab_materie ON tab_orario.codmat_ora = codmat_mtt WHERE tab_classialunni.annoscolastico_cla = ? AND tab_orario.codmat_ora <> 'nom' AND tab_orario.codmat_ora <> 'XX1' AND tab_orario.codmat_ora <> 'XX3' AND tab_orario.codmat_ora <> 'XX4' AND tab_orario.codmat_ora <> 'XX2' GROUP BY tab_classialunni.classe_cla, ID_alu_cla, codmat_ora, descmateria_mtt, ord_cls, ord_mtt ORDER BY ord_cls, cognome_alu, ord_mtt";

	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $classe_cla, $ID_alu, $nome_alu, $cognome_alu, $codmat_ora, $descmateria_mtt, $orefatte);
	$riga = 2;
	mysqli_stmt_store_result($stmt2);
	while (mysqli_stmt_fetch($stmt2)) {

		$sql3 = "SELECT COUNT(ora_ass) AS totassenze
				FROM (tab_assenze INNER JOIN tab_classialunni ON ID_alu_ass = ID_alu_cla)
				LEFT JOIN tab_orario ON data_ora = data_ass AND ora_ass = ora_ora AND classe_ora = classe_cla
				WHERE tipo_ass = 0  AND annoscolastico_cla = ? AND ID_alu_ass = ? AND codmat_ora = ?";
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		mysqli_stmt_bind_param($stmt3, "sis", $annoscolastico_cla, $ID_alu, $codmat_ora);
		mysqli_stmt_execute($stmt3);
		mysqli_stmt_bind_result($stmt3, $totassenze);
		while (mysqli_stmt_fetch($stmt3)) {}

		$spreadsheet->getActiveSheet()->SetCellValue("A".$riga, $classe_cla);
		$spreadsheet->getActiveSheet()->SetCellValue("B".$riga, $nome_alu);
		$spreadsheet->getActiveSheet()->SetCellValue("C".$riga, $cognome_alu);
		$spreadsheet->getActiveSheet()->SetCellValue("D".$riga, $codmat_ora);
		$spreadsheet->getActiveSheet()->SetCellValue("E".$riga, $descmateria_mtt);
		$spreadsheet->getActiveSheet()->SetCellValue("F".$riga, $orefatte);
		$spreadsheet->getActiveSheet()->SetCellValue("G".$riga, $totassenze);
		//$spreadsheet->getActiveSheet()->SetCellValue("H".$riga, $annoscolastico_cla);
		//$spreadsheet->getActiveSheet()->SetCellValue("I".$riga, $ID_alu);
		//$spreadsheet->getActiveSheet()->SetCellValue("J".$riga, $codmat_ora);
		$riga++;
	}
	
	$spreadsheet->getActiveSheet()->setAutoFilter('A1:G'.$riga);
	
	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
	exit;
?>











