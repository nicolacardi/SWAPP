<?include_once("database/databaseii.php");
	$ID_alu_vcc = intval($_POST['ID_alu_vcc']);
	$ID_cov_vcc = intval($_POST['ID_cov_vcc']);
	$sql1 = "DELETE FROM tab_voticompitiverifiche ".
	" WHERE ID_cov_vcc = ? AND ID_alu_vcc = ?;";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "ii", $ID_cov_vcc, $ID_alu_vcc );
	mysqli_stmt_execute($stmt1);
	$return['sql'] = $sql1;
	echo json_encode($return);
?>
