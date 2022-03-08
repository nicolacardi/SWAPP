<?include_once("database/databaseii.php");
	
	$ID_alu_cla = $_POST['ID_alu_lda'];
	$annoscolastico_cla = $_POST['annoscolastico_lda'];
	//verifico anzitutto se l'alunno/a è già iscritto per l'anno selezionato
	$sql = "SELECT ID_alu_cla, listaattesa_cla FROM tab_classialunni WHERE ID_alu_cla = ? AND annoscolastico_cla = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "is", $ID_alu_cla, $annoscolastico_cla);	
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu, $listaattesa_cla);
	$rows = 0;
	while (mysqli_stmt_fetch($stmt)) {
		$rows++;
	}
	// if ($rows != 0) { $giaiscritto = true; } else {$giaiscritto = false ;}
	// if ($listaattesa_cla == 1) { $listaattesa_cla = true; } else {$listaattesa_cla = false ;}

	if ($rows != 0) { 
		if ($listaattesa_cla == 1) {
			$giaiscritto = true;
			$listaattesa_cla = true;
		} else {
			$giaiscritto = true;
			$listaattesa_cla = false;
		}
	} else {
		$giaiscritto = false;
		$listaattesa_cla = false;
	}


	//verifico ora se l'alunno/a è già iscritto per altri anni
	$sql1 = "SELECT ID_alu_cla, listaattesa_cla FROM tab_classialunni WHERE ID_alu_cla = ? AND annoscolastico_cla <> ? ;";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "is", $ID_alu_cla, $annoscolastico_cla);	
	mysqli_stmt_execute($stmt1);
	mysqli_stmt_bind_result($stmt1, $ID_alu, $listaattesa_cla);
	$rows = 0;
	while (mysqli_stmt_fetch($stmt1)) {
		$rows++;
	}
	if ($rows != 0) { 
		if ($listaattesa_cla == 1) {
			$giaiscrittoaltrianni = true;
			$giainaltralistaattesa = true;
		} else {
			$giaiscrittoaltrianni = true;
			$giainaltralistaattesa = false;
		}
	} else {
		$giaiscrittoaltrianni = false;
		$giainaltralistaattesa = false;
	}







	// //Ora verifico se l'alunno/a è già iscritto per altri anni ma non in lista d'attesa
	// $sql1 = "SELECT ID_alu_cla FROM tab_classialunni WHERE ID_alu_cla = ? AND annoscolastico_cla <> ? AND listaattesa_cla = 0;";
	// $stmt1 = mysqli_prepare($mysqli, $sql1);
	// mysqli_stmt_bind_param($stmt1, "is", $ID_alu_cla, $annoscolastico_cla);	
	// mysqli_stmt_execute($stmt1);
	// mysqli_stmt_bind_result($stmt1, $ID_alu1);
	// $rows1 = 0;
	// while (mysqli_stmt_fetch($stmt1)) {
	// 	$rows1++;
	// }
	// if ($rows1 != 0) { $giaiscrittoaltrianni = true; } else {$giaiscrittoaltrianni = false ;}
	// //Infine verifico se l'alunno/a è già in una lista d'attesa: ne consentiamo una sola
	// $sql2 = "SELECT ID_alu_cla FROM tab_classialunni WHERE ID_alu_cla = ? AND annoscolastico_cla <> ? AND listaattesa_cla = 1;";
	// $stmt2 = mysqli_prepare($mysqli, $sql2);
	// mysqli_stmt_bind_param($stmt2, "is", $ID_alu_cla, $annoscolastico_cla);	
	// mysqli_stmt_execute($stmt2);
	// mysqli_stmt_bind_result($stmt2, $ID_alu2);
	// $rows2 = 0;
	// while (mysqli_stmt_fetch($stmt2)) {
	// 	$rows2++;
	// }
	// if ($rows2 != 0) { $giainaltralistaattesa = true; } else {$giainaltralistaattesa = false ;}
	$return['giaiscritto'] = $giaiscritto; 				//anno specifico
	$return['listaattesa'] = $listaattesa_cla;			//anno specifico
	$return['giaiscrittoaltrianni'] = $giaiscrittoaltrianni;	//altri anni
	$return['giainaltralistaattesa'] = $giainaltralistaattesa;	//altri anni

	//$return['test'] = "iscrizioni altri anni:".$rows1." sql1:".$sql1." ".$ID_alu_cla. " ".$annoscolastico_cla  ;
	$return ['test'] =  $sql1."--rows1--".$rows1;
    echo json_encode($return);
?>
