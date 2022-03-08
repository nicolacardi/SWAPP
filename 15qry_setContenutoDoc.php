<?	include_once("database/databaseii.php");
	$ID_doc = $_POST['ID_doc'];
    $contenuto_doc = $_POST['contenuto_doc'];
	$sql = "UPDATE tab_documenti SET contenuto_doc = ? WHERE ID_doc = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "si", $contenuto_doc, $ID_doc);
	mysqli_stmt_execute($stmt);
	$return['test']= "OK";
	echo json_encode($return);
?>
