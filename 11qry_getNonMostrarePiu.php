<?include_once("database/databaseii.php");
	$ID_usr= $_POST['ID_usr'];
	$sql = "SELECT nonmostrarepiu_usr FROM tab_users WHERE ID_usr = ?;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_usr);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $nonmostrarepiu_usr);
	while (mysqli_stmt_fetch($stmt)) {
	}
	$return['nonmostrarepiu_usr'] = $nonmostrarepiu_usr;
	echo json_encode($return);