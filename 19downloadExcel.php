<?
	include_once("database/databaseii.php");
	$annoscolastico_cla = $_GET['annoscolastico_cla'];
	$file_name = date('Ymd_h.i.s').'_StatusIscrizioni_'.$annoscolastico_cla;
	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	$objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExportStatusIscrizioni.xlsx");

	$campo =  array(63);
	$sql = "SELECT DISTINCT nome_alu, cognome_alu, indirizzo_alu, citta_alu, CAP_alu, prov_alu, paese_alu, cf_alu, mf_alu, datanascita_alu, comunenascita_alu, provnascita_alu, paesenascita_alu, note_alu, scuolaprovenienza_alu, indirizzoscproven_alu, ckprivacy1_alu, ckprivacy2_alu, ckprivacy3_alu, ckautfoto_alu, ckautmateriale_alu, ckautuscite_alu, ". //campi tab_anagraficaalunni
	"classe_cla, sezione_cla, aselme_cla, listaattesa_cla, ". //campi tab_classialunni
	"cognome_fam, nomemadre_fam, cognomemadre_fam, nomepadre_fam, cognomepadre_fam, telefonomadre_fam, altrotelmadre_fam, telefonopadre_fam, altrotelpadre_fam, emailmadre_fam, emailpadre_fam, sociomadre_fam, sociopadre_fam, ".
	"datanascitamadre_fam, comunenascitamadre_fam, provnascitamadre_fam, paesenascitamadre_fam, cfmadre_fam, indirizzomadre_fam, comunemadre_fam, CAPmadre_fam, provmadre_fam, paesemadre_fam, titolomadre_fam, profmadre_fam, ".
	"datanascitapadre_fam, comunenascitapadre_fam, provnascitapadre_fam, paesenascitapadre_fam, cfpadre_fam, indirizzopadre_fam, comunepadre_fam, CAPpadre_fam, provpadre_fam, paesepadre_fam, titolopadre_fam, profpadre_fam, mailinviate_fam, loginusata_fam, datirecuperati_fam, iscrizionecompleta_fam, iscrizioneinviata_fam, ". //campi di tab_famiglie
	"altripag.TotIscrizione ". //Totali Iscrizione
	"FROM ((".$_SESSION['databaseB'].".tab_anagraficaalunni LEFT JOIN ".$_SESSION['databaseB'].".tab_classialunni ON ID_alu = ID_alu_cla) ".
	"LEFT JOIN ".$_SESSION['databaseB'].".tab_famiglie ON ID_fam_alu = ID_fam) " . 


	"LEFT JOIN ( SELECT ID_alu_pag, annoscolastico_pag , SUM(importo_pag) as TotIscrizione FROM ".$_SESSION['databaseA'].".tab_pagamenti WHERE causale_pag = 2 GROUP BY ID_alu_pag, annoscolastico_pag ) AS altripag ON altripag.ID_alu_pag = ID_alu_cla AND altripag.annoscolastico_pag = ".$_SESSION['databaseB'].".tab_classialunni.annoscolastico_cla ". //per totali Iscrizione
	"WHERE annoscolastico_cla = ? ORDER BY classe_cla ASC, cognome_alu";


	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5], $campo[6], $campo[7], $campo[8], $campo[9], $campo[10], $campo[11], $campo[12], $campo[13], $campo[14], $campo[15], $campo[16], $campo[17], $campo[18], $campo[19], $campo[20], $campo[21], $campo[22], $campo[23], $campo[24], $campo[25], $campo[26], $campo[27], $campo[28], $campo[29], $campo[30], $campo[31], $campo[32], $campo[33], $campo[34], $campo[35], $campo[36], $campo[37], $campo[38], $campo[39], $campo[40], $campo[41], $campo[42], $campo[43], $campo[44], $campo[45], $campo[46], $campo[47], $campo[48], $campo[49], $campo[50], $campo[51], $campo[52], $campo[53], $campo[54], $campo[55], $campo[56], $campo[57], $campo[58], $campo[59], $campo[60], $campo[61], $campo[62], $campo[63], $campo[64], $campo[65], $campo[66], $campo[67], $campo[68], $campo[69]); 
	$colonna = ["idle", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR", "BS", "BT", "BU", "BV", "BW", "BX"];

	$objPHPExcel->setActiveSheetIndex(0); // Comincia da 0
	$objPHPExcel->getActiveSheet()->SetCellValue("A1", $annoscolastico_cla);

	//$objPHPExcel->getActiveSheet()->setCellValue("A1", $sql); 


	$date1=date_create("1900-01-01");
	$j = 4; //j è un numero che cresce di una unità ogni volta che scrivo un alunno-corrisponde al numero di riga di excel
	while (mysqli_stmt_fetch($stmt)) { 
		$j++;
		$objPHPExcel->getActiveSheet()->SetCellValue("A".$j, $j-4 );
		for ($x = 1; $x <= 69; $x++) {

			if ($x == 10 ||$x == 40 || $x == 52) {
				$date2=date_create($campo[$x]);
				$diff=date_diff($date1,$date2);
				$days=$diff->format("%a");
				$days+=2; // add boundary days
				$objPHPExcel->getActiveSheet()->setCellValue($colonna[$x].$j,$days); 
			} else {
				$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x].$j, $campo[$x] );
			}



		}

	}

	$writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');

?>