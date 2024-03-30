<?
	include_once("database/databaseii.php");
	$annoscolastico_cla = $_GET['annoscolastico_cla'];
	$where = $_GET['where'];
	$file_name = date('Ymd_h.i.s').'_AnagraficaPerAnnoMin_'.$annoscolastico_cla;
	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExportAnagraficaPerAnnoMinEGen.xlsx");

	$campo =  array(65);

	//per foglio alunni
	$sql = "SELECT DISTINCT nome_alu, cognome_alu, indirizzo_alu, citta_alu, CAP_alu, prov_alu, paese_alu, cf_alu, mf_alu, datanascita_alu, comunenascita_alu, provnascita_alu, paesenascita_alu, note_alu, scuolaprovenienza_alu, indirizzoscproven_alu, ckprivacy1_alu, ckprivacy2_alu, ckprivacy3_alu, ckautfoto_alu, ckautmateriale_alu, ckautuscite_alu, ". //campi tab_anagraficaalunni
	"classe_cla, sezione_cla, aselme_cla, listaattesa_cla, ritirato_cla, ". //campi tab_classialunni
	"cognome_fam, nomemadre_fam, cognomemadre_fam, nomepadre_fam, cognomepadre_fam, telefonomadre_fam, altrotelmadre_fam, telefonopadre_fam, altrotelpadre_fam, emailmadre_fam, emailpadre_fam, sociomadre_fam, sociopadre_fam, ".
	"datanascitamadre_fam, comunenascitamadre_fam, provnascitamadre_fam, paesenascitamadre_fam, cittadinanzamadre_fam, cfmadre_fam, indirizzomadre_fam, comunemadre_fam, CAPmadre_fam, provmadre_fam, paesemadre_fam, titolomadre_fam, profmadre_fam, ".
	"datanascitapadre_fam, comunenascitapadre_fam, provnascitapadre_fam, paesenascitapadre_fam, cittadinanzapadre_fam, cfpadre_fam, indirizzopadre_fam, comunepadre_fam, CAPpadre_fam, provpadre_fam, paesepadre_fam, titolopadre_fam, profpadre_fam ". //campi di tab_famiglie
	"FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) ".
	"LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE annoscolastico_cla = ? ".$where." ORDER BY classe_cla ASC, cognome_alu ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5], $campo[6], $campo[7], $campo[8], $campo[9], $campo[10], $campo[11], $campo[12], $campo[13], $campo[14], $campo[15], $campo[16], $campo[17], $campo[18], $campo[19], $campo[20], $campo[21], $campo[22], $campo[23], $campo[24], $campo[25], $campo[26], $campo[27], $campo[28], $campo[29], $campo[30], $campo[31], $campo[32], $campo[33], $campo[34], $campo[35], $campo[36], $campo[37], $campo[38], $campo[39], $campo[40], $campo[41], $campo[42], $campo[43], $campo[44], $campo[45], $campo[46], $campo[47], $campo[48], $campo[49], $campo[50], $campo[51], $campo[52], $campo[53], $campo[54], $campo[55], $campo[56], $campo[57], $campo[58], $campo[59], $campo[60], $campo[61], $campo[62], $campo[63], $campo[64], $campo[65], $campo[66]); 
	$colonna = ["idle", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR", "BS", "BT"];


	$spreadsheet->setActiveSheetIndex(0); // Comincia da 0
	$spreadsheet->getActiveSheet()->SetCellValue("A1", $annoscolastico_cla);
	$j = 4; //j è un numero che cresce di una unità ogni volta che scrivo un alunno-corrisponde al numero di riga di excel
	$date1=date_create("1900-01-01");
    $n = 0;
	while (mysqli_stmt_fetch($stmt)) { 

        $n++;
        $j++;
		$spreadsheet->getActiveSheet()->SetCellValue("A".$j, $n);
        $x  = 1;
            $spreadsheet->getActiveSheet()->SetCellValue("B".$j, $campo[$x] );
        $x  = 2;
            $spreadsheet->getActiveSheet()->SetCellValue("C".$j, $campo[$x] );
        $spreadsheet->getActiveSheet()->getStyle('A'.$j.":C".$j)
            ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
        $j++;
        $x  = 29;
            $spreadsheet->getActiveSheet()->SetCellValue("B".$j, $campo[$x] );
        $x  = 30;
            $spreadsheet->getActiveSheet()->SetCellValue("C".$j, $campo[$x] );
        $x  = 33;
            $spreadsheet->getActiveSheet()->SetCellValue("D".$j, $campo[$x] );
        $x  = 34;
            $spreadsheet->getActiveSheet()->SetCellValue("E".$j, $campo[$x] );
        $x  = 37;
            $spreadsheet->getActiveSheet()->SetCellValue("F".$j, $campo[$x] );
        $j++;
        $x  = 31;
            $spreadsheet->getActiveSheet()->SetCellValue("B".$j, $campo[$x] );
        $x  = 32;
            $spreadsheet->getActiveSheet()->SetCellValue("C".$j, $campo[$x] );
        $x  = 35;
            $spreadsheet->getActiveSheet()->SetCellValue("D".$j, $campo[$x] );
        $x  = 36;
            $spreadsheet->getActiveSheet()->SetCellValue("E".$j, $campo[$x] );
        $x  = 38;
            $spreadsheet->getActiveSheet()->SetCellValue("F".$j, $campo[$x] );
        $spreadsheet->getActiveSheet()->getStyle('A'.$j.":F".$j)
            ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		
	}


	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
?>