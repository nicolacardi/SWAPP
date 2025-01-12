<?	include_once("database/databaseii.php");
	$ID_doc = $_POST['ID_doc'];
	$titolo_doc = $_POST['titolo_doc'];
	$descrizione_doc = $_POST['descrizione_doc'];
	$sql = "UPDATE tab_documenti SET titolo_doc = ?, descrizione_doc = ? WHERE ID_doc = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssi", $titolo_doc, $descrizione_doc, $ID_doc);
	mysqli_stmt_execute($stmt);
	$return['test']=$sql." titolo_doc:".$titolo_doc." ID ID_doc:".$ID_doc." descrizione_doc:".$descrizione_doc;
	echo json_encode($return);
?>
