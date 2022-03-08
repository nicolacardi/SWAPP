<?	include_once("database/databaseii.php");
	$ID_usr = $_POST['ID_usr'];
	$psw = $_POST['psw'];
	$passwordbase = password_hash ($psw, PASSWORD_BCRYPT);
	//$passwordbase = '$2y$10$OJj.7djkgLIqjYlhYaNlvODTXSqM3/P52urcz6wK4VZ9dBvUb9Tke';
	$sql = "UPDATE tab_users SET password_usr= ? , pwdlastchange_usr = now() WHERE ID_usr = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "si", $passwordbase, $ID_usr);
	mysqli_stmt_execute($stmt);
	$return['test']=$sql;
	echo json_encode($return);
?>
