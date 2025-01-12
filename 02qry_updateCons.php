<?include_once("database/databaseii.php");
	$ID_alu_cor = $_POST['ID_alu_cor'];
	$annoscolastico_cor = $_POST['annoscolastico_cor'];
	$dategg_mm_aaaa = str_replace('/', '-', $_POST['data_cor']);
	$data_cor = date('Y-m-d', strtotime($dategg_mm_aaaa));




	$metodo_cor = $_POST['selectMetodo_cor'];
	$interesse_cor = $_POST['selectInteresse_cor'];
	$area_cor = array();
	for ($x = 1; $x <= 11; $x++) {
		if (isset ($_POST["area".$x."_cor"])) {
			$area_cor[$x] = 1;
		} else {
			$area_cor[$x] = 0;
		}
	}
	$attitudini_cor = $_POST['attitudini_cor'];
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
	
	if (($metodo_cor == '') || ($interesse_cor == '') || ( $area_cor[1] == 0 && $area_cor[2] == 0 && $area_cor[3] ==0 && $area_cor[4] ==0 && $area_cor[5] ==0 && $area_cor[6] ==0 && $area_cor[7] ==0 && $area_cor[8] ==0 && $area_cor[9] ==0 && $area_cor[10] ==0 && $area_cor[11] ==0) || ($scuola_cor[1] ==0 && $scuola_cor[2]==0 && $scuola_cor[3]==0 && $scuola_cor[4]==0) || ($attitudini_cor =='')) {
		$return ['stopgo'] = 'STOP';
		$return['result_alert'] = "Manca qualche informazione<br>devono essere inseriti nel modulo:<br>il metodo, il tipo d'interesse, un'area di preferenza almeno,<br>l'attitudine ed una scuola almeno.<br><br>Il documento verrà salvato comunque ma risulta incompleto.";
	} else {
		$return ['stopgo'] = 'GO';
		$return['result_alert'] = "Tutto OK";
	}

	
	//CANCELLA TUTTO E RISCRIVI
	$sql = "DELETE FROM tab_consorientativo WHERE ID_alu_cor = ? AND annoscolastico_cor = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "is", $ID_alu_cor, $annoscolastico_cor);	
	mysqli_stmt_execute($stmt);
	
	
	//INSERT in tab_consorientativo
	$sql = "INSERT tab_consorientativo SET ".
	" ID_alu_cor = ".$ID_alu_cor." ,".
	" data_cor = '".$data_cor."' ,".
	" annoscolastico_cor = '".$annoscolastico_cor."',".
	" metodo_cor = '".$metodo_cor."',".
	" interesse_cor = '".$interesse_cor."',";
	for ($x = 1; $x <= 11; $x++) {
		$sql = $sql." area".$x."_cor = ".$area_cor[$x]. ",";
	}
	
	for ($x = 1; $x <= 4; $x++) {
		$sql = $sql." scuola".$x."_cor = ".$scuola_cor[$x]. ",";
	}
	for ($x = 1; $x <= 4; $x++) {
		$sql = $sql." tiposcuola".$x."_cor = '".$tiposcuola_cor[$x]. "',";
	}
	$sql = $sql." attitudini_cor = '". $attitudini_cor ."'";
	
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	$return['sql'] = $sql;
	echo json_encode($return);
?>
