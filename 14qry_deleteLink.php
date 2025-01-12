<?	include_once("database/databaseii.php");
	
	$ID_lnk = $_POST['ID_lnk'];

	$sql = "DELETE FROM tab_links WHERE ID_lnk = ? ;";	
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_lnk);	
	mysqli_stmt_execute($stmt);

	$return['sql'] = $sql;
    echo json_encode($return);
?>
