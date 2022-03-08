<?include_once("database/databaseii.php");
	$ID_usr= $_POST['ID_usr'];
	$sql = "SELECT nonmostrarepiu_usr, nome_mae FROM tab_anagraficamaestri LEFT JOIN tab_users ON ID_usr_mae = ID_usr WHERE ID_usr = ?;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_usr);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $nonmostrarepiu_usr, $nome_mae);
	while (mysqli_stmt_fetch($stmt)) {
	}
	$return['nonmostrarepiu_usr'] = $nonmostrarepiu_usr;
	echo json_encode($return);