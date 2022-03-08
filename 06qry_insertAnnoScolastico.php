<?include_once("database/databaseii.php");
	
	$ID_alu_cla = $_POST['ID_alu_cla'];
	$annoscolastico_asc = $_POST['annoscolastico_asc'];
	$classe_cla = $_POST['classe_cla'];
	$sezione_cla = $_POST['sezione_cla'];
	$bocciato = $_POST['bocciato'];
	if ($_POST['scalino']) {$scalino = 1;} else {$scalino = 0;}
	$return['result']= "NOTOK";

	//ListaDattesa può essere solo false questo check è un retaggio di un modo precedente di inserire che non viene più usato
	//Dunque $ListaDattesa è sempre = 0
	if ($_POST['ListaDAttesa'] == 'true') {$ListaDAttesa = 1;} else {$ListaDAttesa = 0;};  
	//verifico anzitutto se l'alunno/a è già iscritto per l'anno in corso
	$sql1 = "SELECT ID_alu_cla FROM tab_classialunni WHERE ID_alu_cla = ? AND annoscolastico_cla = ? ;";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "is", $ID_alu_cla, $annoscolastico_asc);	
	mysqli_stmt_execute($stmt1);
	$rowssql = 0;
	while (mysqli_stmt_fetch($stmt1)) {
		$rowssql++;
	}
	
	if ($rowssql == 0) {
		//se non è iscritto per l'anno scolastico selezionato allora proseguo
		//Verifico se si sta iscrivendo l'alunno alla classe corretta, ma qui in caso non sia corretta oltre ad un warning non faccio nulla
		//in quanto potrebbe trattarsi di una bocciatura oppure di un passaggio da asilo ad asilo
		//devo trovare a quale classe il bambino era iscritto l'anno scolastico <<precedente>> a quello scelto
		$sql2 = "SELECT ID_asc FROM tab_anniscolastici WHERE annoscolastico_asc = ? ;";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "s", $annoscolastico_asc);	
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $ID_ascTMP);
		while (mysqli_stmt_fetch($stmt2)) {
			$ID_asc = $ID_ascTMP;
		}
		//ID_asc contiene ora l'ID dell'anno scolastico selezionato
		$sql3 = "SELECT annoscolastico_asc FROM tab_anniscolastici WHERE ID_asc = ? ;";
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		$ID_asc = $ID_asc - 1; //vado a cercare come si chiama l'anno scolastico precedente
		mysqli_stmt_bind_param($stmt3, "i", $ID_asc);	
		mysqli_stmt_execute($stmt3);
		mysqli_stmt_bind_result($stmt3, $annoscolastico_ascprec);
		while (mysqli_stmt_fetch($stmt3)) {
		}
		//ora cerco se l'alunno in questione è iscritto per l'anno precedente
		$sql4 = "SELECT classe_cla FROM tab_classialunni WHERE ID_alu_cla = ? AND annoscolastico_cla = ? ;";
		$stmt4 = mysqli_prepare($mysqli, $sql4);
		mysqli_stmt_bind_param($stmt4, "is", $ID_alu_cla, $annoscolastico_ascprec);	
		mysqli_stmt_execute($stmt4);
		mysqli_stmt_bind_result($stmt4, $classe_claprec);
		$rowssqlprec = 0;
		while (mysqli_stmt_fetch($stmt4)) {
			$rowssqlprec++;
		}
		// classe_claprec contiene a questo punto l'eventuale classe a cui era iscritto l'anno precedente (non è nemmeno detto che ci sia)
		// ora SE non era iscritto l'anno precedente ad alcuna classe proseguo con la procedura di iscrizione senza warning di sorta
		// SE invece non lo era (iscritto l'anno precedente) tento un confronto tra le due classi (sulla base della tabella tab_classi) per lanciare un eventuale warning e chiedere se procedere
		if ($rowssqlprec !=0) {
			//c'era una iscrizione l'anno precedente alla classe classe_claprec
			$sql5 = "SELECT ord_cls FROM tab_classi WHERE classe_cls = ? ;";
			$stmt5 = mysqli_prepare($mysqli, $sql5);
			mysqli_stmt_bind_param($stmt5, "s", $classe_cla);	
			mysqli_stmt_execute($stmt5);
			mysqli_stmt_bind_result($stmt5, $ord_cls);
			while (mysqli_stmt_fetch($stmt5)) {
			}
			$sql6 = "SELECT ord_cls FROM tab_classi WHERE classe_cls = ? ;";
			$stmt6 = mysqli_prepare($mysqli, $sql6);
			mysqli_stmt_bind_param($stmt6, "s", $classe_claprec);	
			mysqli_stmt_execute($stmt6);
			mysqli_stmt_bind_result($stmt6, $ord_clsprec);
			while (mysqli_stmt_fetch($stmt6)) {
			}
			//ora posso paragonare ord_cls e ord_clsprec per capire se ci sono stati macro errori
			//la differenza tra i due deve essere 1 (oppure 0 se bocciato)
			if ($ord_cls-$ord_clsprec > 1) { //la differenza tra classe selezionata e classe dell'anno precedente è >1 non va bene, non si può saltare una classe
				$return['msg'] = "Verificare l'iscrizione in quanto l'anno precedente (".$annoscolastico_ascprec.") l'alunno si trovava in classe ".$classe_claprec ;
				goto finelabel;
			}
			if ($ord_cls-$ord_clsprec < 0) { //la differenza tra classe selezionata e classe dell'anno precedente è >1 non va bene, non si può tornare indietro di classe
				$return['msg'] = "Verificare l'iscrizione in quanto l'anno precedente (".$annoscolastico_ascprec.") l'alunno si trovava in classe ".$classe_claprec ;
				goto finelabel;
			}
			if (($ord_cls == $ord_clsprec) && $bocciato=="false" && $classe_cla != "ASILO" && $classe_cla != "NIDO") {
				$return['msg'] = "Non è stata selezionata la bocciatura e si sta cercando di iscrivere l'alunno/a alla stessa classe dell'anno precedente";
				goto finelabel;
			}
			//in tutti gli altri casi (delta = 1 oppure (delta = 0 + alunno bocciato) oppure ASILO) si può procedere all'iscrizione
			$return['result']= "OK";
			goto iscrizione;
		} else {
			//alunno non già iscritto all'anno selezionato e non iscritto ad alcuna classe l'anno precedente - PROCEDERE CON ISCRIZIONE
			$return['result']= "OK";
			goto iscrizione;
		}
	} else {
		//se già iscritto fermo la procedura
		$return['msg'] = "L'alunno/a risulta già iscritto/a all'Anno Scolastico selezionato";
		$return['result'] = "già iscritto";
		$return['test'] = "già iscritto";
		goto finelabel;
	}

