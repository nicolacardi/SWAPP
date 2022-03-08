<?	include_once("database/databaseii.php");
	$sql = "UPDATE tab_mensilirette SET flag_invio_dati = 0;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
    echo json_encode($return);
?>
