<?include_once("database/databaseii.php");

//va adattato al nuovo consiglio orientativo 2025
	$ID_alu_cor = $_POST['ID_alu_cor'];
	$annoscolastico_cor = $_POST['annoscolastico_cor'];
	$dategg_mm_aaaa = str_replace('/', '-', $_POST['data_cor']);
	$data_cor = date('Y-m-d', strtotime($dategg_mm_aaaa));





	$area_cor = array();
	for ($x = 1; $x <= 8; $x++) {
		if (isset ($_POST["area".$x."_cor"])) {
			$area_cor[$x] = 1;
		} else {
			$area_cor[$x] = 0;
		}
	}

	$atti_cor = array();
	for ($x = 1; $x <= 5; $x++) {
		if (isset ($_POST["atti".$x."_cor"])) {
			$atti_cor[$x] = 1;
		} else {
			$atti_cor[$x] = 0;
		}
	}

	$altreatti_cor = $_POST['altreatti_cor'];

	$certi_cor = array();
	for ($x = 1; $x <= 3; $x++) {
		if (isset ($_POST["certi".$x."_cor"])) {
			$certi_cor[$x] = 1;
		} else {
			$certi_cor[$x] = 0;
		}
	}

	$altrecerti_cor = $_POST['altrecerti_cor'];

	$scuola_cor = array();
	for ($x = 1; $x <= 4; $x++) {
		if (isset ($_POST["scuola".$x."_cor"])) {
			$scuola_cor[$x] = 1;
		} else {
			$scuola_cor[$x] = 0;
		}
	}
	$tiposcuola_cor = array();
	for ($x = 1; $x <= 4; $x++) {
		if (isset ($_POST["tiposcuola".$x."_cor"])) {
			$tiposcuola_cor[$x] = $_POST["tiposcuola".$x."_cor"];
		} else {
			$tiposcuola_cor[$x] = '';
		}
	}
	
	if (
		( $area_cor[1] == 0 && $area_cor[2] == 0 && $area_cor[3] ==0 && $area_cor[4] ==0 && $area_cor[5] ==0 && $area_cor[6] ==0 && $area_cor[7] ==0 && $area_cor[8] ==0 ) || 
		( $atti_cor[1] == 0 && $atti_cor[2] == 0 && $atti_cor[3] ==0 && $atti_cor[4] ==0 && $atti_cor[5] ==0 ) || 
		($scuola_cor[1] ==0 && $scuola_cor[2]==0 && $scuola_cor[3]==0 && $scuola_cor[4]==0) ) {
		$return ['stopgo'] = 'STOP';
		$return['result_alert'] = "Manca qualche informazione<br>devono essere inseriti nel modulo:<br> un'area di interesse, un'attivita' almeno<br>ed una scuola almeno.<br><br>Il documento verrà salvato comunque ma risulta incompleto.";
	} else {
		$return ['stopgo'] = 'GO';
		$return['result_alert'] = "Tutto OK";
	}

	
	//CANCELLA TUTTO E RISCRIVI
	$sql = "DELETE FROM tab_consorientativo25 WHERE ID_alu_cor = ? AND annoscolastico_cor = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "is", $ID_alu_cor, $annoscolastico_cor);	
	mysqli_stmt_execute($stmt);
	
	
	//INSERT in tab_consorientativo



	$sql_insert = "INSERT INTO tab_consorientativo25 (
		ID_alu_cor, data_cor, annoscolastico_cor, 
		area1_cor, area2_cor, area3_cor, area4_cor, area5_cor, area6_cor, area7_cor, area8_cor,
		atti1_cor, atti2_cor, atti3_cor, atti4_cor, atti5_cor, altreatti_cor,
		certi1_cor, certi2_cor, certi3_cor, altrecerti_cor,
		scuola1_cor, scuola2_cor, scuola3_cor, scuola4_cor,
		tiposcuola1_cor, tiposcuola2_cor, tiposcuola3_cor, tiposcuola4_cor
	) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

	$stmt = mysqli_prepare($mysqli, $sql_insert);
	mysqli_stmt_bind_param(
		$stmt,
		"issiiiiiiiiiiiiisiiisiiiissss",
		$ID_alu_cor, $data_cor, $annoscolastico_cor,
		$area_cor[1], $area_cor[2], $area_cor[3], $area_cor[4], $area_cor[5], $area_cor[6], $area_cor[7], $area_cor[8],
		$atti_cor[1], $atti_cor[2], $atti_cor[3], $atti_cor[4], $atti_cor[5], $altreatti_cor,
		$certi_cor[1], $certi_cor[2], $certi_cor[3], $altrecerti_cor,
		$scuola_cor[1], $scuola_cor[2], $scuola_cor[3], $scuola_cor[4],
		$tiposcuola_cor[1], $tiposcuola_cor[2], $tiposcuola_cor[3], $tiposcuola_cor[4]
	);

	// $sql = "INSERT tab_consorientativo25 SET ".
	// " ID_alu_cor = ".$ID_alu_cor." ,".
	// " data_cor = '".$data_cor."' ,".
	// " annoscolastico_cor = '".$annoscolastico_cor."',";
	// for ($x = 1; $x <= 8; $x++) {
	// 	$sql = $sql." area".$x."_cor = ".$area_cor[$x]. ",";
	// }
	
	// for ($x = 1; $x <= 5; $x++) {
	// 	$sql = $sql." atti".$x."_cor = ".$atti_cor[$x]. ",";
	// }

	// $sql = $sql." altreatti_cor = '". $altreatti_cor ."',";

	// for ($x = 1; $x <= 3; $x++) {
	// 	$sql = $sql." certi".$x."_cor = ".$certi_cor[$x]. ",";
	// }

	// for ($x = 1; $x <= 4; $x++) {
	// 	$sql = $sql." scuola".$x."_cor = ".$scuola_cor[$x]. ",";
	// }
	// for ($x = 1; $x <= 4; $x++) {
	// 	$sql = $sql." tiposcuola".$x."_cor = '".$tiposcuola_cor[$x]. "',";
	// }

	// $sql = $sql." altrecerti_cor = '". $altrecerti_cor ."'";  //metto alla fine così non serve togliere la virgola finale


	mysqli_stmt_execute($stmt);
	$return['sql'] = $sql_insert;
	echo json_encode($return);
?>
