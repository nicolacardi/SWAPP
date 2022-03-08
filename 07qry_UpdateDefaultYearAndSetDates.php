<?	include_once("database/databaseii.php");
	$annoscolastico = $_POST['annoscolastico'];
	
	//aggiorna anno corrente
	$sql = "UPDATE tab_parametri SET val_par = ? WHERE parname_par = 'anno_corrente' ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico);
	mysqli_stmt_execute($stmt);

	//trova anno successivo
	$sql = "SELECT annoscolastico_asc FROM tab_anniscolastici WHERE annoscolasticoprec_asc = ? ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $annoscolasticosucc_asc);
	while (mysqli_stmt_fetch($stmt)) {
	}
	$sql = "UPDATE tab_parametri SET val_par = ? WHERE parname_par = 'anno_prossimo' ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolasticosucc_asc);
	mysqli_stmt_execute($stmt);

	//perchè errore sintassi???
	$_SESSION ['anno_corrente'] = $annoscolastico;
	$_SESSION ['anno_prossimo'] = $annoscolasticosucc_asc;

	
	$datainizio_asc =  $_POST['datainizio_asc'];
	$datafinequadrimestre1_asc =  $_POST['datafinequadrimestre1_asc'];
	$datafine_asc =  $_POST['datafine_asc'];
	$datainizio_asc = date('Y-m-d', strtotime(str_replace('/','-', $datainizio_asc)));
	$datafinequadrimestre1_asc = date('Y-m-d', strtotime(str_replace('/','-', $datafinequadrimestre1_asc)));
	$datafine_asc = date('Y-m-d', strtotime(str_replace('/','-', $datafine_asc)));
	//le date vanno trasformate da dd/mm/yyy a yyyy-mm-dd
	$sql = "UPDATE tab_anniscolastici SET datainizio_asc = ?, datafinequadrimestre1_asc = ?, datafine_asc = ? WHERE annoscolastico_asc = ? ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssss", $datainizio_asc, $datafinequadrimestre1_asc, $datafine_asc, $annoscolastico);
	mysqli_stmt_execute($stmt);
	$return['result'] = $sql;
    echo json_encode($return);
?>
