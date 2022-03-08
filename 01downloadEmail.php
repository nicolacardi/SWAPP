<?
	include_once("database/databaseii.php");
    require_once('vendor/autoload.php');

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateExportEmail.xlsx");
    
    $annoscolastico_cla = $_GET['annoscolastico_cla'];
    $file_name = date('Ymd_h.i.s').'_Email_'.$annoscolastico_cla.'.xlsx';
    $campo =  array(63);

    //per foglio EmailPerAlunno
    $objPHPExcel->setActiveSheetIndex(1); // Comincia da 0
    $objPHPExcel->getActiveSheet()->SetCellValue("A1", $annoscolastico_cla);
	$colonna = ["idle", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR"];


	$sql = "SELECT DISTINCT emailpadre_fam, emailmadre_fam, nome_alu, cognome_alu, mf_alu, ".
	"classe_cla, sezione_cla, cognome_fam ". //campi tab_classialunni
	"FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) ".
	"LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE annoscolastico_cla = ? AND listaattesa_cla = 0 ORDER BY classe_cla ASC, sezione_cla ASC, cognome_alu";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5], $campo[6], $campo[7], $campo[8]); 

	$j = 4; //j è un numero che cresce di una unità ogni volta che scrivo un alunno-corrisponde al numero di riga di excel
	while (mysqli_stmt_fetch($stmt)) { 
		$j++;
		$objPHPExcel->getActiveSheet()->SetCellValue("A".$j, $j-4 );
		for ($x = 1; $x <= 8; $x++) {
			$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x].$j, $campo[$x] );
		}
    }
    

    //per foglio EmailPerAlunnoB
    $objPHPExcel->setActiveSheetIndex(2); // Comincia da 0
    $objPHPExcel->getActiveSheet()->SetCellValue("A1", $annoscolastico_cla);
    
	$sql = "SELECT DISTINCT emailpadre_fam, nome_alu, cognome_alu, mf_alu, ".
	"classe_cla, sezione_cla, cognome_fam ". //campi tab_classialunni
	"FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) ".
	"LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE annoscolastico_cla = ? AND listaattesa_cla = 0 AND emailpadre_fam <> '' ORDER BY classe_cla ASC, sezione_cla ASC, cognome_alu";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5], $campo[6], $campo[7]); 

	$j = 4; //j è un numero che cresce di una unità ogni volta che scrivo un alunno-corrisponde al numero di riga di excel
	while (mysqli_stmt_fetch($stmt)) { 
		$j++;
		$objPHPExcel->getActiveSheet()->SetCellValue("A".$j, $j-4 );
		for ($x = 1; $x <= 7; $x++) {
			$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x].$j, $campo[$x] );
		}
    }

    //per foglio EmailPerAlunnoB - madre
	$sql = "SELECT DISTINCT emailmadre_fam, nome_alu, cognome_alu, mf_alu, ".
	"classe_cla, sezione_cla, cognome_fam ". //campi tab_classialunni
	"FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) ".
	"LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE annoscolastico_cla = ? AND listaattesa_cla = 0 AND emailmadre_fam <> '' ORDER BY classe_cla ASC, sezione_cla ASC, cognome_alu";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5], $campo[6], $campo[7]); 

	
	while (mysqli_stmt_fetch($stmt)) { 
		$j++;
		$objPHPExcel->getActiveSheet()->SetCellValue("A".$j, $j-4 );
		for ($x = 1; $x <= 7; $x++) {
			$objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x].$j, $campo[$x] );
		}
    }


