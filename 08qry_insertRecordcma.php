<?include_once("database/databaseii.php");
	$ID_mae_cma = $_POST['ID_mae_cma'];
	$annoscolastico_cma = $_POST['annoscolastico_cma'];
	$classe_cma = $_POST['classe_cma'];
	$sezione_cma = $_POST['sezione_cma'];
	$ruolo_cma = $_POST['ruolo_cma'];
	$codmat_cma = $_POST['codmat_cma'];
	$tutor_cma = intval($_POST['tutor_cma']);
	// $sql = "SELECT aselme_cls FROM tab_classi WHERE classe_cls = ?;";
	// $stmt = mysqli_prepare($mysqli, $sql);
	// mysqli_stmt_bind_param($stmt, "s", $classe_cma);	
	// mysqli_stmt_execute($stmt);
	// mysqli_stmt_bind_result($stmt, $aselme_cls );
	// while (mysqli_stmt_fetch($stmt)) {
	// 	$aselme_cma = $aselme_cls;
	// }
	// $sql2 = "INSERT INTO tab_classimaestri (id_mae_cma, annoscolastico_cma, ruolo_cma, tutor_cma, codmat_cma, classe_cma, sezione_cma, aselme_cma) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
	// $stmt2 = mysqli_prepare($mysqli, $sql2);
	// mysqli_stmt_bind_param($stmt2, "ississss", $ID_mae_cma, $annoscolastico_cma, $ruolo_cma, $tutor_cma, $codmat_cma, $classe_cma, $sezione_cma, $aselme_cma );	
	// mysqli_stmt_execute($stmt2);

	// //210207 inserisco un record ANCHE per il TUTOR in cui valorizzo tutor_cma = 0 e tutordi con ID_mae_cma
	// if ($tutor_cma != 0 ) {
	// 	$sql2 = "INSERT INTO tab_classimaestri (id_mae_cma, annoscolastico_cma, ruolo_cma, tutor_cma, tutordi_cma, codmat_cma, classe_cma, sezione_cma, aselme_cma) VALUES (?, ?, ?, 0, ?, ?, ?, ?, ?)";
	// 	$stmt2 = mysqli_prepare($mysqli, $sql2);
	// 	mysqli_stmt_bind_param($stmt2, "ississss", $tutor_cma, $annoscolastico_cma, $ruolo_cma, $ID_mae_cma, $codmat_cma,  $classe_cma, $sezione_cma, $aselme_cma );	
	// 	mysqli_stmt_execute($stmt2);
	// }

	$sql2 = "INSERT INTO tab_classimaestri (id_mae_cma, annoscolastico_cma, ruolo_cma, tutor_cma, codmat_cma, classe_cma, sezione_cma) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "ississs", $ID_mae_cma, $annoscolastico_cma, $ruolo_cma, $tutor_cma, $codmat_cma, $classe_cma, $sezione_cma );	
	mysqli_stmt_execute($stmt2);

	//210207 inserisco un record ANCHE per il TUTOR in cui valorizzo tutor_cma = 0 e tutordi con ID_mae_cma
	if ($tutor_cma != 0 ) {
		$sql2 = "INSERT INTO tab_classimaestri (id_mae_cma, annoscolastico_cma, ruolo_cma, tutor_cma, tutordi_cma, codmat_cma, classe_cma, sezione_cma) VALUES (?, ?, ?, 0, ?, ?, ?, ?)";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "ississs", $tutor_cma, $annoscolastico_cma, $ruolo_cma, $ID_mae_cma, $codmat_cma,  $classe_cma, $sezione_cma );	
		mysqli_stmt_execute($stmt2);
	}





	$return['msg'] = "Inserimento materia di insegnamento completato con successo";
	$return['sql2'] = $sql2;
	$return['sql'] = $sql;
    echo json_encode($return);
?>
