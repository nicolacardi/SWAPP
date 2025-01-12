<?
	include_once("database/databaseii.php");
    include_once("iscrizioni/diciture.php");
	$annoscolastico_cla = $_GET['annoscolastico_cla'];
	$where = $_GET['where'];
	$file_name = date('Ymd_h.i.s').'_AnagraficaPerASL_'.$annoscolastico_cla;
	//header('Content-type: application/vnd.ms-excel');
	//header('Content-Disposition: attachment; filename='.$file_name);
	//require_once 'PHPExcel/Classes/PHPExcel.php';
	//$objPHPExcel = PHPExcel_IOFactory::load("TemplateExportAnagraficaPerASL.xlsx");
	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	$objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExportAnagraficaPerASL.xlsx");

	$campo =  array(10);

	//per foglio alunni
	$sql = "SELECT DISTINCT cognome_alu, nome_alu, datanascita_alu, comunenascita_alu, mf_alu, cf_alu, emailmadre_fam, telefonomadre_fam, classe_cla, aselme_cla ".
	"FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) ".
	"LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE annoscolastico_cla = ? ".$where." AND listaattesa_cla = 0 ORDER BY classe_cla ASC, cognome_alu ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5], $campo[6], $campo[7], $campo[8], $classe_cla, $aselme_cla); 
	$colonna = ["idle", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR"];

    //$objPHPExcel->getActiveSheet()->SetCellValue("A1", $sql );
	$objPHPExcel->setActiveSheetIndex(0); // Comincia da 0
	$j = 1;
	$date1=date_create("1900-01-01");
	while (mysqli_stmt_fetch($stmt)) { 
		$j++;
		for ($x = 1; $x <= 8; $x++) {
            if ($x == 3) {
                $date2=date_create($campo[$x]);
				$diff=date_diff($date1,$date2);
				$days=$diff->format("%a");
				$days+=2; // add boundary days
				$objPHPExcel->getActiveSheet()->setCellValue($colonna[$x].$j,$days); 
            } else {
			    $objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x].$j, $campo[$x] );
            }
		}
        switch ($aselme_cla) {
            case "AS":
                $objPHPExcel->getActiveSheet()->SetCellValue("I".$j, "PD1A112007");
            break;
            case "EL":
                $objPHPExcel->getActiveSheet()->SetCellValue("I".$j, "PD1E076018");
            break;
            case "ME":
                $objPHPExcel->getActiveSheet()->SetCellValue("I".$j, "PD1M014005");
            break;
        }

        $objPHPExcel->getActiveSheet()->SetCellValue("J".$j, $cfscuola);
        $objPHPExcel->getActiveSheet()->SetCellValue("K".$j, $classe_cla." A" );
        $objPHPExcel->getActiveSheet()->SetCellValue("L".$j, "ALUNNO");

	}



	$writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
?>