//***************************************************************************************************************************************************
//***************************************************************************************************************************************************
    
    //per foglio EmailPerFamiglia
    $objPHPExcel->setActiveSheetIndex(3); // Comincia da 0
    $objPHPExcel->getActiveSheet()->SetCellValue("A1", $annoscolastico_cla);


    $sql = "SELECT DISTINCT ID_fam, emailpadre_fam, emailmadre_fam, cognome_fam, classe_cla, sezione_cla, cognome_alu  
    FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) 
    LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE annoscolastico_cla = ? AND listaattesa_cla = 0
    ORDER BY classe_cla ASC, sezione_cla ASC, cognome_alu";
     $stmt = mysqli_prepare($mysqli, $sql);
     mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
     mysqli_stmt_execute($stmt);
     mysqli_stmt_bind_result($stmt, $ID_fam, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5], $campo[6]); 
     mysqli_stmt_store_result($stmt);
     $j = 4; //j è un numero che cresce di una unità ogni volta che scrivo un alunno-corrisponde al numero di riga di excel
     
    while (mysqli_stmt_fetch($stmt)) { 
          $j++;
          $nomifratelli = "";
                //ora estraggo i nomi dei figli di ogni famiglia per metterli insieme
                $sql2 = "SELECT DISTINCT nome_alu, cognome_alu, mf_alu, classe_cla, sezione_cla 
                FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla)
                LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE annoscolastico_cla = ? AND listaattesa_cla = 0 AND ID_fam_alu = ?
                ORDER BY classe_cla ASC, sezione_cla ASC, cognome_alu";
                $stmt2 = mysqli_prepare($mysqli, $sql2);
                mysqli_stmt_bind_param($stmt2, "si", $annoscolastico_cla, $ID_fam);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_bind_result($stmt2, $nome_alu, $cognome_alu, $mf_alu, $classe_cla, $sezione_cla); 
                $n= 0;
                $almenounmaschio = 0;
                while (mysqli_stmt_fetch($stmt2)) { 
                    $n++;
                    $nomifratelli = $nomifratelli.$nome_alu.", ";   //costruisco la stringa che unisce i vari nomi
                    if ($mf_alu == "M") {$almenounmaschio = 1;}     //almenounmaschio == 0 determina desinenza "e" (figli-e)
                }

          $objPHPExcel->getActiveSheet()->SetCellValue("A".$j, $j-4 );
          for ($x = 1; $x <= 3; $x++) {
              $objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x].$j, $campo[$x] );
          }
          $objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x].$j, substr($nomifratelli, 0, -2) );
          if ($n == 1 && $mf_alu == "F") { $desinenza = "a";}
          if ($n == 1 && $mf_alu == "M") { $desinenza = "o";}
          if ($n != 1 && $almenounmaschio != 1) { $desinenza = "e";}    
          if ($n != 1 && $almenounmaschio == 1) { $desinenza = "";}    
          $objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x+1].$j, $desinenza );

    }

