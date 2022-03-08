<?
//scarica un file excel con un sinottico di un mese
	require_once('vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	include_once("database/databaseii.php");
	$annoscolastico_cla = $_GET['annoscolastico_cla'];
	$classe_cla = $_GET['classe_cla'];
	$sezione_cla = $_GET['sezione_cla'];
	$mese = $_GET['mese'];
	$sql = "SELECT anno1_asc, anno2_asc FROM tab_anniscolastici WHERE annoscolastico_asc = ? ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $anno1_asc, $anno2_asc);
	while (mysqli_stmt_fetch($stmt)) {
	}
	if ($mese <=6 ) { $anno = $anno2_asc;} else { $anno = $anno1_asc;}
	$ID_aluA = array();
	$file_name = date('Ymd_h.i.s').'_Assenze_'.$ID_mae."_cl".$classe_cla.$sezione_cla.$mese.'.xlsx';
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("TemplateElencoAssenze.xlsx");
	$spreadsheet->getProperties()
		->setTitle('SWAPP')
		->setSubject('SWAPP')
		->setDescription('Export File From SWAPP')
		->setCreator('Nicola Cardi')
		->setLastModifiedBy('Nicola Cardi');
	$styleArray = [
		'fill' => [
			'fillType' => [
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
			],
		],
	];
	$spreadsheet->setActiveSheetIndex(1);
	$col_nomecognome = "C";	
	//metto in vari array i valori degli alunni della classe (non serve qui filtrare anche sul maestro)
	$sql2 = "SELECT DISTINCT ID_alu, nome_alu, cognome_alu FROM (tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) WHERE annoscolastico_cla = ? AND classe_cla = ? AND sezione_cla = ? AND ritirato_cla = 0 AND listaattesa_cla = 0 ORDER BY cognome_alu";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "sss", $annoscolastico_cla, $classe_cla, $sezione_cla);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $ID_alu, $nome_alu, $cognome_alu);
	$alunni = 1;
	while (mysqli_stmt_fetch($stmt2)) {
		$ID_aluA[$alunni]= $ID_alu;
		$spreadsheet->getActiveSheet()->SetCellValue($col_nomecognome.($alunni+7), $nome_alu." ".$cognome_alu);
		$alunni++;
	}
	$mese_descA = array("idle", "GENNAIO", "FEBBRAIO", "MARZO", "APRILE", "MAGGIO", "GIUGNO", "LUGLIO", "AGOSTO", "SETTEMBRE", "OTTOBRE", "NOVEMBRE", "DICEMBRE");
	$mese_ggA = array("idle", 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	$col_date = array("idle", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM");
	$g_itaA = array("D", "L", "M", "Me", "G", "V", "S");
	$mese_desc = $mese_descA[intval($mese)];
	$mese_gg = $mese_ggA[intval($mese)];
	for ($g = 1; $g <= $mese_gg; $g++) {
		if ($g > 9) {$gstr = $g;} else { $gstr = "0".$g;}
		if ($mese > 9) {$mesestr = $mese;} else { $mesestr = "0".$mese;}
		$date = strtotime($mesestr."/".$gstr."/".$anno);
		$Ymddate = date('Y-m-d',$date);
		if ($g == 1) { $primadata = $Ymddate;}
		if ($g == $mese_gg) { $ultimadata = $Ymddate;}
		$g_itaN = date('w', strtotime($Ymddate));
		$g_ita = $g_itaA[$g_itaN];
		$spreadsheet->getActiveSheet()->SetCellValue($col_date[$g]."7", $Ymddate);
		$spreadsheet->getActiveSheet()->SetCellValue($col_date[$g]."6", $g_ita);
		//vengono incluse sia le ore come primo maestro che come secondo maestro
		//PER NON DUPLICARE LE ASSENZE metto il filtro WHERE secondomaestro_ora  = 0
		$sql2 = "SELECT DISTINCT ID_ora FROM tab_orario WHERE secondomaestro_ora  = 0 AND data_ora = ? AND classe_ora = ? AND sezione_ora = ? AND codmat_ora <> 'nom'";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "sss", $Ymddate, $classe_cla, $sezione_cla);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $ID_ora);
		$lezioni = 0;
		while (mysqli_stmt_fetch($stmt2)) {
			$lezioni++;
		}
		if ($lezioni != 0) { 
		//DEVO PENSARE A COME ESCLUDERE I GIORNI DI FERIE......SI PUO' ACCEDERE A TAB_ORARIO E VEDERE SE SI TRATTA DI UN GIORNO SENZA LEZIONI PER LA CLASSE
			if (($g_itaN != 0) && ($g_itaN != 6)) {
				for ($alunno = 1; $alunno < $alunni; $alunno++) {
					$cella = $col_date[$g].($alunno+7);
					$spreadsheet->getActiveSheet()->SetCellValue($cella, "P");
					$spreadsheet->getActiveSheet()->getStyle($cella)
					->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
					$spreadsheet->getActiveSheet()->getStyle($cella)
					->getFill()->getStartColor()->setARGB('0088c437');
				}
			}
		}
	}
	$spreadsheet->getActiveSheet()->SetCellValue("B3", "Classe: ".$classe_cla." ".$sezione_cla);
	$spreadsheet->getActiveSheet()->SetCellValue("B4", "Mese: ".$mese_desc);
	for ($alunno = 1; $alunno < $alunni; $alunno++) {
		$sql2 = "SELECT DISTINCT ID_alu_ass, data_ass, tipo_ass FROM (tab_assenze) WHERE ID_alu_ass = ? AND data_ass <= ? AND data_ass >= ? ";
		//$spreadsheet->getActiveSheet()->SetCellValue("AO".($alunno+7), $sql2);
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "iss", $ID_aluA[$alunno], $ultimadata, $primadata);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $ID_alu_ass, $data_ass, $tipo_ass);
		while (mysqli_stmt_fetch($stmt2)) {
			$gmese = intval(date('d', strtotime($data_ass)));
			$col = $col_date[$gmese];
			$cella = $col.($alunno+7);
			if ($tipo_ass == 0) {$spreadsheet->getActiveSheet()->SetCellValue($cella, "A");}
			if ($tipo_ass == 2) {$spreadsheet->getActiveSheet()->SetCellValue($cella, "D");}

			$spreadsheet->getActiveSheet()->getStyle($cella)
			->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
			if ($tipo_ass == 0) {$spreadsheet->getActiveSheet()->getStyle($cella)
			->getFill()->getStartColor()->setARGB('FFFF0000');}
			if ($tipo_ass == 2) {$spreadsheet->getActiveSheet()->getStyle($cella)
				->getFill()->getStartColor()->setARGB('FF0000FF');}
		}
	}
	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	$writer->save('php://output');
	exit;
?>











