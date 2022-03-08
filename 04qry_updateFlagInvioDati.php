<?	include_once("database/databaseii.php");
	$ID_ret = $_POST['ID_ret'];
    $flagInvioDatiVal =  $_POST['flagInvioDatiVal'];
    if ($flagInvioDatiVal== "true") { $flagNumInvioDatiVal  = 1 ;} else { $flagNumInvioDatiVal  = 0;}
	$sql = "UPDATE tab_mensilirette SET flag_invio_dati = ? WHERE ID_ret = ?;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ii", $flagNumInvioDatiVal, $ID_ret);
	mysqli_stmt_execute($stmt);

	if ($flagInvioDati == "false") {
		$sql = "UPDATE tab_mensilirette SET metodopag_ret = 1 WHERE ID_ret = ?;";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "i", $ID_ret);
		mysqli_stmt_execute($stmt);
	}

	$return['test']=$flagInvioDatiVal;
    echo json_encode($return);
?>
