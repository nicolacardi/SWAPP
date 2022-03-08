<?include_once("database/databaseii.php");
	//unico parametro la prima data (quella del lunedi) della settimana in cui devo copiare la precedente
	$lunediCancella= $_POST['lunediCancella'];
	$venerdiCancella = date('Y-m-d',strtotime("+4 day", strtotime($lunediCancella)));
	
	$sql1 = "DELETE FROM tab_orario WHERE data_ora BETWEEN ? AND ? ;";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "ss", $lunediCancella, $venerdiCancella);
	mysqli_stmt_execute($stmt1);

	$return['test'] = $sql1;
	echo json_encode($return);	
?>
