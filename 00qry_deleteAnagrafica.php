<?include_once("database/databaseii.php");
	
	$ID_alu = $_POST['ID_alu'];
	
	//devo cancellare tutte le occorrenze di ID_alu (ID_alu_cla) in tab_classialunni
	$sql1 = "DELETE FROM tab_classialunni ".
	" WHERE ID_alu_cla = ? ;";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "i", $ID_alu);
	mysqli_stmt_execute($stmt1);
	
	//devo cancellare tutte le occorrenze di ID_alu (ID_alu_cla) in tab_classialunnivoti
	$sql1 = "DELETE FROM tab_classialunnivoti ".
	" WHERE ID_alu_cla = ? ;";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "i", $ID_alu);
	mysqli_stmt_execute($stmt1);
	
	//devo cancellare tutte le occorrenze di ID_alu (ID_alu_ret) in tab_mensilirette
	$sql2 = "DELETE FROM tab_mensilirette ".
	" WHERE ID_alu_ret = ? ;";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "i", $ID_alu);
	mysqli_stmt_execute($stmt2);
	
	//devo cancellare tutte le occorrenze di ID_alu (ID_alu_pag) in tab_pagamenti
	$sql25 = "DELETE FROM tab_pagamenti ".
	" WHERE ID_alu_pag = ?;";
	$stmt25 = mysqli_prepare($mysqli, $sql25);
	mysqli_stmt_bind_param($stmt25, "i", $ID_alu);
	mysqli_stmt_execute($stmt25);

	//devo verificare se ci sono altri fratelli perchè se ce ne sono tengo la famiglia altrimenti cancello anche quella
	$sql3 = "SELECT ID_fam_alu FROM tab_anagraficaalunni ".
	" WHERE ID_alu = ? ;";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "i", $ID_alu);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_bind_result($stmt3, $ID_fam_aluTMP);
	while (mysqli_stmt_fetch($stmt3)) {
		$ID_fam_alu = $ID_fam_aluTMP;
	}
	$return['sql3']= $sql3;
	$return['ID_fam_alu']= $ID_fam_alu;
	
	//conto quanti fratelli
	$sql4 = "SELECT ID_alu FROM tab_anagraficaalunni ".
	" WHERE ID_fam_alu = ? ;";
	$stmt4 = mysqli_prepare($mysqli, $sql4);
	mysqli_stmt_bind_param($stmt4, "i", $ID_fam_alu);
	mysqli_stmt_execute($stmt4);
	
	$fratelli = 0;
	while (mysqli_stmt_fetch($stmt4)) {
		$fratelli++;
	}
	$return['sql4']= $sql4;
	$return['fratelli']= $fratelli;
	
	//se NON ci sono fratelli ($fratelli=1) cancello in tab_famiglie (ID_fam)
	if ($fratelli == 1 ) {
			$sql5 = "DELETE FROM tab_famiglie ".
			" WHERE ID_fam = ? ;";
			$stmt5 = mysqli_prepare($mysqli, $sql5);
			mysqli_stmt_bind_param($stmt5, "i", $ID_fam_alu);
			mysqli_stmt_execute($stmt5);
	}
	$return['sql5']= $sql5;
	
	//infine devo cancellare in tab_anagraficaalunni (ID_alu)
	
	$sql6 = "DELETE FROM tab_anagraficaalunni ".
	" WHERE ID_alu = ? ;";
	
	$stmt6 = mysqli_prepare($mysqli, $sql6);
	mysqli_stmt_bind_param($stmt6, "i", $ID_alu);
	mysqli_stmt_execute($stmt6);
	
	$return['msg'] = "Cancellazione dell'alunno/a". $nome_alu . " " . $cognome_alu ." a buon fine";
	
	echo json_encode($return);
?>
