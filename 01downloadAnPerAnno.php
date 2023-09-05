<?	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExportAnagraficaPerAnno.xlsx");
	include_once("database/databaseii.php");

	$annoscolastico_cla = $_GET['annoscolastico_cla'];
	$where = $_GET['where'];
	$file_name = date('Ymd_h.i.s').'_AnagraficaPerAnno_'.$annoscolastico_cla;

	//per aggiungere un campo per gli alunni
	//1. aumentare la numerosità dell'array
	//2. inserire il campo nell'elenco della select
	//3. inserirlo in mysqli_stmt_bind_result
	//4. aumentare il ciclo -> for ($x = 1; $x <= 72; $x++)
	//4. qualora siano cambiati modificare i tre indici->  if ($x == 10 ||$x == 49 || $x == 61)
	//5. aggiungere  un elemento all'array $colonna
	//6. modificare il template excel

	//4b. lo stesso per i campi di tab_famiglia con la differenza che da modificare potrebbe essere-> if ($x == 14 ||$x == 26)

	$campo =  array(76);

	//per foglio alunni
	// $sql = "SELECT DISTINCT nome_alu, cognome_alu, indirizzo_alu, citta_alu, CAP_alu, prov_alu, paese_alu, cf_alu, mf_alu, datanascita_alu, comunenascita_alu, provnascita_alu, paesenascita_alu, cittadinanza_alu, note_alu, scuolaprovenienza_alu, indirizzoscproven_alu, ckprivacy1_alu, ckprivacy2_alu, ckprivacy3_alu, ckautfoto_alu, ckautmateriale_alu, ckautuscite_alu, ckautuscitaautonoma_alu, ckdoposcuola_alu, ckreligione_alu, ckmensa_alu, cktrasportopubblico_alu, 
	// classe_cla, sezione_cla, aselme_cla, listaattesa_cla, ritirato_cla, scalino_cla, tiposcuolasucc_alu, sottotiposcuolasucc_alu, nomescuolasucc_alu, votoesamiVIII_alu, 
	// cognome_fam, nomemadre_fam, cognomemadre_fam, nomepadre_fam, cognomepadre_fam, telefonomadre_fam, altrotelmadre_fam, telefonopadre_fam, altrotelpadre_fam, emailmadre_fam, emailpadre_fam, sociomadre_fam, sociopadre_fam, 
	// datanascitamadre_fam, comunenascitamadre_fam, provnascitamadre_fam, paesenascitamadre_fam, cfmadre_fam, indirizzomadre_fam, comunemadre_fam, CAPmadre_fam, provmadre_fam, paesemadre_fam, titolomadre_fam, profmadre_fam, 
	// datanascitapadre_fam, comunenascitapadre_fam, provnascitapadre_fam, paesenascitapadre_fam, cfpadre_fam, indirizzopadre_fam, comunepadre_fam, CAPpadre_fam, provpadre_fam, paesepadre_fam, titolopadre_fam, profpadre_fam  
	// FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) 

	
	// LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE annoscolastico_cla = ? ".$where." ORDER BY classe_cla ASC, cognome_alu ";

	//con aggiunta classe anno precedente
	$sql = "SELECT DISTINCT nome_alu, cognome_alu, indirizzo_alu, citta_alu, CAP_alu, prov_alu, paese_alu, cf_alu, mf_alu, datanascita_alu, comunenascita_alu, provnascita_alu, paesenascita_alu, cittadinanza_alu, note_alu, scuolaprovenienza_alu, indirizzoscproven_alu, ckprivacy1_alu, ckprivacy2_alu, ckprivacy3_alu, ckautfoto_alu, ckautmateriale_alu, ckautuscite_alu, ckautuscitaautonoma_alu, ckdoposcuola_alu, ckreligione_alu, ckmensa_alu, cktrasportopubblico_alu, 
	tab_classialunni.classe_cla, tab_classialunni.sezione_cla, tab_classialunni.aselme_cla, tab_classialunni.listaattesa_cla, tab_classialunni.ritirato_cla, tab_classialunni.scalino_cla, 
	tab_classialunniprec.classe_cla,
	tiposcuolasucc_alu, sottotiposcuolasucc_alu, nomescuolasucc_alu, votoesamiVIII_alu, 
	cognome_fam, nomemadre_fam, cognomemadre_fam, nomepadre_fam, cognomepadre_fam, telefonomadre_fam, altrotelmadre_fam, telefonopadre_fam, altrotelpadre_fam, emailmadre_fam, emailpadre_fam, sociomadre_fam, sociopadre_fam, 
	datanascitamadre_fam, comunenascitamadre_fam, provnascitamadre_fam, paesenascitamadre_fam, cfmadre_fam, indirizzomadre_fam, comunemadre_fam, CAPmadre_fam, provmadre_fam, paesemadre_fam, titolomadre_fam, profmadre_fam, 
	datanascitapadre_fam, comunenascitapadre_fam, provnascitapadre_fam, paesenascitapadre_fam, cfpadre_fam, indirizzopadre_fam, comunepadre_fam, CAPpadre_fam, provpadre_fam, paesepadre_fam, titolopadre_fam, profpadre_fam  
	FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) 

	LEFT JOIN tab_anniscolastici ON annoscolastico_cla = annoscolastico_asc
	LEFT JOIN tab_classialunni AS tab_classialunniprec ON tab_classialunniprec.annoscolastico_cla = annoscolasticoprec_asc AND ID_alu = tab_classialunniprec.ID_alu_cla

	LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE tab_classialunni.annoscolastico_cla = ? ".$where." ORDER BY tab_classialunni.classe_cla ASC, cognome_alu ";




	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5], $campo[6], $campo[7], $campo[8], $campo[9], $campo[10], $campo[11], $campo[12], $campo[13], $campo[14], $campo[15], $campo[16], $campo[17], $campo[18], $campo[19], $campo[20], $campo[21], $campo[22], $campo[23], $campo[24], $campo[25], $campo[26], $campo[27], $campo[28], $campo[29], $campo[30], $campo[31], $campo[32], $campo[33], $campo[34], $campo[35], $campo[36], $campo[37], $campo[38], $campo[39], $campo[40], $campo[41], $campo[42], $campo[43], $campo[44], $campo[45], $campo[46], $campo[47], $campo[48], $campo[49], $campo[50], $campo[51], $campo[52], $campo[53], $campo[54], $campo[55], $campo[56], $campo[57], $campo[58], $campo[59], $campo[60], $campo[61], $campo[62], $campo[63], $campo[64], $campo[65], $campo[66], $campo[67], $campo[68], $campo[69], $campo[70], $campo[71], $campo[72], $campo[73], $campo[74], $campo[75], $campo[76]); 
	$colonna = ["idle", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR", "BS", "BT", "BU", "BV", "BW", "BX", "BY", "BZ", "CA", "CB", "CC", "CD", "CE"];


	$spreadsheet->setActiveSheetIndex(0); // Comincia da 0
	$spreadsheet->getActiveSheet()->SetCellValue("A1", $annoscolastico_cla);
	$j = 5; //j è un numero che cresce di una unità ogni volta che scrivo un alunno-corrisponde al numero di riga di excel
	$date1=date_create("1900-01-01");
	while (mysqli_stmt_fetch($stmt)) { 
		//10,53,65 sono gli indici dei campi data
		$j++;
		$spreadsheet->getActiveSheet()->SetCellValue("A".$j, $j-4 );
		for ($x = 1; $x <= 75; $x++) {
			if ($campo[32] == 1) { //in campo 31 c'è lista d'attesa ma estraggo anche listaattesa come campo singolo
				$spreadsheet->getActiveSheet()->getStyle($colonna[$x].$j)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
				$spreadsheet->getActiveSheet()->getStyle($colonna[$x].$j)->getFill()->getStartColor()->setARGB('FFACACAC');
			}
			if ($campo[33] == 1) { //in campo 31 c'è ritirato ma estraggo anche ritirato come campo singolo
				$spreadsheet->getActiveSheet()->getStyle($colonna[$x].$j)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
				$spreadsheet->getActiveSheet()->getStyle($colonna[$x].$j)->getFill()->getStartColor()->setARGB('FFFFC000');
			}

			if ($x == 10 ||$x == 53 || $x == 65) {
				$date2=date_create($campo[$x]);
				$diff=date_diff($date1,$date2);
				$days=$diff->format("%a");
				$days+=2; // add boundary days
				$spreadsheet->getActiveSheet()->setCellValue($colonna[$x].$j,$days); 
			} else {
				$spreadsheet->getActiveSheet()->SetCellValue($colonna[$x].$j, $campo[$x] );
			}
		}
	}

	//per foglio famiglie
	$sql = "SELECT DISTINCT 
	cognome_fam, nomemadre_fam, cognomemadre_fam, nomepadre_fam, cognomepadre_fam, telefonomadre_fam, altrotelmadre_fam, telefonopadre_fam, altrotelpadre_fam, emailmadre_fam, emailpadre_fam, sociomadre_fam, sociopadre_fam, 
	datanascitamadre_fam, comunenascitamadre_fam, provnascitamadre_fam, paesenascitamadre_fam, cfmadre_fam, indirizzomadre_fam, comunemadre_fam, CAPmadre_fam, provmadre_fam, paesemadre_fam, titolomadre_fam, profmadre_fam, 
	datanascitapadre_fam, comunenascitapadre_fam, provnascitapadre_fam, paesenascitapadre_fam, cfpadre_fam, indirizzopadre_fam, comunepadre_fam, CAPpadre_fam, provpadre_fam, paesepadre_fam, titolopadre_fam, profpadre_fam, ckcarpoolingmadre_fam, ckcarpoolingpadre_fam, pulizie_fam, modalitapag_fam, richcolloquio_fam, intestazionefatt_fam
	FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) 
	LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE annoscolastico_cla = ? ".$where."ORDER BY cognome_fam";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5], $campo[6], $campo[7], $campo[8], $campo[9], $campo[10], $campo[11], $campo[12], $campo[13], $campo[14], $campo[15], $campo[16], $campo[17], $campo[18], $campo[19], $campo[20], $campo[21], $campo[22], $campo[23], $campo[24], $campo[25], $campo[26], $campo[27], $campo[28], $campo[29], $campo[30], $campo[31], $campo[32], $campo[33], $campo[34], $campo[35], $campo[36], $campo[37], $campo[38], $campo[39], $campo[40], $campo[41], $campo[42], $campo[43]); 
	// $colonna = ["idle", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR"];

	$spreadsheet->setActiveSheetIndex(1); // Comincia da 0
	$spreadsheet->getActiveSheet()->SetCellValue("A1", $annoscolastico_cla);
	
	$j = 5; //j è un numero che cresce di una unità ogni volta che scrivo una famiglia-corrisponde al numero di riga di excel
	while (mysqli_stmt_fetch($stmt)) { 
		//14 e 26 sono gli indici dei campi data
		$j++;
		$spreadsheet->getActiveSheet()->SetCellValue("A".$j, $j-5 );
		for ($x = 1; $x <= 43; $x++) {
			// if ($campo[40] == 1) { //in campo 40 c'è lista d'attesa: non ha senso: è un campo dei figli: se si ritira un solo figlio?? la distinct restituisce un record per ogni figlio, a quel punto...
			// 	$spreadsheet->getActiveSheet()->getStyle($colonna[$x].$j)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
			// 	$spreadsheet->getActiveSheet()->getStyle($colonna[$x].$j)->getFill()->getStartColor()->setARGB('FFACACAC');
			// }
			if ($x == 14 ||$x == 26) {
				$date2=date_create($campo[$x]);
				$diff=date_diff($date1,$date2);
				$days=$diff->format("%a");
				$days+=2; // add boundary days
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