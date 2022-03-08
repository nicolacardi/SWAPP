<?include_once("database/databaseii.php");
	//unico parametro la prima data (quella del lunedi) della settimana in cui devo copiare la precedente
	$data_ora= $_POST['data_ora'];
	$classe_ora= $_POST['classe_ora'];

	$sql1 = "DELETE FROM tab_orario WHERE data_ora = ? AND classe_ora = ?;";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "ss", $data_ora, $classe_ora);
	mysqli_stmt_execute($stmt1);

	$return['test'] = $sql1;
	echo json_encode($return);	
?>
