<?	include_once("database/databaseii.php");
	$num_ver = $_POST['num_ver'];
	$sql = "DELETE FROM tab_verbali WHERE num_ver = ? ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $num_ver);
	mysqli_stmt_execute($stmt);
	$return['sql'] = $sql;
    echo json_encode($return);
?>
