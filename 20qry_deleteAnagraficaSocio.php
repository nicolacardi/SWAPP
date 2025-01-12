<?include_once("database/databaseii.php");
	
	$ID_soc = $_POST['ID_soc'];
	
	$sql = "SELECT ID_fam_soc, padremadre_soc FROM tab_anagraficasoci WHERE ID_soc = ? ";

	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_soc);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_fam_soc, $padremadre_soc);
	while (mysqli_stmt_fetch($stmt)) {
	}


	//cancello da tab_anagraficasoci
	$sql1 = "DELETE FROM tab_anagraficasoci ".
	" WHERE ID_soc = ? ;";	
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "i", $ID_soc);	
	mysqli_stmt_execute($stmt1);

	//devo anche aggiornare in tab_famiglie sociopadre o sociomadre

	if ($ID_fam_soc != '') {
		$sql2 = "UPDATE tab_famiglie SET socio".$padremadre_soc."_fam = 0 WHERE ID_fam = ?";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "i", $ID_fam_soc);	
		mysqli_stmt_execute($stmt2);

		//E' necessario ANCHE in database B allineare. Questo perchè qui si arriva anche in fase di eliminazione dall'importazione dei dati
		$sql3 = "UPDATE ".$_SESSION['databaseB'].".tab_famiglie SET socio".$padremadre_soc."_fam = 0 WHERE ID_fam = ?";
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		mysqli_stmt_bind_param($stmt3, "i", $ID_fam_soc);	
		mysqli_stmt_execute($stmt3);
	}
	echo json_encode($return);
?>
