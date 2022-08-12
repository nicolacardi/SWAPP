<?	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	include_once("database/databaseii.php");

	$annoscolastico_cla = $_GET['annoscolastico_cla'];
	$file_name = date('Ymd_h.i.s').'_Rette_'.$annoscolastico_cla.'.xlsx';
	$sql = "SELECT ID_alu_ret, nome_alu, cognome_alu, annoscolastico_ret, classe_cla, sezione_cla, mese_ret, default_ret, concordato_ret, pagato_ret 
	FROM ((tab_mensilirette LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_ret) 
	LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_ret = annoscolastico_cla) 
	WHERE annoscolastico_cla = ? AND listaattesa_cla = 0 
	ORDER BY classe_cla, sezione_cla, cognome_alu, nome_alu, ord_mese ;";


//questa estrae la quota contarin veronica quella sopra no
// $sql = "SELECT ID_alu_ret, nome_alu, cognome_alu, annoscolastico_ret, SUM(importo_pag) as totalePag, MONTH(data_pag), YEAR(data_pag)  
// 	FROM ((tab_pagamenti LEFT JOIN tab_mensilirette ON ID_ret = ID_ret_pag)
// 	LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_ret) 
// 	LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_ret = annoscolastico_cla 
// 	WHERE annoscolastico_cla = ? 
// 	AND (data_pag <> '0000-00-00' AND data_pag <> '1900-01-01') AND listaattesa_cla = 0 
// 	GROUP BY ID_ret, MONTH(data_pag), YEAR(data_pag)  
// 	ORDER BY cognome_alu, nome_alu, ord_mese ;";



	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu_ret, $nome_alu, $cognome_alu, $annoscolastico_ret, $classe_cla, $sezione_cla, $mese_ret, $default_ret, $concordato_ret, $pagato_ret);
	//$spreadsheet = new PHPExcel();
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExportRette.xlsx");


	for ($x = 0; $x <= 12; $x++) {
		$spreadsheet->setActiveSheetIndex($x); // Comincia da 0
		$spreadsheet->getActiveSheet()->SetCellValue("A1", $annoscolastico_cla);
	}

	$spreadsheet->setActiveSheetIndex(0); // Comincia da 0

	$record = 0; //riga equivale al numero del record che si sta guardando della SELECT di cui sopra
	$j = 4; //j è un numero che cresce di una unità ogni volta che scrivo un alunno-corrisponde al numero di riga di excel
	while (mysqli_stmt_fetch($stmt)) {
		$record++;
		switch (fmod($record-1, 12)) {
			case 0 :
				$j = $j+1;
				$spreadsheet->getActiveSheet()->SetCellValue("A".$j, $nome_alu);
				$spreadsheet->getActiveSheet()->SetCellValue("B".$j, $cognome_alu);
				$spreadsheet->getActiveSheet()->SetCellValue("C".$j, $classe_cla);
				$spreadsheet->getActiveSheet()->SetCellValue("D".$j, $sezione_cla);
				$spreadsheet->getActiveSheet()->SetCellValue("E".$j, $default_ret);
			break;
			case 1 :
				$spreadsheet->getActiveSheet()->SetCellValue("F".$j, $default_ret);
			break;
			case 2 :
				$spreadsheet->getActiveSheet()->SetCellValue("G".$j, $default_ret);
			break;
			case 3 :
				$spreadsheet->getActiveSheet()->SetCellValue("H".$j, $default_ret);
			break;
			case 4 :
				$spreadsheet->getActiveSheet()->SetCellValue("I".$j, $default_ret);
			break;
			case 5 :
				$spreadsheet->getActiveSheet()->SetCellValue("J".$j, $default_ret);
			break;
			case 6 :
				$spreadsheet->getActiveSheet()->SetCellValue("K".$j, $default_ret);
			break;
			case 7 :
				$spreadsheet->getActiveSheet()->SetCellValue("L".$j, $default_ret);
			break;
			case 8 :
				$spreadsheet->getActiveSheet()->SetCellValue("M".$j, $default_ret);
			break;
			case 9 :
				$spreadsheet->getActiveSheet()->SetCellValue("N".$j, $default_ret);
			break;
			case 10 :
				$spreadsheet->getActiveSheet()->SetCellValue("O".$j, $default_ret);
			break;
			case 11 :
				$spreadsheet->getActiveSheet()->SetCellValue("P".$j, $default_ret);
			break;
		}
	}
	//**********************************************    ORA LE QUOTE CONCORDATE

	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu_ret, $nome_alu, $cognome_alu, $annoscolastico_ret, $classe_cla, $sezione_cla, $mese_ret, $default_ret, $concordato_ret, $pagato_ret);
	//$spreadsheet = new PHPExcel();
	$spreadsheet->setActiveSheetIndex(1); // Comincia da 0
	$record = 0; //riga equivale al numero del record che si sta guardando della SELECT di cui sopra
	$j = 4; //j è un numero che cresce di una unità ogni volta che scrivo un alunno-corrisponde al numero di riga di excel
	while (mysqli_stmt_fetch($stmt)) {
		$record++;
	switch (fmod($record-1, 12)) {
		case 0 :
			$j = $j+1;
			$spreadsheet->getActiveSheet()->SetCellValue("A".$j, $nome_alu);
			$spreadsheet->getActiveSheet()->SetCellValue("B".$j, $cognome_alu);
			$spreadsheet->getActiveSheet()->SetCellValue("C".$j, $classe_cla);
			$spreadsheet->getActiveSheet()->SetCellValue("D".$j, $sezione_cla);
			$spreadsheet->getActiveSheet()->SetCellValue("E".$j, $concordato_ret);
		break;
		case 1 :
			$spreadsheet->getActiveSheet()->SetCellValue("F".$j, $concordato_ret);
		break;
		case 2 :
			$spreadsheet->getActiveSheet()->SetCellValue("G".$j, $concordato_ret);
		break;
		case 3 :
			$spreadsheet->getActiveSheet()->SetCellValue("H".$j, $concordato_ret);
		break;
		case 4 :
			$spreadsheet->getActiveSheet()->SetCellValue("I".$j, $concordato_ret);
		break;
		case 5 :
			$spreadsheet->getActiveSheet()->SetCellValue("J".$j, $concordato_ret);
		break;
		case 6 :
			$spreadsheet->getActiveSheet()->SetCellValue("K".$j, $concordato_ret);
		break;
		case 7 :
			$spreadsheet->getActiveSheet()->SetCellValue("L".$j, $concordato_ret);
		break;
		case 8 :
			$spreadsheet->getActiveSheet()->SetCellValue("M".$j, $concordato_ret);
		break;
		case 9 :
			$spreadsheet->getActiveSheet()->SetCellValue("N".$j, $concordato_ret);
		break;
		case 10 :
			$spreadsheet->getActiveSheet()->SetCellValue("O".$j, $concordato_ret);
		break;
		case 11 :
			$spreadsheet->getActiveSheet()->SetCellValue("P".$j, $concordato_ret);
		break;
		}
	}

	//**********************************************    ORA LE QUOTE PAGATE
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu_ret, $nome_alu, $cognome_alu, $annoscolastico_ret, $classe_cla, $sezione_cla, $mese_ret, $default_ret, $concordato_ret, $pagato_ret);
	//$spreadsheet = new PHPExcel();
	$spreadsheet->setActiveSheetIndex(2); // Comincia da 0
	$record = 0; //riga equivale al numero del record che si sta guardando della SELECT di cui sopra
	$j = 4; //j è un numero che cresce di una unità ogni volta che scrivo un alunno-corrisponde al numero di riga di excel
	while (mysqli_stmt_fetch($stmt)) {
		$record++;
		switch (fmod($record-1, 12)) {
			case 0 :
				$j = $j+1;
				$spreadsheet->getActiveSheet()->SetCellValue("A".$j, $nome_alu);
				$spreadsheet->getActiveSheet()->SetCellValue("B".$j, $cognome_alu);
				$spreadsheet->getActiveSheet()->SetCellValue("C".$j, $classe_cla);
				$spreadsheet->getActiveSheet()->SetCellValue("D".$j, $sezione_cla);
				$spreadsheet->getActiveSheet()->SetCellValue("E".$j, $pagato_ret);
				//$spreadsheet->getActiveSheet()->SetCellValue("S".$j, $pagato_pga);
			break;
			case 1 :
				$spreadsheet->getActiveSheet()->SetCellValue("F".$j, $pagato_ret);
			break;
			case 2 :
				$spreadsheet->getActiveSheet()->SetCellValue("G".$j, $pagato_ret);
			break;
			case 3 :
				$spreadsheet->getActiveSheet()->SetCellValue("H".$j, $pagato_ret);
			break;
			case 4 :
				$spreadsheet->getActiveSheet()->SetCellValue("I".$j, $pagato_ret);
			break;
			case 5 :
				$spreadsheet->getActiveSheet()->SetCellValue("J".$j, $pagato_ret);
			break;
			case 6 :
				$spreadsheet->getActiveSheet()->SetCellValue("K".$j, $pagato_ret);
			break;
			case 7 :
				$spreadsheet->getActiveSheet()->SetCellValue("L".$j, $pagato_ret);
			break;
			case 8 :
				$spreadsheet->getActiveSheet()->SetCellValue("M".$j, $pagato_ret);
			break;
			case 9 :
				$spreadsheet->getActiveSheet()->SetCellValue("N".$j, $pagato_ret);
			break;
			case 10 :
				$spreadsheet->getActiveSheet()->SetCellValue("O".$j, $pagato_ret);
			break;
			case 11 :
				$spreadsheet->getActiveSheet()->SetCellValue("P".$j, $pagato_ret);
			break;
		}
	}



	//ora il report FINANZIARIO: le quote devonon essere attribuite non a mese_ret ma a MONTH(datapagato_ret)
	$spreadsheet->setActiveSheetIndex(3); // Comincia da 0

	//$sql = "SELECT ID_alu_ret, nome_alu, cognome_alu, annoscolastico_ret, classe_cla, sezione_cla, pagato_ret, MONTH(datapagato_ret), YEAR(datapagato_ret)  FROM (tab_mensilirette LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_ret) LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_ret = annoscolastico_cla  WHERE annoscolastico_cla = ? AND (datapagato_ret <> '0000-00-00' AND datapagato_ret <> '1900-01-01' ) AND listaattesa_cla = 0 ORDER BY classe_cla, sezione_cla, cognome_alu, nome_alu, ord_mese ;";


	$sql = "SELECT ID_alu_ret, nome_alu, cognome_alu, annoscolastico_ret, SUM(importo_pag) as totalePag, MONTH(data_pag), YEAR(data_pag)  
	FROM ((tab_pagamenti LEFT JOIN tab_mensilirette ON ID_ret = ID_ret_pag)
	LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_ret) 
	LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_ret = annoscolastico_cla 
	WHERE annoscolastico_cla = ? 
	AND (data_pag <> '0000-00-00' AND data_pag <> '1900-01-01') AND listaattesa_cla = 0 
	GROUP BY ID_ret, MONTH(data_pag), YEAR(data_pag)  
	ORDER BY cognome_alu, nome_alu, ord_mese ;";

	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu_ret, $nome_alu, $cognome_alu, $annoscolastico_ret, $pagato_ret, $MONTHdatapagato_ret, $YEARpagato_ret);
	$SUMpagato_retA = array();
	$record = 0;
	while (mysqli_stmt_fetch($stmt)) {
		$record++;
		//inserisco le quote pagate in una matrice fatta così:
		//100 sia l'	ID_alu_ret
		//[102020]		MONTHdatapagato_ret.$YEARpagato_ret
		//SUMpagato_retA[100][102020] = quanto 100 ha pagato nel mese di ottobre 2020
		$SUMpagato_retA[$ID_alu_ret][$MONTHdatapagato_ret.$YEARpagato_ret] = $pagato_ret;
	}
	$colonnamese = array ("idle", "I", "J", "K", "L", "M", "N", "O", "P", "E", "F", "G", "H", "I", "Q");

	//ora estraggo l'elenco degli ID_alu, nome_alu, cognome_alu ecc. da scrivere e per ciascuno vado a ripescare la somma di quanto pagato in quel mese.
	$sql = "SELECT DISTINCT ID_alu_ret, nome_alu, cognome_alu, annoscolastico_ret, classe_cla, sezione_cla FROM (tab_mensilirette LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_ret) LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_ret = annoscolastico_cla WHERE annoscolastico_cla = ? AND listaattesa_cla = 0 ORDER BY classe_cla, sezione_cla, cognome_alu, nome_alu ;";

	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu_ret, $nome_alu, $cognome_alu, $annoscolastico_ret, $classe_cla, $sezione_cla);
	$j = 5;
	$anno1 = substr($annoscolastico_cla, 0, 4);
	$anno2 = "20".substr($annoscolastico_cla, 5, 2);
	//$ID_aluprec = '';
	while (mysqli_stmt_fetch($stmt)) {
		//if ($ID_alu_ret != $ID_aluprec) {
			$spreadsheet->getActiveSheet()->SetCellValue("A".$j, $nome_alu);
			$spreadsheet->getActiveSheet()->SetCellValue("B".$j, $cognome_alu);
			$spreadsheet->getActiveSheet()->SetCellValue("C".$j, $classe_cla);
			$spreadsheet->getActiveSheet()->SetCellValue("D".$j, $sezione_cla);
			for ($x = 1; $x <= 8; $x++) {
				$spreadsheet->getActiveSheet()->SetCellValue($colonnamese[$x].$j, $SUMpagato_retA[$ID_alu_ret][$x.$anno2]);
			}
			for ($x = 9; $x <= 12; $x++) {
				$spreadsheet->getActiveSheet()->SetCellValue($colonnamese[$x].$j, $SUMpagato_retA[$ID_alu_ret][$x.$anno1]);
			}
		
			$j++;
		//}
		//$ID_aluprec = $ID_alu_ret;
	}


	//ora il report SOSPESI RETTE
	$spreadsheet->setActiveSheetIndex(4); // Comincia da 0

	//ora estraggo tutti i sospesi: serve prima determinare la combinazione anno-mese corrente, perchè se sto estraendo per l'anno in corso non voglio che risulti moroso qualcuno che deve ancora pagare mesi successivi a quello corrente( cosa vuol dire ????)

	
	$sql = "SELECT ID_alu_ret, nome_alu, cognome_alu, annoscolastico_ret, classe_cla, sezione_cla, default_ret, concordato_ret, mese_ret, TotPagatoRette   
	FROM tab_mensilirette 
	
	LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_ret
	
	LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_ret = annoscolastico_cla 
	
	LEFT JOIN (SELECT ID_alu_pag, ID_ret_pag, annoscolastico_pag , SUM(importo_pag) as TotPagatoRette FROM tab_pagamenti WHERE causale_pag = 1 GROUP BY ID_ret_pag, ID_alu_pag, annoscolastico_pag) AS rettepag ON rettepag.ID_alu_pag = ID_alu AND rettepag.annoscolastico_pag = annoscolastico_ret AND rettepag.ID_ret_pag = ID_ret

	WHERE annoscolastico_cla = ?  AND listaattesa_cla = 0 ORDER BY classe_cla, sezione_cla, cognome_alu, nome_alu, ord_mese ;";


	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu_ret, $nome_alu, $cognome_alu, $annoscolastico_ret, $classe_cla, $sezione_cla, $default_ret, $concordato_ret,  $mese_ret, $TotPagatoRette); 
	$j = 5;
	while (mysqli_stmt_fetch($stmt)) {
		$spreadsheet->getActiveSheet()->SetCellValue("A".$j, $nome_alu);
		$spreadsheet->getActiveSheet()->SetCellValue("B".$j, $cognome_alu);
		$spreadsheet->getActiveSheet()->SetCellValue("C".$j, $nome_alu." ".$cognome_alu);
		$spreadsheet->getActiveSheet()->SetCellValue("D".$j, $classe_cla);
		$spreadsheet->getActiveSheet()->SetCellValue("E".$j, $sezione_cla);
		$spreadsheet->getActiveSheet()->SetCellValue("F".$j, $default_ret);
		$spreadsheet->getActiveSheet()->SetCellValue("G".$j, $concordato_ret);
		$spreadsheet->getActiveSheet()->SetCellValue("H".$j, $TotPagatoRette);
		$spreadsheet->getActiveSheet()->SetCellValue("I".$j, $concordato_ret - $TotPagatoRette);
		$spreadsheet->getActiveSheet()->SetCellValue("J".$j, $mese_ret);
		$spreadsheet->getActiveSheet()->SetCellValue("K".$j, $annoscolastico_ret);
		$j++;
	}

	//ora il report SOSPESI RETTE TOTALI ANNUI
	$spreadsheet->setActiveSheetIndex(5); // Comincia da 0

	//ora estraggo tutti i sospesi: serve prima determinare la combinazione anno-mese corrente, perchè se sto estraendo per l'anno in corso non voglio che risulti moroso qualcuno che deve ancora pagare mesi successivi a quello corrente( cosa vuol dire ????)

	
	$sql = "SELECT ID_alu_ret, nome_alu, cognome_alu, classe_cla, sezione_cla, annoscolastico_ret, SUM(concordato_ret), SUM(pagato_ret)

	FROM tab_mensilirette
		LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_ret
		LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_ret = annoscolastico_cla 
	
	GROUP BY annoscolastico_ret, ID_alu_ret, classe_cla, sezione_cla
	
	ORDER BY cognome_alu, nome_alu, annoscolastico_ret ;";


	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu_ret, $nome_alu, $cognome_alu, $classe_cla, $sezione_cla, $annoscolastico_ret, $TotConcordato,  $TotPagato); 
	$j = 5;
	while (mysqli_stmt_fetch($stmt)) {
		$nomecognome_alu = $nome_alu." ".$cognome_alu;
		if ($nomecognome_alu <> $nomecognome_aluPrec) {
			// $spreadsheet->getActiveSheet()->getStyle("A".$j)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THICK)->setColor(new Color('FFFF0000'));
			$spreadsheet->getActiveSheet()->getStyle("A".$j.":I".$j)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		}
		$spreadsheet->getActiveSheet()->SetCellValue("A".$j, $nome_alu);
		$spreadsheet->getActiveSheet()->SetCellValue("B".$j, $cognome_alu);
		$spreadsheet->getActiveSheet()->SetCellValue("C".$j, $nomecognome_alu);
		$spreadsheet->getActiveSheet()->SetCellValue("D".$j, $classe_cla);
		$spreadsheet->getActiveSheet()->SetCellValue("E".$j, $sezione_cla);
		$spreadsheet->getActiveSheet()->SetCellValue("F".$j, $TotConcordato);
		$spreadsheet->getActiveSheet()->SetCellValue("G".$j, $TotPagato);
		$spreadsheet->getActiveSheet()->SetCellValue("H".$j, $TotConcordato - $TotPagato);
		$spreadsheet->getActiveSheet()->SetCellValue("I".$j, $annoscolastico_ret);
		$j++;
		$nomecognome_aluPrec = $nomecognome_alu;
	}










	include_once("04inc_GetCausaliPagamento.php");
	//$causali_pagA = ["non rilevato", "retta", "iscrizione", "donazione", "spese didattiche", "quota associativa", "cauzione"];
	$tipi_pagA = ["non rilevato", "bonifico", "contante", "carta di credito", "altro"];
	$soggetto_pagA = ["non rilevato", "padre", "madre", "altro"];
	$rigaA = [ 5, 5, 5, 5, 5];

	



	//Sospesi Iscrizioni
	$spreadsheet->setActiveSheetIndex(6);
	$sql = "SELECT ID_alu, nome_alu, cognome_alu, totaliPag.importo_tot, classe_cla, sezione_cla 
	
	FROM tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_cla = ?

	LEFT JOIN 
	(SELECT ID_alu_pag, causale_pag, SUM(importo_pag) as importo_tot FROM tab_pagamenti WHERE annoscolastico_pag = ? AND causale_pag = 2 GROUP BY ID_alu_pag, causale_pag) AS totaliPag ON totaliPag.ID_alu_pag = tab_anagraficaalunni.ID_alu 
	
	WHERE listaattesa_cla = 0 ORDER BY classe_cla, sezione_cla, cognome_alu, nome_alu ";


	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ss", $annoscolastico_cla, $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu, $nome_alu, $cognome_alu, $importoTot, $classe_cla, $sezione_cla); 
	$riga = 5;
	$quotezero = 0;
	while (mysqli_stmt_fetch($stmt)) {

		$spreadsheet->getActiveSheet()->SetCellValue("A".$riga, $nome_alu);
		$spreadsheet->getActiveSheet()->SetCellValue("B".$riga, $cognome_alu);
		$spreadsheet->getActiveSheet()->SetCellValue("C".$riga, $classe_cla);
		$spreadsheet->getActiveSheet()->SetCellValue("D".$riga, $sezione_cla);
		$spreadsheet->getActiveSheet()->SetCellValue("E".$riga, $importoTot);
		if ($importoTot == null) {$quotezero++;}
		$riga = $riga + 1;
	}
	$spreadsheet->getActiveSheet()->SetCellValue("E2", (($riga-4)-$quotezero)."/".($riga-4));
	//Sospesi Quota Associativa
	$spreadsheet->setActiveSheetIndex(7);
	$sql = "SELECT ID_alu, nome_alu, cognome_alu, totaliPag.importo_tot, classe_cla, sezione_cla 
	
	FROM tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_cla = ?

	LEFT JOIN 
	(SELECT ID_alu_pag, causale_pag, SUM(importo_pag) as importo_tot FROM tab_pagamenti WHERE annoscolastico_pag = ? AND causale_pag = 5 GROUP BY ID_alu_pag, causale_pag) AS totaliPag ON totaliPag.ID_alu_pag = tab_anagraficaalunni.ID_alu 
	
	WHERE listaattesa_cla = 0 ORDER BY classe_cla, sezione_cla, cognome_alu, nome_alu ";


	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ss", $annoscolastico_cla, $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu, $nome_alu, $cognome_alu, $importoTot, $classe_cla, $sezione_cla); 
	$riga = 5;
	while (mysqli_stmt_fetch($stmt)) {

		$spreadsheet->getActiveSheet()->SetCellValue("A".$riga, $nome_alu);
		$spreadsheet->getActiveSheet()->SetCellValue("B".$riga, $cognome_alu);
		$spreadsheet->getActiveSheet()->SetCellValue("C".$riga, $classe_cla);
		$spreadsheet->getActiveSheet()->SetCellValue("D".$riga, $sezione_cla);
		$spreadsheet->getActiveSheet()->SetCellValue("E".$riga, $importoTot);
		$riga = $riga + 1;
	}

	//Sospesi Spese Didattiche
	$spreadsheet->setActiveSheetIndex(8);
	$sql = "SELECT ID_alu, nome_alu, cognome_alu, totaliPag.importo_tot, classe_cla, sezione_cla 
	
	FROM tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_cla = ?

	LEFT JOIN 
	(SELECT ID_alu_pag, causale_pag, SUM(importo_pag) as importo_tot FROM tab_pagamenti WHERE annoscolastico_pag = ? AND causale_pag = 4 GROUP BY ID_alu_pag, causale_pag) AS totaliPag ON totaliPag.ID_alu_pag = tab_anagraficaalunni.ID_alu 
	
	WHERE listaattesa_cla = 0 ORDER BY classe_cla, sezione_cla, cognome_alu, nome_alu ";


	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ss", $annoscolastico_cla, $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu, $nome_alu, $cognome_alu, $importoTot, $classe_cla, $sezione_cla); 
	$riga = 5;
	while (mysqli_stmt_fetch($stmt)) {

		$spreadsheet->getActiveSheet()->SetCellValue("A".$riga, $nome_alu);
		$spreadsheet->getActiveSheet()->SetCellValue("B".$riga, $cognome_alu);
		$spreadsheet->getActiveSheet()->SetCellValue("C".$riga, $classe_cla);
		$spreadsheet->getActiveSheet()->SetCellValue("D".$riga, $sezione_cla);
		$spreadsheet->getActiveSheet()->SetCellValue("E".$riga, $importoTot);
		$riga = $riga + 1;
	}



	//ora i vari report PAGAMENTI, uno per causale

	$sql = "SELECT nome_alu, cognome_alu, ID_pag, data_pag, importo_pag, causale_pag, tipo_pag, soggetto_pag, annoscolastico_pag, classe_cla, sezione_cla
	FROM tab_pagamenti	LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_pag
	LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_pag = annoscolastico_cla 
	WHERE annoscolastico_cla = ?  AND listaattesa_cla = 0 AND causale_pag <> 1 ORDER BY classe_cla, sezione_cla, cognome_alu, nome_alu, data_pag ;";


	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $nome_alu, $cognome_alu, $ID_pag, $data_pag, $importo_pag, $causale_pag, $tipo_pag, $soggetto_pag, $annoscolastico_pag, $classe_cla, $sezione_cla); 

	while (mysqli_stmt_fetch($stmt)) {
		//a seconda di causale_pag vado a scrivere in un foglio o in un altro
		//c'è un counter per ogni foglio (e per ogni tipo di causale, dunque)
		if ($n>1) {
			$n = $causale_pag - 2;
			$spreadsheet->setActiveSheetIndex($causale_pag+7); // Comincia da 0


			$spreadsheet->getActiveSheet()->SetCellValue("A".$rigaA[$n], $nome_alu);
			$spreadsheet->getActiveSheet()->SetCellValue("B".$rigaA[$n], $cognome_alu);
			$spreadsheet->getActiveSheet()->SetCellValue("C".$rigaA[$n], $classe_cla);
			$spreadsheet->getActiveSheet()->SetCellValue("D".$rigaA[$n], $sezione_cla);
			$spreadsheet->getActiveSheet()->SetCellValue("E".$rigaA[$n], $data_pag);
			$spreadsheet->getActiveSheet()->SetCellValue("F".$rigaA[$n], $importo_pag);
			$spreadsheet->getActiveSheet()->SetCellValue("G".$rigaA[$n], $tipi_pagA[$tipo_pag]);
			$spreadsheet->getActiveSheet()->SetCellValue("H".$rigaA[$n], $soggetto_pagA[$soggetto_pag]);
			$spreadsheet->getActiveSheet()->SetCellValue("I".$rigaA[$n], $causali_pagA[$causale_pag]);
			$rigaA[$n] = $rigaA[$n] + 1;
		}
	}


	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
?>