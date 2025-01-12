<?include_once("database/databaseii.php");
include_once("assets/functions/functions.php");

	$num_ver = $_POST['num_ver'];
	$sql = "SELECT DISTINCT data_ver, ora_ver, tipo_ver, iddocenti_ver, idalunni_ver, invitatiult_ver, titolo_ver, classe_ver, sezione_ver FROM tab_verbali WHERE num_ver = ? ; ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $num_ver);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $data_ver, $ora_ver, $tipo_ver, $iddocenti_ver, $idalunni_ver, $invitatiult_ver, $titolo_ver, $classe_ver, $sezione_ver);
	while (mysqli_stmt_fetch($stmt)) {
	}
	$return['sql'] = $sql;
	$return['data_ver'] = timestamp_to_ggmmaaaa($data_ver);
	$return['ora_ver'] =date( 'G:i', strtotime($ora_ver));
	$return['tipo_ver'] = $tipo_ver;
	$return['iddocenti_ver'] = $iddocenti_ver;
	$return['idalunni_ver'] = $idalunni_ver;
	$return['invitatiult_ver'] = $invitatiult_ver;
	$return['titolo_ver'] = stripslashes($titolo_ver);
	$return['classe_ver'] = $classe_ver;
	$return['sezione_ver'] = $sezione_ver;
	
	echo json_encode($return);
?>
