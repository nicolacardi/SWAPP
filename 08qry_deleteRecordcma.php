<?include_once("database/databaseii.php");
	$ID_cma = $_POST['ID_cma'];

	//vedo se c'è un tutoredda (tutor_cma) in quest'ora perchè anche lui devo cancellare
	//guardo al campo tutor_cma che mostra "da chi è tutorato" l'insegnante in questa materia, in questa classe sezione in quest'anno scolastico
	$sql3 = "SELECT tutor_cma, classe_cma, sezione_cma, codmat_cma, annoscolastico_cma FROM tab_classimaestri WHERE ID_cma = ? ;";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "i", $ID_cma);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_bind_result($stmt3, $tutor_cma, $classe_cma, $sezione_cma, $codmat_cma, $annoscolastico_cma);
	while (mysqli_stmt_fetch($stmt3)) {
	}

	$sql2 = "DELETE FROM tab_classimaestri WHERE ID_mae_cma = ? AND classe_cma = ? AND  sezione_cma = ? AND codmat_cma = ? AND annoscolastico_cma = ?;";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "issss", $tutor_cma, $classe_cma, $sezione_cma, $codmat_cma, $annoscolastico_cma);	
	mysqli_stmt_execute($stmt2);


	//ora vedo se questo è tutordi qualcuno perchè in quel caso va segnato 0 su tutor_cma a quello
	$sql3 = "SELECT tutordi_cma, classe_cma, sezione_cma, codmat_cma, annoscolastico_cma FROM tab_classimaestri WHERE ID_cma = ? ;";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "i", $ID_cma);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_bind_result($stmt3, $tutordi_cma, $classe_cma, $sezione_cma, $codmat_cma, $annoscolastico_cma);
	while (mysqli_stmt_fetch($stmt3)) {
	}

	$sql2 = "UPDATE tab_classimaestri SET tutor_cma = 0 WHERE ID_mae_cma = ? AND classe_cma = ? AND  sezione_cma = ? AND codmat_cma = ? AND annoscolastico_cma = ?;";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "issss", $tutordi_cma, $classe_cma, $sezione_cma, $codmat_cma, $annoscolastico_cma);	
	mysqli_stmt_execute($stmt2);






	//e adesso cancello il record con ID_cma
	$sql = "DELETE FROM tab_classimaestri ".
	" WHERE ID_cma = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_cma);	
	mysqli_stmt_execute($stmt);



	$return['sql'] = $sql;
	$return['ID_cma'] = $ID_cma;
    echo json_encode($return);
?>
