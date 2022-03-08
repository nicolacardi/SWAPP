<?include_once("database/databaseii.php");
//DA SISTEMARE IN MODO CHE SE IN LISTA D'ATTESA NON PASSINO IN DBB!!	
	$ID_fam_alu = $_POST['ID_fam_alu'];
	$annoscolastico_cla = $_POST['annoscolastico_cla'];
	//trovo se ci sono fratelli e per ogni fratello faccio quanto segue
	$sql2 = "SELECT ID_alu FROM tab_anagraficaalunni JOIN tab_classialunni ON ID_alu_cla = ID_alu WHERE ID_fam_alu = ? AND annoscolastico_cla = ?";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "is", $ID_fam_alu, $annoscolastico_cla);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $ID_alu);
	mysqli_stmt_store_result($stmt2);
	$result = "";
	$alunniA = array();
	$indice = 0;
	//percorrerà la while qui di seguito una volta per ogni fratello
	while (mysqli_stmt_fetch($stmt2)) {

		
		
		//verifico anzitutto se in Database B già c'è l'alunno
		$sql = "SELECT ID_alu, nome_alu, cognome_alu FROM ".$_SESSION['databaseB'].".tab_anagraficaalunni WHERE ID_alu = ?";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "i", $ID_alu);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $ID_aluB, $nome_aluB, $cognome_aluB);
		$AluEsisteInB =  false;
		
		while (mysqli_stmt_fetch($stmt)) {
			$AluEsisteInB  = true;
		}
		
		
		if ($AluEsisteInB == false) {
		} else {
			//se l'alunno già c'è allora lo cancello prima di reinserirlo
			$sqlD = "DELETE FROM ".$_SESSION['databaseB'].".tab_anagraficaalunni WHERE ID_alu = ?;";
			$stmtD = mysqli_prepare($mysqli, $sqlD);
			mysqli_stmt_bind_param($stmtD, "i", $ID_alu);
			mysqli_stmt_execute($stmtD);
			
			$sqlD2 = "DELETE FROM ".$_SESSION['databaseB'].".tab_classialunni WHERE ID_alu_cla = ?;";
			$stmtD2 = mysqli_prepare($mysqli, $sqlD2);
			mysqli_stmt_bind_param($stmtD2, "i", $ID_alu);
			mysqli_stmt_execute($stmtD2);
		}
		//inserisco o reinserisco (così aggiorno) alunno
		$alunniA[$indice] =  $ID_alu;
		$indice++;
		$sql3 = "INSERT INTO ".$_SESSION['databaseB'].".tab_anagraficaalunni (ID_alu, nome_alu, cognome_alu, ID_fam_alu, indirizzo_alu, citta_alu, CAP_alu, prov_alu, paese_alu, cf_alu, mf_alu, disabilita_alu, DSA_alu, scuolaprovenienza_alu, indirizzoscproven_alu, datanascita_alu, comunenascita_alu, provnascita_alu, paesenascita_alu, cittadinanza_alu, autfoto_alu, commento_alu, note_alu, img_alu, tipoquota_alu, ratecauzione_alu, ckreligione_alu) 
		SELECT ID_alu, nome_alu, cognome_alu, ID_fam_alu, indirizzo_alu, citta_alu, CAP_alu, prov_alu, paese_alu, cf_alu, mf_alu, disabilita_alu, DSA_alu, scuolaprovenienza_alu, indirizzoscproven_alu, datanascita_alu, comunenascita_alu, provnascita_alu, paesenascita_alu, cittadinanza_alu, autfoto_alu, commento_alu, note_alu, img_alu, 0, ratecauzione_alu, -1 FROM ".$_SESSION['databaseA'].".tab_anagraficaalunni WHERE ".$_SESSION['databaseA'].".tab_anagraficaalunni.ID_alu = ?;";
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		mysqli_stmt_bind_param($stmt3, "i", $ID_alu);
		mysqli_stmt_execute($stmt3);

		//devo inoltre copiare in tab_classialunni il record corrispondente
		$sql4 = "INSERT INTO ".$_SESSION['databaseB'].".tab_classialunni (ID_alu_cla, classe_cla, sezione_cla, annoscolastico_cla, aselme_cla, listaattesa_cla, ritirato_cla, dataritiro_cla) SELECT ID_alu_cla, classe_cla, sezione_cla, annoscolastico_cla, aselme_cla, listaattesa_cla, ritirato_cla, dataritiro_cla FROM ".$_SESSION['databaseA'].".tab_classialunni WHERE ".$_SESSION['databaseA'].".tab_classialunni.ID_alu_cla = ? AND ".$_SESSION['databaseA'].".tab_classialunni.annoscolastico_cla = ? ;";
		$stmt4 = mysqli_prepare($mysqli, $sql4);
		mysqli_stmt_bind_param($stmt4, "is", $ID_alu, $annoscolastico_cla);
		mysqli_stmt_execute($stmt4);


		if ($AluEsisteInB == false) {
			$result = "Inserito Alunno ".$ID_alu." ed inserita Classe per ".$ID_alu. " nell'a.s.". $annoscolastico_cla;
		} else {
			$result = $result." Alunno ".$ID_alu." ".$nome_aluB." ".$cognome_aluB." già presente in Database B: eliminato e reinserito (->aggiornato)";
		}
		
	}
	$return['alunniA'] = $alunniA;
	$return['result'] = $result;
	$return['test'] =  "sql4...ID_alu...annoscolastico_cla)=".$sql4."...".$ID_alu."...".$annoscolastico_cla;	
     echo json_encode($return);
?>
