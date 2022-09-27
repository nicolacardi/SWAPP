<?
	include_once("database/databaseii.php");
	$annoscolastico_cla = $_GET['annoscolastico_cla'];
	$file_name = date('Ymd_h.i.s').'_AnagraficaRappresentanti_'.$annoscolastico_cla;
	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	$objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExportRappresentanti.xlsx");

	//per foglio famiglie
	$sql = "SELECT cognome_fam, nomemadre_fam, cognomemadre_fam, nomepadre_fam, cognomepadre_fam, telefonomadre_fam, altrotelmadre_fam, telefonopadre_fam, altrotelpadre_fam, emailmadre_fam, emailpadre_fam, rapprmadre_fam, rapprpadre_fam 
	FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) 
	LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE annoscolastico_cla = ? AND (rapprmadre_fam = 1 OR rapprpadre_fam = 1) ORDER BY cognome_fam";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $cognome_fam, $nomemadre_fam, $cognomemadre_fam, $nomepadre_fam, $cognomepadre_fam, $telefonomadre_fam, $altrotelmadre_fam, $telefonopadre_fam, $altrotelpadre_fam, $emailmadre_fam, $emailpadre_fam, $rapprmadre_fam, $rapprpadre_fam); 

	$objPHPExcel->setActiveSheetIndex(0); // Comincia da 0
	$objPHPExcel->getActiveSheet()->SetCellValue("A1", $annoscolastico_cla);
	
	$j = 4; //j è un numero che cresce di una unità ogni volta che scrivo una famiglia-corrisponde al numero di riga di excel
	while (mysqli_stmt_fetch($stmt)) { 
		$j++;
		$objPHPExcel->getActiveSheet()->SetCellValue("A".$j, $j-4 );
        if ($rapprmadre_fam == 1 && $rapprpadre_fam == 1) {
            $objPHPExcel->getActiveSheet()->SetCellValue("B".$j, $nomemadre_fam );
            $objPHPExcel->getActiveSheet()->SetCellValue("C".$j, $cognomemadre_fam );
            $objPHPExcel->getActiveSheet()->SetCellValue("D".$j, $telefonomadre_fam );
            $objPHPExcel->getActiveSheet()->SetCellValue("E".$j, $altrotelmadre_fam );
            $objPHPExcel->getActiveSheet()->SetCellValue("F".$j, $emailmadre_fam );
            $j++;
            $objPHPExcel->getActiveSheet()->SetCellValue("B".$j, $nomepadre_fam );
            $objPHPExcel->getActiveSheet()->SetCellValue("C".$j, $cognomepadre_fam );
            $objPHPExcel->getActiveSheet()->SetCellValue("D".$j, $telefonopadre_fam );
            $objPHPExcel->getActiveSheet()->SetCellValue("E".$j, $altrotelpadre_fam );
            $objPHPExcel->getActiveSheet()->SetCellValue("F".$j, $emailpadre_fam );

        } else {
            if ($rapprmadre_fam == 1) {
                $objPHPExcel->getActiveSheet()->SetCellValue("B".$j, $nomemadre_fam );
                $objPHPExcel->getActiveSheet()->SetCellValue("C".$j, $cognomemadre_fam );
                $objPHPExcel->getActiveSheet()->SetCellValue("D".$j, $telefonomadre_fam );
                $objPHPExcel->getActiveSheet()->SetCellValue("E".$j, $altrotelmadre_fam );
                $objPHPExcel->getActiveSheet()->SetCellValue("F".$j, $emailmadre_fam );
            } else {
                $objPHPExcel->getActiveSheet()->SetCellValue("B".$j, $nomepadre_fam );
                $objPHPExcel->getActiveSheet()->SetCellValue("C".$j, $cognomepadre_fam );
                $objPHPExcel->getActiveSheet()->SetCellValue("D".$j, $telefonopadre_fam );
                $objPHPExcel->getActiveSheet()->SetCellValue("E".$j, $altrotelpadre_fam );
                $objPHPExcel->getActiveSheet()->SetCellValue("F".$j, $emailpadre_fam );
            }
        }
	}
	

	$writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
?>