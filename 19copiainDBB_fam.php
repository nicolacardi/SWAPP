<?include_once("database/databaseii.php");
	$ID_fam = $_POST['ID_fam_alu'];
	$annoscolastico_cla = $_POST['annoscolastico_cla'];
	$ID_usr_fam = "0";
	$mailinviate_fam = 0;
	//$promemoriainviati_fam = 0;

	//verifico anzitutto se in Database B già c'è la famiglia e se c'è mi metto da parte ID_usr_fam perchè dovrò ripristinarlo! altrimenti, se non lo faccio, la DELETE e poi INSERT cancella il record e ne scrive un altro che in ID_fam_usr ha 0 e non ha, dunque, il legame con lo userid creato in precedenza....quindi quando vado a verificare non lo trova e ne crea un altro!
	$sql1 = "SELECT ID_fam, cognome_fam, ID_usr_fam, mailinviate_fam FROM ".$_SESSION['databaseB'].".tab_famiglie WHERE ID_fam = ?";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "i", $ID_fam);
	mysqli_stmt_execute($stmt1);
	mysqli_stmt_bind_result($stmt1, $ID_famB, $cognome_fam, $ID_usr_famTMP, $mailinviate_famTMP);
	$FamEsisteInB =  0;
	while (mysqli_stmt_fetch($stmt1)) {
		$FamEsisteInB  = 1;
		$ID_usr_fam = $ID_usr_famTMP;
		$mailinviate_fam = $mailinviate_famTMP;
	}
	
	
	if ($FamEsisteInB == 0) {
	} else {
		//se la famiglia già c'è allora cancello in tab_famiglie ed in tab_composizionefam prima di reinserirla
		$sqlD = "DELETE FROM ".$_SESSION['databaseB'].".tab_famiglie WHERE ID_fam = ?;";
		$stmtD = mysqli_prepare($mysqli, $sqlD);
		mysqli_stmt_bind_param($stmtD, "i", $ID_fam);
		mysqli_stmt_execute($stmtD);

		$sqlD2 = "DELETE FROM ".$_SESSION['databaseB'].".tab_composizionefam WHERE ID_fam_cfa = ?;";
		$stmtD2 = mysqli_prepare($mysqli, $sqlD2);
		mysqli_stmt_bind_param($stmtD2, "i", $ID_fam);
		mysqli_stmt_execute($stmtD2);
	}


	$sqlI = "INSERT INTO ".$_SESSION['databaseB'].".tab_famiglie (ID_usr_fam, ID_fam, cognome_fam, nomemadre_fam, cognomemadre_fam, nomepadre_fam, cognomepadre_fam, telefonomadre_fam, altrotelmadre_fam, telefonopadre_fam, altrotelpadre_fam, emailmadre_fam, emailpadre_fam, sociomadre_fam, sociopadre_fam, datanascitamadre_fam, comunenascitamadre_fam, provnascitamadre_fam, paesenascitamadre_fam, cfmadre_fam, indirizzomadre_fam, comunemadre_fam, CAPmadre_fam, provmadre_fam, paesemadre_fam, titolomadre_fam, profmadre_fam, datanascitapadre_fam, comunenascitapadre_fam, provnascitapadre_fam, paesenascitapadre_fam, cfpadre_fam, indirizzopadre_fam, comunepadre_fam, CAPpadre_fam, provpadre_fam, paesepadre_fam, titolopadre_fam, profpadre_fam, mailinviate_fam, promemoriainviati_fam, pulizie_fam, richcolloquio_fam, ratepromesse_fam, intestazionefatt_fam, modalitapag_fam, annopreiscrizione_fam)
	SELECT ".$ID_usr_fam.", ID_fam, cognome_fam, nomemadre_fam, cognomemadre_fam, nomepadre_fam, cognomepadre_fam, telefonomadre_fam, altrotelmadre_fam, telefonopadre_fam, altrotelpadre_fam, emailmadre_fam, emailpadre_fam, sociomadre_fam, sociopadre_fam, datanascitamadre_fam, comunenascitamadre_fam, provnascitamadre_fam, paesenascitamadre_fam, cfmadre_fam, indirizzomadre_fam, comunemadre_fam, CAPmadre_fam, provmadre_fam, paesemadre_fam, titolomadre_fam, profmadre_fam, datanascitapadre_fam, comunenascitapadre_fam, provnascitapadre_fam, paesenascitapadre_fam, cfpadre_fam, indirizzopadre_fam, comunepadre_fam, CAPpadre_fam, provpadre_fam, paesepadre_fam, titolopadre_fam, profpadre_fam, ".$mailinviate_fam." , 0, pulizie_fam, richcolloquio_fam, ratepromesse_fam, intestazionefatt_fam, modalitapag_fam, '".$annoscolastico_cla."' FROM ".$_SESSION['databaseA'].".tab_famiglie WHERE ".$_SESSION['databaseA'].".tab_famiglie.ID_fam = ?;";
	$stmtI = mysqli_prepare($mysqli, $sqlI);
	mysqli_stmt_bind_param($stmtI, "i", $ID_fam);
	mysqli_stmt_execute($stmtI);


	$return['result'] = "Inserita Famiglia ".$ID_fam." ".$cognome_fam;
	//copio anche eventuali record di tab_composizionefam

	$sqlI2 = "INSERT INTO ".$_SESSION['databaseB'].".tab_composizionefam (ID_fam_cfa, nome_cfa, cognome_cfa, dataluogonascita_cfa, gradoparentela_cfa) SELECT ID_fam_cfa, nome_cfa, cognome_cfa, dataluogonascita_cfa, gradoparentela_cfa FROM ".$_SESSION['databaseA'].".tab_composizionefam WHERE ".$_SESSION['databaseA'].".tab_composizionefam.ID_fam_cfa = ?;";
	$stmtI2 = mysqli_prepare($mysqli, $sqlI2);
	mysqli_stmt_bind_param($stmtI2, "i", $ID_fam);
	mysqli_stmt_execute($stmtI2);


	if ($FamEsisteInB == 0) {
		$return['result'] = "Inseriti componenti aggiuntivi famiglia ".$ID_fam." ".$cognome_fam;
		$return['result'] = "fam non esiste in DBB************ ID_FAM:".$ID_fam.".......sql1: ".$sql1." ............ FamEsisteInB: ".$FamEsisteInB. ".............sqlD: ".$sqlD. "..............sqlD2: ".$sqlD2."...............sqlI:".$sqlI."...............sqlI2:".$sqlI2;
		$return['test'] = $sqlI2;
	} else {
		$return['result'] = "Famiglia ".$ID_fam." ".$cognome_fam." già presente in Database B. Eliminata e reinserita (->aggiornata)";
		$return['result'] = "fam esiste in DBB ########### ID_FAM:".$ID_fam.".......sql1: ".$sql1." ............ FamEsisteInB: ".$FamEsisteInB. ".............sqlD: ".$sqlD. "..............sqlD2: ".$sqlD2."...............sqlI:".$sqlI."...............sqlI2:".$sqlI2;
		$return['test'] = $sqlI2;
	}

	$return['test2'] = $sqlI;
     echo json_encode($return);
?>
