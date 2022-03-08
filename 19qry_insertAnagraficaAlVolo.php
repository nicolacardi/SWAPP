<?include_once("database/databaseii.php");
	
	$nome_alu = addslashes($_POST['nome_alu_new']);
	$cognome_alu = addslashes($_POST['cognome_alu_new']);
	$emailmadre_fam_new = addslashes($_POST['emailmadre_fam_new']);
	$emailpadre_fam_new = addslashes($_POST['emailpadre_fam_new']);

	//se la selezione nella select vale none allora devo inserire una nuova famiglia
	$selectFamiglia = $_POST['selectFamiglia'];
	
	
	if ($selectFamiglia == "none"){
		//inserisco nuova famiglia con i dati che ho
		$sql = "INSERT INTO tab_famiglie ( ".
				"nomemadre_fam, ".
				"cognomemadre_fam, ".
				"nomepadre_fam, ".
				"cognomepadre_fam, ".
				"cognome_fam, ".
				"emailmadre_fam, ".
				"emailpadre_fam) ".
				"VALUES ( ".
				"'nome madre', ".
				"'cognome madre', ".
				"'nome padre', ".
				"'cognome padre', ".
				"'".$cognome_alu."', ".
				"'".$emailmadre_fam_new."', ".
				"'".$emailpadre_fam_new."' ".
				");";
			
				mysqli_query($mysqli, $sql);
				$ID_fam_alu = mysqli_insert_id($mysqli);
		

	} else {
	//altrimenti (la selezione non è NONE) devo inserire come ID_fam il valore della selectfamiglia
	//e IN TEORIA non dovrei fare l'UPDATE dei dati della famiglia...ma se nell'occasione uno li modifica? sarebbe da fare
		$ID_fam_alu = $selectFamiglia;
	}
	
	//infine come ultima cosa effettuo la insert in tab_anagraficaalunni

	$mf_alu = $_POST['mf_alu_new'];
	$datanascita_alu = $_POST['datanascita_alu_new'];
	$datanascita_alu = date('Y-m-d', strtotime(str_replace('/','-', $datanascita_alu)));
	
	$sql2 = "INSERT INTO tab_anagraficaalunni (nome_alu, cognome_alu, mf_alu, ID_fam_alu, datanascita_alu) VALUES ( '".$nome_alu."', '".$cognome_alu."', '".$mf_alu."', ".$ID_fam_alu.", '".$datanascita_alu."')";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_execute($stmt2);
	
	$sql3 = "SELECT ID_alu FROM tab_anagraficaalunni WHERE nome_alu = ? AND cognome_alu = ? AND ID_fam_alu = ? ;";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "ssi", $nome_alu, $cognome_alu, $ID_fam_alu);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_bind_result($stmt3, $ID);
	while (mysqli_stmt_fetch($stmt3)) {
	}
	
	$return['ID'] = $ID;
	$return['ID_fam'] = $ID_fam_alu;
	$return['sql'] = $sql;
    echo json_encode($return);
?>
