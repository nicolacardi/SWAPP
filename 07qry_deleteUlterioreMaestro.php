<?include_once("database/databaseii.php");
	$ID_ora = $_POST['ID_ora'];
	
	//trovo se ci sono IDfirme di tutor legate al record che sto per cancellare
	$sql2 = "SELECT IDfirmatutor_ora FROM tab_orario WHERE ID_ora = ? ;";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "i", $ID_ora);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $IDfirmatutor_ora);
	while (mysqli_stmt_fetch($stmt2)) {
	}

	//cancello dunque quelli che eventualmente trovo
	$sql1 = "DELETE FROM tab_orario WHERE ID_ora = ? ;";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "i", $IDfirmatutor_ora);
	mysqli_stmt_execute($stmt1);

	//e poi cancello l'ID_ora del maestro ulteriore
	$sql3 = "DELETE FROM tab_orario WHERE ID_ora = ? ;";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "i", $ID_ora);
	mysqli_stmt_execute($stmt3);

	//in teoria dovrei verificare però se sono rimasti record per la data e ora con secondomaestro_ora = 0
	//Se non ce ne sono uno almeno bisogna settarlo così. Ma che problemi da' non avere alcun secondomaestro_ora = 0 ?
	//forse nel registro?

	$return['test'] = $IDfirmatutor_ora;
    echo json_encode($return);
?>
