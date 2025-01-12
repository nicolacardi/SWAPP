<?include_once("database/databaseii.php");
	
	$nome_alu = addslashes($_POST['nome_alu_new']);
	$cognome_alu = addslashes($_POST['cognome_alu_new']);
	
	$sql3 = "SELECT ID_alu FROM tab_anagraficaalunni WHERE nome_alu = ? AND cognome_alu = ? ;";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "ss", $nome_alu, $cognome_alu);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_bind_result($stmt3, $ID_alu);
	$k = 0;
	while (mysqli_stmt_fetch($stmt3)) {
		$k++;
	}
	$return['test'] = $k;
     echo json_encode($return);
?>
