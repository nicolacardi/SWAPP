<?include_once("database/databaseii.php");
	
	$ID_doc = $_POST['ID_doc'];
	
	$sql6 = "DELETE FROM tab_documenti WHERE ID_doc = ? ;";
	
	$stmt6 = mysqli_prepare($mysqli, $sql6);
	mysqli_stmt_bind_param($stmt6, "i", $ID_doc);
	mysqli_stmt_execute($stmt6);
	
	$return['msg'] = "Cancellazione del documento a buon fine";
	
	echo json_encode($return);
?>
