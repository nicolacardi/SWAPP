<?	include_once("database/databaseii.php");
	$ora_ver_new = $_POST['ora_ver_new'];
	$data_ver_new = $_POST['data_ver_new'];
	$data_ver_new = str_replace('/', '-', $data_ver_new);
	$data_ver_new = date('Y-m-d', strtotime($data_ver_new));
	$selectedTipo = $_POST['selectTipo'];
	$selectedInsegnanti = $_POST['selectedInsegnanti'];
	$selectedGenitori = $_POST['selectedGenitori'];
	$invitatiult_ver_new = $_POST['invitatiult_ver_new'];
	$titolo_ver_new = $_POST['titolo_ver_new'];
	$argnum_ver_new = $_POST['argnum_ver_new0'];
	$txtargomentoaltro_ver = $_POST['txtargomentoaltro_ver'];

	$tematiche_new = addslashes(str_replace("”", "''", str_replace("“", "''", str_replace("‘", "'", str_replace("’", "'", $_POST['tematiche_new'])))));
	//$tematiche_new = $_POST['tematiche_new'];
	$decisioni_new = addslashes(str_replace("”", "''", str_replace("“", "''", str_replace("‘", "'", str_replace("’", "'", $_POST['decisioni_new'])))));
	//$decisioni_new = $_POST['decisioni_new'];
	$annoscolastico_ver = $_POST['annoscolastico_ver'];
	$classe_ver = $_POST['classe_ver'];
	$sezione_ver = $_POST['sezione_ver'];
	$num_ver = $_POST['num_ver'];
	if ($num_ver == "..") {
		//se è un verbale nuovo devo trovare il massimo di num_ver e inserire il nuovo record con num_ver = max+1
		$sql = "SELECT MAX(num_ver) AS max_num_ver FROM tab_verbali  ";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $max_num_ver);
		while (mysqli_stmt_fetch($stmt)) {
		}
		$next_num_ver = intval($max_num_ver) + 1;
	} else {
		$next_num_ver = $num_ver;
	}

	///nella tabella verbali viene inserito un record per ogni argomento, anche a parità di num_ver
	//per questo, per sapere che numtipo_ver non devo solo trovare il massimo, devo anche capire se il num_ver che sto inserendo esiste già
	$sqlNumContaNumVer ="SELECT num_ver, numtipo_ver FROM  tab_verbali WHERE num_ver = ?";
	$stmt = mysqli_prepare($mysqli, $sqlNumContaNumVer);
	mysqli_stmt_bind_param($stmt, "i", $next_num_ver);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $num_vertest, $numtipo_vertest);
	$n = 0;
	while (mysqli_stmt_fetch($stmt)) {
		$n++;
	} 
	//a questo punto se $n = 0 è il primo inserimento altrimenti sto inserendo altri argomenti in un verbale esistente

	//calcolo il massimo numero del tipo/annoscolastico/classe
	$sqlNumtipo ="SELECT MAX(numtipo_ver) FROM  tab_verbali WHERE classe_ver = ? AND annoscolastico_ver = ? AND tipo_ver = ? ";
	$stmt = mysqli_prepare($mysqli, $sqlNumtipo);
	mysqli_stmt_bind_param($stmt, "ssi", $classe_ver, $annoscolastico_ver, $selectedTipo);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $numtipo_ver);
	while (mysqli_stmt_fetch($stmt)) {} 
	if ($numtipo_ver == null) {$numtipo_ver = 0;}
	//sommo uno e vado ad inserire in numtipo_ver

	if ($n==0) {
		//è il primo inserimento di un verbale ($n = 0)
		$next_numtipo_ver = $numtipo_ver +1;
	}  else {
		//è un nuovo inserimento di un argomento in un verbale esistente
		$next_numtipo_ver = $numtipo_vertest;
	}


	$sql = "INSERT INTO tab_verbali (num_ver, numtipo_ver, data_ver, ora_ver, tipo_ver, iddocenti_ver, idalunni_ver, invitatiult_ver, titolo_ver, argnum_ver, argomento_ver, tematiche_ver, decisioni_ver, annoscolastico_ver, classe_ver, sezione_ver) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ?, ? , ? , ? , ? , ? , ? , ?)";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "iississssissssss", $next_num_ver, $next_numtipo_ver, $data_ver_new, $ora_ver_new, $selectedTipo, $selectedInsegnanti, $selectedGenitori, $invitatiult_ver_new, $titolo_ver_new, $argnum_ver_new, $txtargomentoaltro_ver, $tematiche_new , $decisioni_new , $annoscolastico_ver , $classe_ver, $sezione_ver);
	mysqli_stmt_execute($stmt);
	$return['sql'] = $sqlNumtipo;
	$return['test'] = "next_num_ver ".$next_num_ver." -classe_ver ".$classe_ver." -annoscolastico_ver".$annoscolastico_ver." -selectedTipo".$selectedTipo;
	echo json_encode($return);
?>
