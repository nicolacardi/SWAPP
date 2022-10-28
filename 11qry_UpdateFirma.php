<?include_once("database/databaseii.php");
	$ID_ora = $_POST['ID_ora'];
	$ID_mae_ora = $_POST['ID_mae_ora'];
	$firma_mae_ora = $_POST['firma_mae_ora'];
	$compitiassegnati_ora = str_replace("'", "`", $_POST['compitiassegnati_ora']);
	$argomento_ora = str_replace("'", "`", $_POST['argomento_ora']);
	$assente_ora = intval($_POST['assente_ora']);
	$supplente_ora = intval($_POST['supplente_ora']);

	if ($assente_ora == 1){
		$maestroreale_ora = $supplente_ora;
	} else {
		$maestroreale_ora = $ID_mae_ora;
	}
	if ($assente_ora == 0) { $supplente_ora = 0;}

	$sql = "UPDATE tab_orario SET firma_mae_ora = ? , assente_ora = ? , supplente_ora = ? , maestroreale_ora = ?, datafirma_ora= now(), argomento_ora= ?, compitiassegnati_ora= ? WHERE ID_ora = ? ; ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "iiiissi", $firma_mae_ora, $assente_ora, $supplente_ora, $maestroreale_ora, $argomento_ora, $compitiassegnati_ora, $ID_ora);
	mysqli_stmt_execute($stmt);
	
	//ora devo trovare se per caso l'insegnante aveva una pluriclasse! Se è così la firma deve essere messa anche nelle altre ID_ora!
	//trovo l'ora e la data corrispondente a ID_ora (quella per cui si sta firmando)
	$sql = "SELECT data_ora, ora_ora FROM tab_orario WHERE ID_ora = ? ; ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_ora);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $data_ora, $ora_ora);
	while (mysqli_stmt_fetch($stmt)) {
	}

		
	//ora trovo le eventuali altre lezioni dello stesso maestro in altre classi

	$sql = "SELECT ID_ora FROM tab_orario WHERE ID_mae_ora = ? AND ora_ora = ? AND data_ora = ? AND ID_ora <> ?; ";
		$return['test'] =$ID_mae_ora." ".$ora_ora." ".$data_ora." ".$ID_ora." ".$sql;
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "iisi", $ID_mae_ora, $ora_ora, $data_ora, $ID_ora);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ora);
	mysqli_stmt_store_result($stmt);
	$return['altrelezionitrovate'] = "nessun'altra lezione nella stessa ora dello stesso maestro";
	while (mysqli_stmt_fetch($stmt)) {
		$return['altrelezionitrovate'] = "ATTENZIONE: TROVATE ALTRE LEZIONI NELLA STESSA ORA DELLO STESSO MAESTRO";
		
		$sql1 = "UPDATE tab_orario SET firma_mae_ora = ? , assente_ora = ? , supplente_ora = ? , maestroreale_ora = ?, datafirma_ora= now(), argomento_ora= ?, compitiassegnati_ora= ? WHERE ID_ora = ? ; ";
		$stmt1 = mysqli_prepare($mysqli, $sql1);
		mysqli_stmt_bind_param($stmt1, "iiiissi", $firma_mae_ora, $assente_ora, $supplente_ora, $maestroreale_ora, $argomento_ora, $compitiassegnati_ora, $ID_ora);
		mysqli_stmt_execute($stmt1);
	}
	
	
	
	$return['sql'] = $sql;
	echo json_encode($return);
?>
