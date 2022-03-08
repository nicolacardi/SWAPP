<?	include_once("database/databaseii.php");
	$ID_par = $_POST['ID_par'];
	$val_par = $_POST['val_par'];
	$descrizione = $_POST['descrizione'];
	$sql = "UPDATE tab_parametri SET val_par = ?, descrizione = ? WHERE ID_par = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssi", $val_par, $descrizione, $ID_par);
	mysqli_stmt_execute($stmt);
	$return['test']=$sql." valore:".$val_par." ID parametro:".$ID_par." descrizione:".$descrizione;
	echo json_encode($return);
?>
