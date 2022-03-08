<?	include_once("database/databaseii.php");
	$ID_doc = $_POST['ID_doc'];
	$sql = "SELECT contenuto_doc FROM tab_documenti WHERE ID_doc = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "i", $ID_doc);
	mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $contenuto_doc);
    while (mysqli_stmt_fetch($stmt)){
    }
	$return['contenuto_doc']= $contenuto_doc;
	echo json_encode($return);
?>