//***************************************************************************************************************************************************
//***************************************************************************************************************************************************
    

    //per foglio EmailPerFamigliaB
    $objPHPExcel->setActiveSheetIndex(4); // Comincia da 0
    $objPHPExcel->getActiveSheet()->SetCellValue("A1", $annoscolastico_cla);


    $sql = "SELECT DISTINCT ID_fam, emailpadre_fam, cognome_fam, classe_cla, sezione_cla, cognome_alu 
    FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) 
    LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE annoscolastico_cla = ? AND listaattesa_cla = 0 AND emailpadre_fam <> ''
    ORDER BY classe_cla ASC, sezione_cla ASC, cognome_alu";
     $stmt = mysqli_prepare($mysqli, $sql);
     mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
     mysqli_stmt_execute($stmt);
     mysqli_stmt_bind_result($stmt, $ID_fam, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5]); 
     mysqli_stmt_store_result($stmt);
     $j = 4; //j è un numero che cresce di una unità ogni volta che scrivo un alunno-corrisponde al numero di riga di excel
     
    while (mysqli_stmt_fetch($stmt)) { 
          $j++;
          $nomifratelli = "";

          $sql2 = "SELECT DISTINCT nome_alu, cognome_alu, mf_alu, classe_cla, sezione_cla
          FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) 
          LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE annoscolastico_cla = ? AND listaattesa_cla = 0 AND ID_fam_alu = ?
          ORDER BY classe_cla ASC, sezione_cla ASC, cognome_alu";
          $stmt2 = mysqli_prepare($mysqli, $sql2);
          mysqli_stmt_bind_param($stmt2, "si", $annoscolastico_cla, $ID_fam);
          mysqli_stmt_execute($stmt2);
          mysqli_stmt_bind_result($stmt2, $nome_alu, $cognome_alu, $mf_alu, $classe_cla, $sezione_cla); 
          $n= 0;
          $almenounmaschio = 0;
          while (mysqli_stmt_fetch($stmt2)) { 
              $n++;
              $nomifratelli = $nomifratelli.$nome_alu.", ";
              if ($mf_alu == "M") {$almenounmaschio = 1;}
          }

          $objPHPExcel->getActiveSheet()->SetCellValue("A".$j, $j-4 );
          for ($x = 1; $x <= 2; $x++) {
              $objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x].$j, $campo[$x] );
          }
          $objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x].$j, substr($nomifratelli, 0, -2) );
          if ($n == 1 && $mf_alu == "F") { $desinenza = "a";}
          if ($n == 1 && $mf_alu == "M") { $desinenza = "o";}
          if ($n != 1 && $almenounmaschio != 1) { $desinenza = "e";}    
          if ($n != 1 && $almenounmaschio == 1) { $desinenza = "";}    
          $objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x+1].$j, $desinenza );

    }


    $sql = "SELECT DISTINCT ID_fam, emailmadre_fam, cognome_fam, classe_cla, sezione_cla, cognome_alu 
    FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla)
    LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE annoscolastico_cla = ? AND listaattesa_cla = 0 AND emailmadre_fam <> ''
    ORDER BY classe_cla ASC, sezione_cla ASC, cognome_alu";
     $stmt = mysqli_prepare($mysqli, $sql);
     mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
     mysqli_stmt_execute($stmt);
     mysqli_stmt_bind_result($stmt, $ID_fam, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5]); 
     mysqli_stmt_store_result($stmt);
     
    while (mysqli_stmt_fetch($stmt)) { 
          $j++;
          $nomifratelli = "";

          $sql2 = "SELECT DISTINCT nome_alu, cognome_alu, mf_alu, classe_cla, sezione_cla 
          FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla)
          LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE annoscolastico_cla = ? AND listaattesa_cla = 0 AND ID_fam_alu = ?
          ORDER BY classe_cla ASC, sezione_cla ASC, cognome_alu";
          $stmt2 = mysqli_prepare($mysqli, $sql2);
          mysqli_stmt_bind_param($stmt2, "si", $annoscolastico_cla, $ID_fam);
          mysqli_stmt_execute($stmt2);
          mysqli_stmt_bind_result($stmt2, $nome_alu, $cognome_alu, $mf_alu, $classe_cla, $sezione_cla); 
          $n= 0;
          $almenounmaschio = 0;
          while (mysqli_stmt_fetch($stmt2)) { 
              $n++;
              $nomifratelli = $nomifratelli.$nome_alu.", ";
              if ($mf_alu == "M") {$almenounmaschio = 1;}
          }

          $objPHPExcel->getActiveSheet()->SetCellValue("A".$j, $j-4 );
          for ($x = 1; $x <= 2; $x++) {
              $objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x].$j, $campo[$x] );
          }
          $objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x].$j, substr($nomifratelli, 0, -2) );
          if ($n == 1 && $mf_alu == "F") { $desinenza = "a";}
          if ($n == 1 && $mf_alu == "M") { $desinenza = "o";}
          if ($n != 1 && $almenounmaschio != 1) { $desinenza = "e";}    
          if ($n != 1 && $almenounmaschio == 1) { $desinenza = "";}    
          $objPHPExcel->getActiveSheet()->SetCellValue($colonna[$x+1].$j, $desinenza );

    }

    $writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
    $writer->save('php://output');

?>