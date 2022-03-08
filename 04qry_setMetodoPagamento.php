<?include_once("database/databaseii.php");
	//si presume che il record sia già presente in DB: questo perchè DEVE essere stato creato e gestito in fase di creazione della frequenza dell'alunno...
	$ID_ret = intval($_POST['ID_ret']);
	$metodopag_ret = intval($_POST['metodopag_ret']);

	$sql = "UPDATE tab_mensilirette SET metodopag_ret = ? WHERE ID_ret = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ii", $metodopag_ret, $ID_ret);
	mysqli_stmt_execute($stmt);
    $return['test'] = $ID_ret."-".$metodopag_ret;
	echo json_encode($return);
?>
