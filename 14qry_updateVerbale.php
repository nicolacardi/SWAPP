<?include_once("database/databaseii.php");
	$ID_ver = $_POST['ID_ver'];
	$ora_ver_new = $_POST['ora_ver_new'];
	$data_ver_new = $_POST['data_ver_new'];
	$data_ver_new = str_replace('/', '-', $data_ver_new);
	$data_ver_new = date('Y-m-d', strtotime($data_ver_new));
	$selectedTipo = $_POST['selectTipo'];
	$selectedInsegnanti = $_POST['selectedInsegnanti'];
	$selectedGenitori = $_POST['selectedGenitori'];
	$invitatiult_ver_new = $_POST['invitatiult_ver_new'];
	$titolo_ver_new = $_POST['titolo_ver_new'];
	$argnum_ver_new = $_POST['argnum_ver_new'];
	$txtargomentoaltro_ver = $_POST['txtargomentoaltro_ver'];
	$tematiche_new = $_POST['tematiche_new'];
	$decisioni_new = $_POST['decisioni_new'];
	$annoscolastico_ver = $_POST['annoscolastico_ver'];
	$classe_ver = $_POST['classe_ver'];
	$sezione_ver = $_POST['sezione_ver'];

	$sql = "UPDATE tab_verbali SET 
	data_ver = ?,
	ora_ver = ?,
	tipo_ver = ?,
	iddocenti_ver = ?,
	idalunni_ver = ?,
	invitatiult_ver = ?,
	titolo_ver = ?,
	argnum_ver = ?,
	argomento_ver = ?,
	tematiche_ver = ?,
	decisioni_ver = ?,
	annoscolastico_ver = ?,
	classe_ver = ?,
	sezione_ver = ?
	WHERE ID_ver = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssissssissssssi", $data_ver_new, $ora_ver_new, $selectedTipo, $selectedInsegnanti, $selectedGenitori, $invitatiult_ver_new, $titolo_ver_new, $argnum_ver_new, $txtargomentoaltro_ver, $tematiche_new, $decisioni_new, $annoscolastico_ver, $classe_ver, $sezione_ver, $ID_ver );
	mysqli_stmt_execute($stmt);
	$return['sql'] = $sql;
    echo json_encode($return);
?>