iscrizione:
//ora bisogna effettuare l'iscrizione
//implica l'inserimento dei valori economici per l'anno selezionato
//e implicaVA l'inserimento delle materie per l'anno selezionato. 
//Se Medie 12 materie. Se Elementari 3 materie. Ora non le inserisco mica più!
//allo stesso modo ho tolto il pre-inserimento di quelli che si chiamano "tappi" per le certificazioni delle competenze.

	$sql7 = "SELECT aselme_cls FROM tab_classi WHERE classe_cls = ? ;";
	$stmt7 = mysqli_prepare($mysqli, $sql7);
	mysqli_stmt_bind_param($stmt7, "s", $classe_cla);	
	mysqli_stmt_execute($stmt7);
	mysqli_stmt_bind_result($stmt7, $aselme_cls);
	while (mysqli_stmt_fetch($stmt7)) {
	}

	$sql13 = "INSERT INTO tab_classialunni (id_alu_cla, classe_cla, sezione_cla, annoscolastico_cla, aselme_cla, listaattesa_cla, scalino_cla) 
	VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt13 = mysqli_prepare($mysqli, $sql13);
	mysqli_stmt_bind_param($stmt13, "issssii", $ID_alu_cla,  $classe_cla, $sezione_cla, $annoscolastico_asc , $aselme_cls , $ListaDAttesa, $scalino);	
	mysqli_stmt_execute($stmt13);


	$return['as'] = $annoscolastico_asc;
	//ora procedo con l'inserimento delle rette
	$sql15 = "SELECT anno1_asc, anno2_asc FROM tab_anniscolastici WHERE annoscolastico_asc = ? ;";
	$stmt15 = mysqli_prepare($mysqli, $sql15);
	mysqli_stmt_bind_param($stmt15, "s", $annoscolastico_asc);	
	mysqli_stmt_execute($stmt15);
	mysqli_stmt_bind_result($stmt15, $anno1_asc, $anno2_asc);
	while (mysqli_stmt_fetch($stmt15)) {
	}
	//da settembre a dicembre
	for ($i = 9; $i <= 12; $i++) {
		$sql16 = "INSERT INTO tab_mensilirette (id_alu_ret, mese_ret, ord_mese, anno_ret, annoscolastico_ret) 
		VALUES (".$ID_alu_cla.", '".$i."', '".($i-8)."','".$anno1_asc."', '".$annoscolastico_asc."')";
		$stmt16 = mysqli_prepare($mysqli, $sql16);
		mysqli_stmt_execute($stmt16);
	}
	//da gennaio a giugno
	for ($i = 1; $i <= 8; $i++) {
		$sql17 = "INSERT INTO tab_mensilirette (id_alu_ret, mese_ret, ord_mese, anno_ret, annoscolastico_ret) 
		VALUES (".$ID_alu_cla.", '".$i."', '".($i+4)."','".$anno2_asc."', '".$annoscolastico_asc."')";
		$stmt17 = mysqli_prepare($mysqli, $sql17);
		mysqli_stmt_execute($stmt17);
	}
	//ora procedo con l'inserimento dell' iscrizione all'anno nella tabella iscrizioni
	// $sql18 = "INSERT INTO tab_pagamentialtri (id_alu_isc, annoscolastico_pga) 
	// VALUES (".$ID_alu_cla.", '".$annoscolastico_asc."')";
	// $stmt18 = mysqli_prepare($mysqli, $sql18);
	// mysqli_stmt_execute($stmt18);
	//$ListaDattesa è sempre == 0 in questa funzione: non viene gestita qui la situazione di inserimento in lista d'attesa

	//se non c'è il record in listadattesa devo crearlo e inserirlo come "accolto"
	$sql19 = "SELECT ID_alu_lda FROM tab_listadattesa WHERE ID_alu_lda = ? AND annoscolastico_lda = ? ;";
	$stmt19 = mysqli_prepare($mysqli, $sql19);
	mysqli_stmt_bind_param($stmt19, "is", $ID_alu_cla, $annoscolastico_asc);	
	mysqli_stmt_execute($stmt19);
	mysqli_stmt_bind_result($stmt19, $ID_alu);
	$rows = 0;
	while (mysqli_stmt_fetch($stmt19)) {
		$rows++;
	}
	if ($rows == 0) {
		$sql20 = "INSERT INTO tab_listadattesa (ID_alu_lda, annoscolastico_lda, classe_lda, sezione_lda, accolto_lda) 
		VALUES (".$ID_alu_cla.", '".$annoscolastico_asc."', '".$classe_cla."', '".$sezione_cla."',  1)";
			$stmt20 = mysqli_prepare($mysqli, $sql20);
			mysqli_stmt_execute($stmt20);
	}
	if ($ListaDAttesa == 0) {
		//infine in ogni caso setto accolto_lda = 1
		$sql21 = "UPDATE tab_listadattesa SET accolto_lda = 1 WHERE ID_alu_lda = ?;";
		$stmt21 = mysqli_prepare($mysqli, $sql21);
		mysqli_stmt_bind_param($stmt21, "i", $ID_alu_cla);	
		mysqli_stmt_execute($stmt21);
	}
	
	$return['msg'] = "Iscrizione andata a buon fine";
	$return['sql3'] = $sql3;
	$return['sql4'] = $sql4;
	$return['test'] = $sql16;




finelabel:

	$return['ID_alu_cla'] = $ID_alu_cla;
	$return['annoscolastico_asc'] = $annoscolastico_asc;
	$return['classe_cla'] = $classe_cla;
	$return['sezione_cla'] = $sezione_cla;


    echo json_encode($return);
?>
