<?	include_once("database/databaseii.php");
	$ID_usr = $_POST['ID_usr'];

	if ($ID_usr == 0) {
		$sql = "UPDATE tab_users SET nonmostrarepiu_usr = 0;";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_execute($stmt);
	} else {
		$nonmostrarepiu_usr = $_POST['nonmostrarepiu_usr'];
		$sql = "UPDATE tab_users SET nonmostrarepiu_usr = ? WHERE ID_usr = ? ;";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "si", $nonmostrarepiu_usr, $ID_usr);
		mysqli_stmt_execute($stmt);
	}
	echo json_encode($return);
?>
