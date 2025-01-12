<?	
	//questa routine viene utilizzata quando si modifica l'anagrafica socio (CASO 1)
	//ma deve funzionare anche quando si modifica l'anagrafica PRINCIPALE (scheda alunno) (CASO 2)
	//e IN CONSEGUENZA deve essere modificata l'anagrafica socio
	//questa situazione pone alcuni temi:
	//1. quale anagrafica devo modificare? potrebbero essere entrambe presenti
	//2. che dati arrivano qui? sono diversi da quelli della situazione di cui sopra e si chiamano anche diversamente

	//la seconda situazione, per chiarezza, si comprende dal fatto che viene passato "padremadre" = "any"

	include_once("database/databaseii.php");
	$ID_soc = $_POST['ID_soc'];
	//ora vado a cercare nome e cognome del socio
	$sql = "SELECT nome_soc, cognome_soc FROM tab_anagraficasoci WHERE ID_soc = ?;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_soc);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $nome_soc, $cognome_soc);
	mysqli_stmt_store_result($stmt);
	while (mysqli_stmt_fetch($stmt)) {}

	$nomecognome = $nome_soc." ".$cognome_soc;
	$padre = false;
	$madre = false;
	$maestro = false;
	$who = '';
	$ID_fam = '';

	//ora con nome_soc e cognome_soc vado a cercare in database famiglie e in database maestri se c'è uno che si chiama così
	$sql2 = "SELECT ID_fam,
	nomepadre_fam, cognomepadre_fam, indirizzopadre_fam, comunepadre_fam, CAPpadre_fam, provpadre_fam, paesepadre_fam, cfpadre_fam, datanascitapadre_fam, comunenascitapadre_fam, provnascitapadre_fam, paesenascitapadre_fam, cittadinanzapadre_fam, telefonopadre_fam, altrotelpadre_fam, notepadre_fam, emailpadre_fam, imgpadre_fam,
	nomemadre_fam, cognomemadre_fam, indirizzomadre_fam, comunemadre_fam, CAPmadre_fam, provmadre_fam, paesemadre_fam, cfmadre_fam, datanascitamadre_fam, comunenascitamadre_fam, provnascitamadre_fam, paesenascitamadre_fam, cittadinanzamadre_fam, telefonomadre_fam, altrotelmadre_fam, notemadre_fam, emailmadre_fam, imgmadre_fam
	FROM tab_famiglie WHERE (nomepadre_fam = ? AND cognomepadre_fam = ?) OR  (nomemadre_fam = ? AND cognomemadre_fam = ?);";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "ssss", $nome_soc, $cognome_soc, $nome_soc, $cognome_soc);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $ID_fam,

	$nomepadre_fam, $cognomepadre_fam, $indirizzopadre_fam, $comunepadre_fam, $CAPpadre_fam, $provpadre_fam, $paesepadre_fam, $cfpadre_fam, $datanascitapadre_fam, $comunenascitapadre_fam, $provnascitapadre_fam, $paesenascitapadre_fam, $cittadinanzapadre_fam, $telefonopadre_fam, $altrotelpadre_fam, $notepadre_fam, $emailpadre_fam, $imgpadre_fam,

	$nomemadre_fam, $cognomemadre_fam, $indirizzomadre_fam, $comunemadre_fam, $CAPmadre_fam, $provmadre_fam, $paesemadre_fam, $cfmadre_fam, $datanascitamadre_fam, $comunenascitamadre_fam, $provnascitamadre_fam, $paesenascitamadre_fam, $cittadinanzamadre_fam, $telefonomadre_fam, $altrotelmadre_fam, $notemadre_fam, $emailmadre_fam, $imgmadre_fam
	);
	mysqli_stmt_store_result($stmt2);
	while (mysqli_stmt_fetch($stmt2)) {
		if ($cognomepadre_fam == $cognome_soc ){

			$nome_soc = $nomepadre_fam;
			$cognome_soc = $cognomepadre_fam;
			$indirizzo_soc =$indirizzopadre_fam;
			$comune_soc = $comunepadre_fam;
			$CAP_soc = $CAPpadre_fam;
			$prov_soc = $provpadre_fam;
			$paese_soc = $paesepadre_fam;
			$cf_soc = $cfpadre_fam;
			$datanascita_soc = $datanascitapadre_fam;
			$comunenascita_soc = $comunenascitapadre_fam;
			$provnascita_soc =$provnascitapadre_fam;
			$paesenascita_soc = $paesenascitapadre_fam;
			$cittadinanza_soc = $cittadinanzapadre_fam;
			$telefono_soc = $telefonpadre_fam;
			$altrotel_soc = $altrotelpadre_fam;
			$note_soc = $notepadre_fam;
			$email_soc = $emailpadre_fam;
			$img_soc = $imgpadre_fam;

			$padre = true;
			$who = "padre";

		} else {
			$nome_soc = $nomemadre_fam;
			$cognome_soc = $cognomemadre_fam;
			$indirizzo_soc =$indirizzomadre_fam;
			$comune_soc = $comunemadre_fam;
			$CAP_soc = $CAPmadre_fam;
			$prov_soc = $provmadre_fam;
			$paese_soc = $paesemadre_fam;
			$cf_soc = $cfmadre_fam;
			$datanascita_soc = $datanascitamadre_fam;
			$comunenascita_soc = $comunenascitamadre_fam;
			$provnascita_soc =$provnascitamadre_fam;
			$paesenascita_soc = $paesenascitamadre_fam;
			$cittadinanza_soc = $cittadinanzamadre_fam;
			$telefono_soc = $telefonmadre_fam;
			$altrotel_soc = $altrotelmadre_fam;
			$note_soc = $notemadre_fam;
			$email_soc = $emailmadre_fam;
			$img_soc = $imgmadre_fam;

			$madre = true;
			$who = "madre";
		}
	}


	// $sql2 = "SELECT ID_fam, nomepadre_fam, cognomepadre_fam, indirizzopadre_fam, comunepadre_fam, CAPpadre_fam, provpadre_fam, paesepadre_fam, cfpadre_fam, datanascitapadre_fam, comunenascitapadre_fam, provnascitapadre_fam, paesenascitapadre_fam, cittadinanzapadre_fam, telefonopadre_fam, altrotelpadre_fam, notepadre_fam, emailpadre_fam, imgpadre_fam FROM tab_famiglie WHERE nomepadre_fam = ? AND cognomepadre_fam = ? ;";
	// $stmt2 = mysqli_prepare($mysqli, $sql2);
	// mysqli_stmt_bind_param($stmt2, "ss", $nome_soc, $cognome_soc);
	// mysqli_stmt_execute($stmt2);
	// mysqli_stmt_bind_result($stmt2, $ID_fam_soc, $nome_soc, $cognome_soc, $indirizzo_soc, $comune_soc, $CAP_soc, $prov_soc, $paese_soc, $cf_soc, $datanascita_soc, $comunenascita_soc, $provnascita_soc, $paesenascita_soc, $cittadinanza_soc, $telefono_soc, $altrotel_soc, $note_soc, $email_soc, $img_soc);
	// mysqli_stmt_store_result($stmt2);
	// while (mysqli_stmt_fetch($stmt2)) {
	// 	$padre = true;
	// 	$who = "padre";
	// }



	// $sql3 = "SELECT ID_fam, nomemadre_fam, cognomemadre_fam, indirizzomadre_fam, comunemadre_fam, CAPmadre_fam, provmadre_fam, paesemadre_fam, cfmadre_fam, datanascitamadre_fam, comunenascitamadre_fam, provnascitamadre_fam, paesenascitamadre_fam, cittadinanzamadre_fam, telefonomadre_fam, altrotelmadre_fam, notemadre_fam, emailmadre_fam, imgmadre_fam FROM tab_famiglie WHERE nomemadre_fam = ? AND cognomemadre_fam = ? ;";
	// $stmt3 = mysqli_prepare($mysqli, $sql3);
	// mysqli_stmt_bind_param($stmt3, "ss", $nome_soc, $cognome_soc);
	// mysqli_stmt_execute($stmt3);
	// mysqli_stmt_bind_result($stmt3, $ID_fam_soc, $nome_soc, $cognome_soc, $indirizzo_soc, $comune_soc, $CAP_soc, $prov_soc, $paese_soc, $cf_soc, $datanascita_soc, $comunenascita_soc, $provnascita_soc, $paesenascita_soc, $cittadinanza_soc, $telefono_soc, $altrotel_soc, $note_soc, $email_soc, $img_soc);
	// mysqli_stmt_store_result($stmt3);
	// while (mysqli_stmt_fetch($stmt3)) {
	// 	$madre = true;
	// 	$who = "madre";
	// }




	if (!$padre && !$madre) {
		$sql4 = "SELECT ID_mae, nome_mae, cognome_mae, indirizzo_mae, citta_mae, CAP_mae, prov_mae, paese_mae, cf_mae, datanascita_mae, comunenascita_mae, provnascita_mae, paesenascita_mae, cittadinanza_mae, telefono_mae, altrotelefono_mae, note_mae, email_mae, img_mae FROM tab_anagraficamaestri WHERE nome_mae = ? AND cognome_mae = ? ;";
		$stmt4 = mysqli_prepare($mysqli, $sql4);
		mysqli_stmt_bind_param($stmt4, "ss", $nome_soc, $cognome_soc);
		mysqli_stmt_execute($stmt4);
		mysqli_stmt_bind_result($stmt4, $ID_mae_soc, $nome_soc, $cognome_soc, $indirizzo_soc, $comune_soc, $CAP_soc, $prov_soc, $paese_soc, $cf_soc, $datanascita_soc, $comunenascita_soc, $provnascita_soc, $paesenascita_soc, $cittadinanza_soc, $telefono_soc, $altrotel_soc, $note_soc, $email_soc, $img_soc);
		mysqli_stmt_store_result($stmt4);
		while (mysqli_stmt_fetch($stmt4)) {
			$maestro = true;
			$who = "maestro";
		}
	}

	if ($padre || $madre || $maestro) {
		$sql1 = "UPDATE tab_anagraficasoci SET 

		nome_soc = ?,
		cognome_soc = ?,
		indirizzo_soc = ?,
		comune_soc = ?,
		CAP_soc = ?,
		prov_soc = ?,
		paese_soc = ?,
		cf_soc = ?,
		datanascita_soc = ?,
		comunenascita_soc = ?,
		provnascita_soc = ?,
		paesenascita_soc = ?,
		cittadinanza_soc = ?,
		telefono_soc = ?,
		altrotel_soc = ?,
		email_soc = ?,
		note_soc = ?,
		img_soc = ?
		
		WHERE ID_soc  = ? ;";

		$stmt1 = mysqli_prepare($mysqli, $sql1);
		mysqli_stmt_bind_param($stmt1, "ssssssssssssssssssi", $nome_soc, $cognome_soc, $indirizzo_soc, $comune_soc, $CAP_soc, $prov_soc, $paese_soc, $cf_soc, $datanascita_soc, $comunenascita_soc, $provnascita_soc, $paesenascita_soc, $cittadinanza_soc, $telefono_soc, $altrotel_soc, $email_soc, $note_soc, $img_soc, $ID_soc);
		mysqli_stmt_execute($stmt1);
	}

	$return['ID_soc'] = $ID_soc;
	$return['nomecognome'] = $nomecognome;
	$return['padre'] = $padre;
	$return['madre'] = $madre;
	$return['ID_fam'] = $ID_fam;
	$return['maestro'] = $maestro;
	$return['sql'] = $sql2;
	$return['strupd'] = $nome_soc."-".$cognome_soc."-".$indirizzo_soc."-".$comune_soc."-".$CAP_soc."-".$prov_soc."-".$paese_soc."-".$cf_soc."-".$datanascita_soc."-".$comunenascita_soc."-".$provnascita_soc."-".$paesenascita_soc."-".$cittadinanza_soc."-".$telefono_soc."-".$altrotel_soc."-".$email_soc."-".$note_soc."-".$img_soc."-".$ID_soc;
	echo json_encode($return);
?>
