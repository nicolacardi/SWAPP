<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");

	$annoscolastico = $_POST['annoscolastico'];
	$sql = "SELECT datainizio_asc, datafinequadrimestre1_asc, datafine_asc FROM tab_anniscolastici WHERE annoscolastico_asc = ? ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $datainizio_asc, $datafinequadrimestre1_asc, $datafine_asc);
	
	while (mysqli_stmt_fetch($stmt)) {
		$return['datainizio_asc'] = timestamp_to_ggmmaaaa($datainizio_asc);
		$return['datafinequadrimestre1_asc'] = timestamp_to_ggmmaaaa($datafinequadrimestre1_asc);
		$return['datafine_asc'] = timestamp_to_ggmmaaaa($datafine_asc);
	}
    echo json_encode($return);
?>
