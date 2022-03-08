<?include_once("database/databaseii.php");
	$ID_cov = intval($_POST['ID_cov']);
	$sql1 = "DELETE FROM tab_compitiverifiche ".
	" WHERE ID_cov = ? ;";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "i", $ID_cov);
	mysqli_stmt_execute($stmt1);
	$sql1 = "DELETE FROM tab_voticompitiverifiche ".
	" WHERE ID_cov_vcc = ? ;";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "i", $ID_cov);
	mysqli_stmt_execute($stmt1);
	$return['msg'] = "Cancellazione del compito a buon fine";
	echo json_encode($return);
?>
