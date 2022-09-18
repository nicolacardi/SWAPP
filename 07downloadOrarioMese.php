<?	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateOrarioMese.xlsx");
	include_once("database/databaseii.php");

	$datefrom = $_GET['datefrom'];
	$dateto = $_GET['dateto'];
	$file_name = date('Ymd_h.i.s').'_OrarioMese_dal_'.$datefrom.'_al_'.$dateto;
	$campo =  array(16);
	$sql = "SELECT ID_ora, data_ora, ora_ora, codmat_ora, classe_ora, sezione_ora, ID_mae_ora, firma_mae_ora, assente_ora, supplente_ora, datafirma_ora, argomento_ora, compitiassegnati_ora, ".
	" CONCAT (nome_mae , ' ', cognome_mae) as nomecognome_mae, descmateria_mtt, ID_mtt ".
	" FROM (tab_orario LEFT JOIN tab_anagraficamaestri ON ID_mae_ora = ID_mae) ".
	" LEFT JOIN tab_materie ON codmat_ora = codmat_mtt ".
	" WHERE data_ora BETWEEN ? AND ? ORDER BY classe_ora, data_ora, ora_ora";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ss", $datefrom, $dateto);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $campo[1], $campo[2], $campo[3], $campo[4], $campo[5], $campo[6], $campo[7], $campo[8], $campo[9], $campo[10], $campo[11], $campo[12], $campo[13], $campo[14], $campo[15], $campo[16]); 
	$colonna = ["idle", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB"];
	//$spreadsheet = new PHPExcel();


	$spreadsheet->setActiveSheetIndex(0); // Comincia da 0
	$spreadsheet->getActiveSheet()->SetCellValue("B1", $datefrom);
	$spreadsheet->getActiveSheet()->SetCellValue("B2", $dateto);
	$j = 4; //$j è la riga di excel in cui si sta scrivendo
	while (mysqli_stmt_fetch($stmt)) {
	$j++;
		for ($x = 1; $x <= 17; $x++) { // $x è il numero che corrisponde alla colonna...che alfabeticamente si ricava da $colonna[$x]
			$spreadsheet->getActiveSheet()->SetCellValue($colonna[$x].$j, $campo[$x] );
		}
	}

	//Ora si passa al foglio MatriceOrario
	// $sql = "SELECT ID_ora, data_ora, ora_ora, codmat_ora, classe_ora, sezione_ora, ID_mae_ora, firma_mae_ora, assente_ora, supplente_ora, datafirma_ora, argomento_ora, compitiassegnati_ora, ".
	// " CONCAT (nome_mae , ' ', cognome_mae) as nomecognome_mae, descmateria_mtt, ID_mtt, maestroreale_ora ".
	// " FROM (tab_orario LEFT JOIN tab_anagraficamaestri ON maestroreale_ora = ID_mae) ".
	// " LEFT JOIN tab_materie ON codmat_ora = codmat_mtt ".
	// " WHERE data_ora BETWEEN ? AND ? ORDER BY data_ora, classe_ora, ora_ora";

	// $sql = "SELECT ID_ora, data_ora, ora_ora, codmat_ora, classe_ora, sezione_ora, ID_mae_ora, firma_mae_ora, assente_ora, supplente_ora, datafirma_ora, argomento_ora, compitiassegnati_ora, ".
	// " CONCAT (nome_mae , ' ', cognome_mae) as nomecognome_mae, descmateria_mtt, ID_mtt, maestroreale_ora ".
	// " FROM (tab_orario LEFT JOIN tab_anagraficamaestri ON ID_mae_ora = ID_mae) ".
	// " LEFT JOIN tab_materie ON codmat_ora = codmat_mtt ".
	// " WHERE data_ora BETWEEN ? AND ? ORDER BY data_ora, classe_ora, ora_ora";

	$sql = "SELECT ID_ora, data_ora, ora_ora, codmat_ora, classe_ora, sezione_ora, ID_mae_ora, firma_mae_ora, assente_ora, supplente_ora, datafirma_ora, argomento_ora, compitiassegnati_ora, ".
	"CONCAT (tab_anagraficamaestri.nome_mae , ' ', tab_anagraficamaestri.cognome_mae) as nomecognome_mae, ".
	"CONCAT(tab_anagraficamaestri_suppl.nome_mae , ' ', tab_anagraficamaestri_suppl.cognome_mae) as nomecognome_mae_suppl, ".
	"descmateria_mtt, ID_mtt, maestroreale_ora ".
	"FROM ((tab_orario LEFT JOIN tab_anagraficamaestri ON ID_mae_ora = tab_anagraficamaestri.ID_mae) 
	LEFT JOIN tab_anagraficamaestri as tab_anagraficamaestri_suppl ON maestroreale_ora = tab_anagraficamaestri_suppl.ID_mae)
	LEFT JOIN tab_materie ON codmat_ora = codmat_mtt WHERE data_ora BETWEEN ? AND ? ORDER BY data_ora, classe_ora, ora_ora";

	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ss", $datefrom, $dateto);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ora, $data_ora, $ora_ora, $codmat_ora, $classe_ora, $sezione_ora, $ID_mae_ora, $firma_mae_ora, $assente_ora, $supplente_ora, $datafirma_ora, $argomento_ora, $compitiassegnati_ora, $nomecognome_mae, $nomecognome_suppl, $descmateria_mtt, $ID_mtt, $maestroreale_ora); 
	$colonna = ["idle", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB"];
	$data_ora_prec = "1999-01-01";
	$riga= 3;
	$spreadsheet-> setActiveSheetIndexByName("MatriceOrario");
    $styleArray = array(
        'borders' => array(
            'outline' => array(
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
            ),
        ),
	);

	while (mysqli_stmt_fetch($stmt)) {
		//dovrei estrarre quante ore ci sono con la stessa data, ora, classe, per capire se ci sono seconde materie o tutor
		
		//se non c'è materia indicata si salta la scrittura della cella
		if (($codmat_ora !='nom')) {
			//se la classe è cambiata si fa una riga nuova
			if ($classe_ora != $classe_ora_prec) {
				$riga= $riga + 1 + $righedaaggiungereaquestogiorno;
				$spreadsheet->getActiveSheet()->SetCellValue("A".$riga, $data_ora);
				$spreadsheet->getActiveSheet()->SetCellValue("B".$riga, $classe_ora);
				$righedaaggiungereaquestogiorno = 0;
			}
			if ($ora_ora == $ora_ora_prec) {
				$righedaaggiungereaquestora++;
				if ($righedaaggiungereaquestogiorno<$righedaaggiungereaquestora) {$righedaaggiungereaquestogiorno = $righedaaggiungereaquestora;};
				$cella = $colonna[$ora_ora+2].($riga+$righedaaggiungereaquestora);
			} else {
				$righedaaggiungereaquestora = 0;
				$cella = $colonna[$ora_ora+2].($riga);
			}


			//Ecco il contenuto di ciò che si va a scrivere
			if ($assente_ora == 1) {
				$spreadsheet->getActiveSheet()->SetCellValue($cella, $descmateria_mtt."\n".$nomecognome_mae."\nSOSTITUITO/A DA:\n".$nomecognome_suppl);
			} else {
				$spreadsheet->getActiveSheet()->SetCellValue($cella, $descmateria_mtt."\n".$nomecognome_mae."\n ");
			}
			$spreadsheet->getActiveSheet()->getStyle($cella)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
			$spreadsheet->getActiveSheet()->getStyle($cella)->applyFromArray($styleArray);
			if (($codmat_ora !="XX1") && ($codmat_ora !="XX3") && ($codmat_ora !="XX4")) {

				switch ($firma_mae_ora) {
					case 0:
					$spreadsheet->getActiveSheet()->getStyle($cella)->getFill()->getStartColor()->setARGB('FFFF0000');
				break;
					case 1:
					$spreadsheet->getActiveSheet()->getStyle($cella)->getFill()->getStartColor()->setARGB('0088c437');
				break;
					case 2:
					$spreadsheet->getActiveSheet()->getStyle($cella)->getFill()->getStartColor()->setARGB('00FFc437');
				break;
				}
				if ($assente_ora == 1) {
					$spreadsheet->getActiveSheet()->getStyle($cella)->getFont()->getColor()->setARGB('FFFFFFFF');
				}
			} else {
				$spreadsheet->getActiveSheet()->getStyle($cella)->getFill()->getStartColor()->setARGB('00c1c1c1');
			}
			$classe_ora_prec = $classe_ora;
			$ora_ora_prec = $ora_ora;
		}
	}
	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
	//header('Location: 07OrarioNew.php');
	exit();
?>