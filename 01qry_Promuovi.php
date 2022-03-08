<?include_once("database/databaseii.php");
	$ID_asc = $_POST['ID_asc'];
	$ID_alu = $_POST['ID_alu'];
	$ord_cls=  $_POST['ord_cls'];
	$sezione_cla = $_POST['sezione_cla'];
	//trovo la classe a cui promuovere
	$sql = "SELECT classe_cls FROM tab_classi WHERE ord_cls = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ord_cls);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $classe_cls);
	while (mysqli_stmt_fetch($stmt)) {
	}
	//trovo l'anno scolastico a cui promuovere
	$sql2 = "SELECT annoscolastico_asc FROM tab_anniscolastici WHERE ID_asc = ?";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "i", $ID_asc);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $annoscolastico_asc);
	while (mysqli_stmt_fetch($stmt2)) {
	}	
	//a questo punto devo effettuare tutte le operazioni che sono in 06qry_insertAnnoScolastico...tanto varrebbe usare quella...
	// quindi torno indietro questi valori e poi li passerò sempre dalla funzione Javascript a 06qry_insertAnnoScolastico
	//ecco i parametri che serviranno alla 06qry_InsertAnnoScolastico.php
	$return['ID_alu'] = $ID_alu;
	$return['annoscolastico_asc'] = $annoscolastico_asc;
	$return['classe_cla']= $classe_cls;
	$return['sezione_cla']= $sezione_cla;
    echo json_encode($return);
?>
