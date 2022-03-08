<?	include_once("database/databaseii.php");
	$ID_alu = $_POST['ID_alu_cla'];
	$annoscolastico = $_POST['annoscolastico_cla'];
	//va cancellato ogni record da tab_classialunni dove ID_alu_cla e annoscolastico_cla
	$sql = "DELETE FROM tab_classialunni ".
	" WHERE ID_alu_cla = ? AND annoscolastico_cla = ?;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "is", $ID_alu, $annoscolastico);
	mysqli_stmt_execute($stmt);
	//va cancellato ogni record (ce ne sono n in quanto ci sono 4 materie alle EL, 12 alle ME, 1 all'AS) da tab_classialunnivoti dove ID_alu_cla e annoscolastico_cla
	$sql = "DELETE FROM tab_classialunnivoti ".
	" WHERE ID_alu_cla = ? AND annoscolastico_cla = ?;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "is", $ID_alu, $annoscolastico);
	mysqli_stmt_execute($stmt);
	//va cancellato ogni record (ce ne sono n in quanto ci sono 9 materie in V e 9 in VIII) da tab_certcompetenze dove ID_alu_cer e annoscolastico_cer
	$sql = "DELETE FROM tab_certcompetenze ".
	" WHERE ID_alu_cer = ? AND annoscolastico_cer = ?;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "is", $ID_alu, $annoscolastico);
	mysqli_stmt_execute($stmt);
	//inoltre va cancellato ogni record in tab_mensilirette dove ID_alu_ret e annoscolastico_ret
	$sql2 = "DELETE FROM tab_mensilirette ".
	" WHERE ID_alu_ret = ? AND annoscolastico_ret = ?;";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "is", $ID_alu, $annoscolastico);
	mysqli_stmt_execute($stmt2);
	//infine va cancellato ogni record in tab_pagamentialtri dove ID_alu_ret e annoscolastico_ret
	// $sql3 = "DELETE FROM tab_pagamentialtri ".
	// " WHERE ID_alu_pga = ? AND annoscolastico_pga = ?;";
	// $stmt3 = mysqli_prepare($mysqli, $sql3);
	// mysqli_stmt_bind_param($stmt3, "is", $ID_alu, $annoscolastico);
	// mysqli_stmt_execute($stmt3);
	$sql35 = "DELETE FROM tab_pagamenti ".
	" WHERE ID_alu_pag = ? AND annoscolastico_pag = ?;";
	$stmt35 = mysqli_prepare($mysqli, $sql35);
	mysqli_stmt_bind_param($stmt35, "is", $ID_alu, $annoscolastico);
	mysqli_stmt_execute($stmt35);

	//infine setto listaattesa_lda = 4 se non ci sono altri anni a cui è iscritto
	//Ora verifico se l'alunno/a è già iscritto per altri anni
	$sql4 = "SELECT ID_alu_cla FROM tab_classialunni WHERE ID_alu_cla = ? AND annoscolastico_cla <> ?";
	$stmt4 = mysqli_prepare($mysqli, $sql4);
	mysqli_stmt_bind_param($stmt4, "is", $ID_alu, $annoscolastico);	
	mysqli_stmt_execute($stmt4);
	mysqli_stmt_bind_result($stmt4, $ID_alu1);
	$rows1 = 0;
	while (mysqli_stmt_fetch($stmt4)) {
		$rows1++;
	}
	if ($rows1 == 0) {
		$sql4 = "UPDATE tab_listadattesa SET accolto_lda = 4 WHERE ID_alu_lda = ?;";
		$stmt4 = mysqli_prepare($mysqli, $sql4);
		mysqli_stmt_bind_param($stmt4, "i", $ID_alu);	
		mysqli_stmt_execute($stmt4);
	}
	
	$return['msg'] = "Cancellazione a buon fine";
	$return['sql'] = $sql;
	$return['sql3'] = $sql3;
	$return['ID_alu'] = $ID_alu;
	$return['annoscolastico'] = $annoscolastico;
	echo json_encode($return);
?>
