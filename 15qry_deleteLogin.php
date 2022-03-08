<? include_once("database/databaseii.php");
	$ID_usr = $_POST['ID_usr'];
	//Verifico se c'è un maestro associato a questa user
	$sql2 = "SELECT ID_mae FROM tab_anagraficamaestri WHERE ID_usr_mae = ? ;";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "i", $ID_usr);	
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $ID_mae);
	$k =0;
	while (mysqli_stmt_fetch($stmt2)) {
		$k++;
	}
	if ($k == 0) {
		//cancello da tab_users
		$sql3 = "DELETE FROM tab_users ".
		" WHERE ID_usr = ? ;";	
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		mysqli_stmt_bind_param($stmt3, "i", $ID_usr);	
		mysqli_stmt_execute($stmt3);
		$return['msg'] = "Cancellazione utente effettuata";
	} else {
		$return['msg'] = "Esiste un profilo associato a questo utente: cancellare prima quello dall'Anagrafica Maestri & C";
	}
    echo json_encode($return);
?>
