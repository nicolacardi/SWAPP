<?	include_once("database/databaseii.php");
	$ID_doc = $_POST['ID_doc'];
	$descrizione_doc = $_POST['descrizione_doc'];

	$sql = "UPDATE tab_documenti SET  descrizione_doc = ? WHERE ID_doc = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "si", $descrizione_doc, $ID_doc);
	mysqli_stmt_execute($stmt);
	$return['test']=$sql." ID doc:".$ID_doc." descrizione_doc:".$descrizione_doc;
	echo json_encode($return);
?>
