<?include_once("database/databaseii.php");
	$ID_alu_cer = $_POST['ID_alu_cer'];
	$annoscolastico_cer = $_POST['annoscolastico_cer'];
	$codmat_cer =  $_POST['codmat_cer'];
	$classe =  $_POST['classe'];
	$sezione =  $_POST['sezione'];
	$certVal = addslashes($_POST['certVal']);

	//verifico se c'è già un record per l'anno corrente per l'alunno. Se non c'è devo fare una INSERT
	$sql2 = "SELECT ID_cer FROM tab_certcompetenze 
	WHERE ID_alu_cer = ? AND annoscolastico_cer = ? AND codmat_cer = ? ";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "iss", $ID_alu_cer, $annoscolastico_cer, $codmat_cer);	
	mysqli_stmt_execute($stmt2);
	$n = 0;
	while (mysqli_stmt_fetch($stmt2)) {
		$n++;
	}

	if ($n == 0) {
		//INSERT in tab_certcompetenze
		$sql = "INSERT INTO tab_certcompetenze
		(classe_cer, sezione_cer, votocertcomp_cer, ID_alu_cer, annoscolastico_cer, codmat_cer) 
		VALUES (?, ?, ?, ?, ?, ?);";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "sssiss", $classe, $sezione, $certVal, $ID_alu_cer, $annoscolastico_cer, $codmat_cer);	
		mysqli_stmt_execute($stmt);
	} else {
		//UPDATE di tab_certcompetenze
		$sql = "UPDATE tab_certcompetenze SET
		votocertcomp_cer = ?  
		WHERE ID_alu_cer = ? 
		AND annoscolastico_cer = ? 
		AND codmat_cer = ? ";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "siss", $certVal, $ID_alu_cer, $annoscolastico_cer, $codmat_cer);	
		mysqli_stmt_execute($stmt);
	}
	$return['test'] = "trovati: ".$n;
	echo json_encode($return);
?>
