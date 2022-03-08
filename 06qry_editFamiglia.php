<?include_once("database/databaseii.php");
    
    $ID_alu =  $_POST['ID_alu'];
    $ID_fam_current = $_POST['ID_fam_current'];
    $fratelli = $_POST['fratelli'];
	$nomemadre_fam_new = addslashes($_POST['nomemadre_fam_new']);
	$cognomemadre_fam_new = addslashes($_POST['cognomemadre_fam_new']);
	$nomepadre_fam_new = addslashes($_POST['nomepadre_fam_new']);
	$cognomepadre_fam_new = addslashes($_POST['cognomepadre_fam_new']);

    //se la selezione nella select vale none allora devo inserire una nuova famiglia
	$selectFamiglia = $_POST['selectFamiglia'];
	
	
	if ($selectFamiglia == "none"){
		//inserisco nuova famiglia con i dati che ho
		$sql = "INSERT INTO tab_famiglie ( ".
				"nomemadre_fam, ".
				"cognomemadre_fam, ".
				"nomepadre_fam, ".
				"cognomepadre_fam, ".
				"cognome_fam) ".
				"VALUES ( ".
				"'".$nomemadre_fam_new."', ".
				"'".$cognomemadre_fam_new."', ".
				"'".$nomepadre_fam_new."', ".
				"'".$cognomepadre_fam_new."', ".
				"'".$cognomepadre_fam_new.
				");";
				//$stmt = mysqli_prepare($mysqli, $sql);
				//mysqli_stmt_execute($stmt);
				
        mysqli_query($mysqli, $sql);
        $ID_fam_alu = mysqli_insert_id($mysqli);
		

	} else {
        //altrimenti (la selezione non è NONE) devo inserire come ID_fam il valore della selectfamiglia
        //e IN TEORIA non dovrei fare l'UPDATE dei dati della famiglia...ma se nell'occasione uno li modifica? sarebbe da fare
		$ID_fam_alu = $selectFamiglia;
    }
    
    //se era l'unico fratello devo cancellare la famiglia
    if ($fratelli == 1 ) {
        $sql5 = "DELETE FROM tab_famiglie ".
        " WHERE ID_fam = ? ;";
        $stmt5 = mysqli_prepare($mysqli, $sql5);
        mysqli_stmt_bind_param($stmt5, "i", $ID_fam_current);
        mysqli_stmt_execute($stmt5);
    }


	//infine come ultima cosa effettuo la update in tab_anagrafica
    $sql = "UPDATE tab_anagraficaalunni SET ".
	" ID_fam_alu = ? ".	
	" WHERE ID_alu = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ii", $ID_fam_alu, $ID_alu);
    mysqli_stmt_execute($stmt);
    
    
	
	$sql3 = "SELECT ID_alu FROM tab_anagraficaalunni WHERE nome_alu = ? AND cognome_alu = ? AND ID_fam_alu = ? ;";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "ssi", $nome_alu, $cognome_alu, $ID_fam_alu);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_bind_result($stmt3, $ID);
	while (mysqli_stmt_fetch($stmt3)) {
	}
	
	$return['msg'] = "Modifica della famiglia associata effettuata";
	//$return['ID_fam_alu'] = $ID_fam_alu;
	//$return['sql'] = $sql;
	$return['test1'] = $sql;
	$return['test2'] = $sql2;
	$return['test3'] = $sql3;
 	

     echo json_encode($return);
?>
