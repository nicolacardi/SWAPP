<?
	include_once("database/databaseii.php");
	$annoscolastico_cla = $_GET['annoscolastico_cla'];
	$file_name = date('Ymd_h.i.s').'_AnagraficaPerAnnoElisa_'.$annoscolastico_cla.'.xlsx';
	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	$objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExportAnagraficaPerAnnoElisa.xlsx");
	$campo =  array(27);
	$sql = "SELECT DISTINCT cognome_alu, nome_alu, sociomadre_fam, sociopadre_fam, cognomemadre_fam, nomemadre_fam, cognomepadre_fam, nomepadre_fam, indirizzo_alu, citta_alu, CAP_alu, prov_alu, classe_cla, sezione_cla, telefonomadre_fam, telefonopadre_fam, aselme_cla  ". //campi di tab_famiglie
	"FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) ".
	"LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE annoscolastico_cla = ? AND listaattesa_cla = 0 ORDER BY cognome_alu, nome_alu";
	
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $cognome_alu, $nome_alu, $sociomadre_fam, $sociopadre_fam, $cognomemadre_fam, $nomemadre_fam, $cognomepadre_fam, $nomepadre_fam, $indirizzo_alu, $citta_alu, $CAP_alu, $prov_alu, $classe_cla, $sezione_cla, $telefonomadre_fam, $telefonopadre_fam, $aselme_cla );

	
	$objPHPExcel->setActiveSheetIndex(0); // Comincia da 0
	$objPHPExcel->getActiveSheet()->SetCellValue("A1", $annoscolastico_cla);
	$j = 4; //j è un numero che cresce di una unità ogni volta che scrivo un alunno-corrisponde al numero di riga di excel
	while (mysqli_stmt_fetch($stmt)) {
	$j++;
		$objPHPExcel->getActiveSheet()->SetCellValue("B".$j, $cognome_alu." ". $nome_alu);
		if ($aselme_cla == "AS" || $aselme_cls == "NI") {$objPHPExcel->getActiveSheet()->SetCellValue("C".$j, $classe_cla." ".$sezione_cla);} else {$objPHPExcel->getActiveSheet()->SetCellValue("C".$j, $classe_cla);}
		if ($sociomadre_fam == "1") {$objPHPExcel->getActiveSheet()->SetCellValue("D".$j, $cognomemadre_fam." ".$nomemadre_fam);}else {$objPHPExcel->getActiveSheet()->SetCellValue("D".$j, $cognomepadre_fam ." ".$nomepadre_fam);}
		if ($sociomadre_fam == "1") {$objPHPExcel->getActiveSheet()->SetCellValue("E".$j, $cognomepadre_fam." ".$nomepadre_fam);}else {$objPHPExcel->getActiveSheet()->SetCellValue("E".$j, $cognomemadre_fam ." ".$nomemadre_fam);}
		
		if ($telefonomadre_fam == '') {
			if ($telefonopadre_fam == '') {
				$objPHPExcel->getActiveSheet()->SetCellValue("F".$j, $indirizzo_alu);
			} else {
				$objPHPExcel->getActiveSheet()->SetCellValue("F".$j, $indirizzo_alu);
				$objPHPExcel->getActiveSheet()->SetCellValue("J".$j, "p. ".$telefonopadre_fam);
			}
		} else {
			if ($telefonopadre_fam == '') {
				$objPHPExcel->getActiveSheet()->SetCellValue("F".$j, $indirizzo_alu);
				$objPHPExcel->getActiveSheet()->SetCellValue("J".$j, "m. ".$telefonomadre_fam);
			} else {
				$objPHPExcel->getActiveSheet()->SetCellValue("F".$j, $indirizzo_alu."    p. ".$telefonopadre_fam);
				$objPHPExcel->getActiveSheet()->SetCellValue("J".$j, "m. ".$telefonomadre_fam);
			}
		}
		$objPHPExcel->getActiveSheet()->SetCellValue("G".$j, $citta_alu);
		$objPHPExcel->getActiveSheet()->SetCellValue("H".$j, $CAP_alu);
		$objPHPExcel->getActiveSheet()->SetCellValue("I".$j, $prov_alu);
	}
	$writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
?>