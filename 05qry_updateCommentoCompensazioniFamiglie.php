<?include_once("database/databaseii.php");

	$ID_fam_com = $_POST['ID_fam'];
	$annoscolastico_com = $_POST['annoscolastico_com'];
	$commento_com = $_POST['commento_com'];
	//verifico se c'è già in quel caso sarà uan UPDATE altrimenti una INSERT
	$sql = "SELECT commento_com FROM tab_compensazionifamiglie WHERE ".
	" ID_fam_com  = ? ".
	" AND annoscolastico_com = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "is", $ID_fam_com, $annoscolastico_com);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $commento_comxCount);
	$i=0;
	while (mysqli_stmt_fetch($stmt)) {
		$i++;
	}
	if ($i == 0 ) {
		//non ne ha trovati quindi ne inserisco uno nuovo
		$sql = "INSERT INTO tab_compensazionifamiglie (ID_fam_com, annoscolastico_com, commento_com) VALUES ( ? , ? , ? ) ";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "iss", $ID_fam_com, $annoscolastico_com, $commento_com);
		mysqli_stmt_execute($stmt);
	} else {
		//ne ha trovati quindi faccio l'update
		$sql = "UPDATE tab_compensazionifamiglie SET ".
		" commento_com = ? ".
		" WHERE ".
		" ID_fam_com = ? ".
		" AND annoscolastico_com = ? ";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "sis", $commento_com, $ID_fam_com, $annoscolastico_com);
		mysqli_stmt_execute($stmt);
	}
	$return['sql']= $sql;
	echo json_encode($return);
?>
