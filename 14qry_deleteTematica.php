<?include_once("database/databaseii.php");
	$ID_ver = $_POST['ID_ver'];
	$sql = "DELETE FROM tab_verbali WHERE ID_ver = ? ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_ver);
	mysqli_stmt_execute($stmt);
	$return['sql'] = $sql;
    echo json_encode($return);
?>
