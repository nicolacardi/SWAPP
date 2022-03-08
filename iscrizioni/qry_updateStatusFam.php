<? 
	include_once("../database/databaseBii.php");

	$status = $_POST['status'];
	
	$sql = "SELECT iscrizionecompleta_fam FROM tab_famiglie WHERE ID_fam = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $_SESSION['ID_fam']);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $iscrizionecompleta_fam);
	while (mysqli_stmt_fetch($stmt)) {
	}
	
	if ($iscrizionecompleta_fam < $status) {
		$sql2 = "UPDATE tab_famiglie SET iscrizionecompleta_fam = ? WHERE ID_fam = ? ";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "ii", $status, $_SESSION['ID_fam']);
		mysqli_stmt_execute($stmt2);
	}

	if ($status == 100) {
		$sql3 = "UPDATE tab_famiglie SET iscrizioneinviata_fam = 1 WHERE ID_fam = ? ";
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		mysqli_stmt_bind_param($stmt3, "i", $_SESSION['ID_fam']);
		mysqli_stmt_execute($stmt3);
	}
	$return['sql'] = "iscrizionecompleta_fam da db:".$iscrizionecompleta_fam. " status da inserire:".$status. " sql:". $sql. " sql2:". $sql2;
	echo json_encode($return);
    
?>