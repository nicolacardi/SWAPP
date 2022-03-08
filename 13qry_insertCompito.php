<?include_once("database/databaseii.php");
	$ID_cov = $_POST['ID_cov'];
	$codmat_cov = $_POST['selectmateria_new'];
	$tipo_cov = addslashes($_POST['tipo_cov_new']);
	$data_cov = $_POST['data_cov_new'];
	$data_cov = str_replace('/', '-', $data_cov);
	$data_cov = date('Y-m-d', strtotime($data_cov));
	$argomento_cov = addslashes(str_replace('"', "''", str_replace("”", "''", str_replace("“", "''", str_replace("‘", "'", str_replace("’", "'", $_POST['argomento_cov_new']))))));


	$classe_cov = $_POST['classe_cla'];
	$sezione_cov = $_POST['sezione_cla'];
	$annoscolastico_cov = $_POST['annoscolastico_cla'];
	$ID_mae_cov = intval($_POST['ID_mae']);
	//A seconda che ID_cov sia "" o meno si tratterà di una INSERT o di una UPDATE
	if ($ID_cov == "") {
		$sql = "INSERT INTO tab_compitiverifiche (classe_cov, sezione_cov, annoscolastico_cov, codmat_cov, tipo_cov, data_cov, argomento_cov, ID_mae_cov)".
		" VALUES ( ? , ? , ? , ? , ? , ? , ? , ? )";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "sssssssi", $classe_cov, $sezione_cov, $annoscolastico_cov, $codmat_cov, $tipo_cov, $data_cov, $argomento_cov, $ID_mae_cov);	
	} else {
		$sql = "UPDATE tab_compitiverifiche SET 
		classe_cov = ?,
		sezione_cov = ?,
		annoscolastico_cov = ?,
		codmat_cov = ?,
		tipo_cov= ?,
		data_cov= ?,
		argomento_cov= ?,
		ID_mae_cov= ? ".
		" WHERE ID_cov = ?";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "sssssssii", $classe_cov, $sezione_cov, $annoscolastico_cov, $codmat_cov, $tipo_cov, $data_cov, $argomento_cov, $ID_mae_cov, $ID_cov);
	}
	mysqli_stmt_execute($stmt);
	$return['sql'] = $sql;
    echo json_encode($return);
?>
