<?include_once("database/databaseii.php");
	
	$ID_cma_mae = $_POST['ID_mae'];
	$ID_mae = $ID_cma_mae;
	
	//cancello tutti i record da tab_classimaestri
	$sql = "DELETE FROM tab_classimaestri ".
	" WHERE ID_mae_cma = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_cma_mae);	
	mysqli_stmt_execute($stmt);
	
	/*
	//bisogna anche cancellare l'utente in tab_users - IN VERITA' NON E' NECESSARIO: quello può restare!
	//trovo quindi prima l'ID_usr del maestro
	$sql2 = "SELECT ID_usr_mae FROM tab_anagraficamaestri ".
	" WHERE ID_mae = ? ;";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "i", $ID_mae);	
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $ID_usr_maeTMP);
	while (mysqli_stmt_fetch($stmt2)) {
		$ID_usr = $ID_usr_maeTMP;
	}
	//cancello da tab_users
	$sql3 = "DELETE FROM tab_users ".
	" WHERE ID_usr = ? ;";	
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "i", $ID_usr);	
	mysqli_stmt_execute($stmt3);*/
	
	//cancello da tab_anagraficamaestri
	$sql4 = "DELETE FROM tab_anagraficamaestri ".
	" WHERE ID_mae = ? ;";	
	$stmt4 = mysqli_prepare($mysqli, $sql4);
	mysqli_stmt_bind_param($stmt4, "i", $ID_mae);	
	mysqli_stmt_execute($stmt4);

	echo json_encode($return);
?>
