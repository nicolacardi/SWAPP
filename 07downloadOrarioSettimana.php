<?	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	include_once("database/databaseii.php");
	

	$file_name = date('Ymd_h.i.s').'_OrarioSettimana_dal_'.$datefrom.'_al_'.$dateto.'.xlsx';
	$ore_orario = intval($_SESSION['ore_orario']);
	$datefrom = $_GET['datefrom'];
	$dateto = $_GET['dateto'];


	$sql = "SELECT ID_ore, orainizio_ore, orafine_ore, desc_ore FROM tab_ore ORDER BY N_ore";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ore, $orainizio_ore, $orafine_ore, $desc_ore);
	$orariA = array("idle");
	$desc_oreA= array("idle");
	
	while (mysqli_stmt_fetch($stmt)) {
		$orainizio_ore = substr($orainizio_ore, 0, strlen($orainizio_ore)-3);
		$orafine_ore = substr($orafine_ore, 0, strlen($orafine_ore)-3);
		array_push($orariA, $orainizio_ore."-".$orafine_ore) ;
		array_push($desc_oreA, $desc_ore);
	}


	//scrivo un foglio per ogni classe
	$sql = "SELECT ID_ora, data_ora, ora_ora, codmat_ora, classe_ora, sezione_ora, ID_mae_ora, firma_mae_ora, assente_ora, supplente_ora, datafirma_ora, argomento_ora, compitiassegnati_ora, ".
	" CONCAT (nome_mae , ' ', cognome_mae) as nomecognome_mae, descmateria_mtt, ID_mtt ".
	" FROM (tab_orario LEFT JOIN tab_anagraficamaestri ON ID_mae_ora = ID_mae) ".
	" LEFT JOIN tab_materie ON codmat_ora = codmat_mtt ".
	" WHERE data_ora BETWEEN ? AND ? ORDER BY classe_ora, data_ora, ora_ora, ID_ora";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ss", $datefrom, $dateto);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ora, $data_ora, $ora_ora, $codmat_ora, $classe_ora, $sezione_ora, $ID_mae_ora, $firma_mae_ora, $assente_ora, $supplente_ora, $datafirma_ora, $argomento_ora, $compitiassegnati_ora, $nomecognome_mae, $descmateria_mtt, $ID_mtt); 
	$colonna = ["idle", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB"];
	$objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateOrarioSettimana.xlsx");
	$classe_ora_prec = "X";
	$data_ora_prec = "1999-01-01";
	while (mysqli_stmt_fetch($stmt)) {
		if ($ora_ora != $ora_ora_prec) { 
			//questo if serve perchè se ci sono ore doppie (con due maestri o tutor) queste hanno ora_ora = a ora_ora_prec
			//in qs caso devo estrarre solo il PRIMO, che si presume sia il primo che è stato inserito, quindi con l'ID_ora più piccolo
			//infatti la query ordina alla fine per ID_ora)
			if ($classe_ora != $classe_ora_prec) {
				$objPHPExcel-> setActiveSheetIndexByName($classe_ora.$sezione_ora);
				$colonna_indice = 4;
				for ($x = 1; $x <= $ore_orario; $x++) {
					$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colonna_indice].(2*$x+4-1), $orariA[$x]);
				}
			}
			if ($data_ora != $data_ora_prec) { $colonna_indice++;}
			if ($data_ora != $data_ora_prec) { $objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colonna_indice]."4", $data_ora);}
			$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colonna_indice].(2*$ora_ora+4), $descmateria_mtt);
			$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colonna_indice].(2*$ora_ora+4-1), $nomecognome_mae);
			$classe_ora_prec = $classe_ora;
			$data_ora_prec = $data_ora;
			$ora_ora_prec = $ora_ora;
		}
	}



	$sql = "SELECT ID_ora, data_ora, ora_ora, codmat_ora, classe_ora, sezione_ora, ID_mae_ora, firma_mae_ora, assente_ora, supplente_ora, datafirma_ora, argomento_ora, compitiassegnati_ora, ".
	" CONCAT (nome_mae , ' ', cognome_mae) as nomecognome_mae, descmateria_mtt, ID_mtt ".
	" FROM (tab_orario LEFT JOIN tab_anagraficamaestri ON ID_mae_ora = ID_mae) ".
	" LEFT JOIN tab_materie ON codmat_ora = codmat_mtt ".
	" WHERE data_ora BETWEEN ? AND ? ORDER BY nomecognome_mae, data_ora, ora_ora";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ss", $datefrom, $dateto);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ora, $data_ora, $ora_ora, $codmat_ora, $classe_ora, $sezione_ora, $ID_mae_ora, $firma_mae_ora, $assente_ora, $supplente_ora, $datafirma_ora, $argomento_ora, $compitiassegnati_ora, $nomecognome_mae, $descmateria_mtt, $ID_mtt); 
	$nomecognome_mae = preg_replace('/[^A-Za-z0-9\-]/', '', $nomecognome_mae); 
	$nomecognome_mae_prec = "X";
	$data_ora = "1999-01-01";
	$newsheet = 14; //IMPORTANTE! QUESTO E' IL NUMERO DEL FOGLIO XX (BASE 1) CHE DEVE ESSERE POSIZIONATO NEL TEMPLATE COME ULTIMO FOGLIO
	$j=5;
	//$objPHPExcel->createSheet($newsheet);
	while (mysqli_stmt_fetch($stmt)) {
		if (($nomecognome_mae !='') && ($nomecognome_mae != null)) {
			if ($nomecognome_mae != $nomecognome_mae_prec) {
				$clonedWorksheet = clone $objPHPExcel->getSheetByName('XX');
				$clonedWorksheet->setTitle($nomecognome_mae);
				$objPHPExcel->addSheet($clonedWorksheet);
				$objPHPExcel->setActiveSheetIndex($newsheet);
				$objPHPExcel->getActiveSheet()->SetCellValue("E2", $nomecognome_mae);
				$colonna_indice = 4;
				for ($x = 1; $x <= $ore_orario; $x++) {
					$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colonna_indice].(2*$x+4-1), $orariA[$x]);
				}
				$newsheet++;
			}
			if ($data_ora != $data_ora_prec) { $colonna_indice++;}
			if ($data_ora != $data_ora_prec) { $objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colonna_indice]."4", $data_ora);}
			$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colonna_indice].(2*$ora_ora+4), $classe_ora);
			$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$colonna_indice].(2*$ora_ora+4-1), $descmateria_mtt);
			$nomecognome_mae_prec = $nomecognome_mae;
			$data_ora_prec = $data_ora;
		}
	}

	$sql = "SELECT ID_ora, epoca_ora, data_ora, ora_ora, codmat_ora, classe_ora, sezione_ora, ID_mae_ora, firma_mae_ora, assente_ora, supplente_ora, datafirma_ora, argomento_ora, compitiassegnati_ora, ".
	" CONCAT (nome_mae , ' ', cognome_mae) as nomecognome_mae, descmateria_mtt, ID_mtt ".
	" FROM ((tab_orario LEFT JOIN tab_anagraficamaestri ON ID_mae_ora = ID_mae) ".
	" LEFT JOIN tab_materie ON codmat_ora = codmat_mtt) ".
	" LEFT JOIN tab_classi ON classe_ora = classe_cls ".
	" WHERE data_ora BETWEEN ? AND ? ORDER BY ord_cls, classe_ora, data_ora, ora_ora, ID_ora";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ss", $datefrom, $dateto);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ora, $epoca_ora, $data_ora, $ora_ora, $codmat_ora, $classe_ora, $sezione_ora, $ID_mae_ora, $firma_mae_ora, $assente_ora, $supplente_ora, $datafirma_ora, $argomento_ora, $compitiassegnati_ora, $nomecognome_mae, $descmateria_mtt, $ID_mtt); 
	$colonna = ["idle", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB"];
	//$classe_ora_prec = "X";
	//$data_ora_prec = "1999-01-01";
	$objPHPExcel-> setActiveSheetIndexByName("I-VIII");
	$riga = 5;
	while (mysqli_stmt_fetch($stmt)) {
		if ($ora_ora != $ora_ora_prec) { //scrivo solo la prima ora_ora che trovo, per ignorare i tutoraggi o le classi divise in due
			
			//la colonna dove scrivo dipende dall'ora-> $colonna[$ora_ora+5]
			//la riga va da 5 a xx e cambia ogni tot record
			for ($x = 1; $x <= $ore_orario; $x++) {
				$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x+5].(4), $orariA[$x]);
			}
			if (fmod($riga-5, 10)==0) { $objPHPExcel->getActiveSheet()->SetCellValue("D".$riga, $classe_ora."-".$sezione_ora); } //ogni 10 righe devo scrivere la classe in cella "D".$riga
			//if ($ora_ora == 1 || $ora_ora ==2) { $descmateria_mtt = "EPOCA";}
			if ($epoca_ora == 1) {
				$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$ora_ora + 5].$riga, "EPOCA");
			} else {
				$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$ora_ora + 5].$riga, $descmateria_mtt);
			}
			$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$ora_ora + 5].($riga+1), $nomecognome_mae);
			if ($ora_ora==$ore_orario) {$riga= $riga +2;}
			//$classe_ora_prec = $classe_ora;
			//$data_ora_prec = $data_ora;
		}
		$ora_ora_prec = $ora_ora;
	}


	


	$writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
	//header('Location: 07OrarioNew.php');
	exit();
?>