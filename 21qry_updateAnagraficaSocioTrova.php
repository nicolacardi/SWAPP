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

	$padre = false;
	$madre = false;
	$maestro = false;
	$who = '';

	//ora con nome_soc e cognome_soc vado a cercare in database famiglie e in database maestri se c'è uno che si chiama così

	$sql2 = "SELECT ID_fam, nomepadre_fam, cognomepadre_fam, indirizzopadre_fam, comunepadre_fam, CAPpadre_fam, provpadre_fam, paesepadre_fam, cfpadre_fam, datanascitapadre_fam, comunenascitapadre_fam, provnascitapadre_fam, paesenascitapadre_fam, telefonopadre_fam, altrotelpadre_fam, notepadre_fam, emailpadre_fam, imgpadre_fam FROM tab_famiglie WHERE nomepadre_fam = ? AND cognomepadre_fam = ? ;";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "ss", $nome_soc, $cognome_soc);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $ID_fam_soc, $nome_soc, $cognome_soc, $indirizzo_soc, $comune_soc, $CAP_soc, $prov_soc, $paese_soc, $cf_soc, $datanascita_soc, $comunenascita_soc, $provnascita_soc, $paesenascita_soc, $telefono_soc, $altrotel_soc, $note_soc, $email_soc, $img_soc);
	mysqli_stmt_store_result($stmt2);
	while (mysqli_stmt_fetch($stmt2)) {
		$padre = true;
		$who = "padre";

	}


	if ($who =='') {
		$sql2 = "SELECT ID_fam, nomemadre_fam, cognomemadre_fam, indirizzomadre_fam, comunemadre_fam, CAPmadre_fam, provmadre_fam, paesemadre_fam, cfmadre_fam, datanascitamadre_fam, comunenascitamadre_fam, provnascitamadre_fam, paesenascitamadre_fam, telefonomadre_fam, altrotelmadre_fam, notemadre_fam, emailmadre_fam, imgmadre_fam FROM tab_famiglie WHERE nomemadre_fam = ? AND cognomemadre_fam = ? ;";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "ss", $nome_soc, $cognome_soc);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $ID_fam_soc, $nome_soc, $cognome_soc, $indirizzo_soc, $comune_soc, $CAP_soc, $prov_soc, $paese_soc, $cf_soc, $datanascita_soc, $comunenascita_soc, $provnascita_soc, $paesenascita_soc, $telefono_soc, $altrotel_soc, $note_soc, $email_soc, $img_soc);
		mysqli_stmt_store_result($stmt2);
		while (mysqli_stmt_fetch($stmt2)) {
			$madre = true;
			$who = "madre";

		}
	}

	if ($who =='') {
		$sql2 = "SELECT ID_mae, nome_mae, cognome_mae, indirizzo_mae, citta_mae, CAP_mae, prov_mae, paese_mae, cf_mae, datanascita_mae, comunenascita_mae, provnascita_mae, paesenascita_mae, telefono_mae, altrotelefono_mae, note_mae, email_mae, img_mae FROM tab_anagraficamaestri WHERE nome_mae = ? AND cognome_mae = ? ;";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "ss", $nome_soc, $cognome_soc);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $ID_mae_soc, $nome_soc, $cognome_soc, $indirizzo_soc, $comune_soc, $CAP_soc, $prov_soc, $paese_soc, $cf_soc, $datanascita_soc, $comunenascita_soc, $provnascita_soc, $paesenascita_soc, $telefono_soc, $altrotel_soc, $note_soc, $email_soc, $img_soc);
		mysqli_stmt_store_result($stmt2);
		while (mysqli_stmt_fetch($stmt2)) {
			$maestro = true;
			$who = "maestro";

		}
	}

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
	telefono_soc = ?,
	altrotel_soc = ?,
	email_soc = ?,
	note_soc = ?,
	img_soc = ?
	
	WHERE ID_soc  = ? ;";

	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "sssssssssssssssssi", $nome_soc, $cognome_soc, $indirizzo_soc, $comune_soc, $CAP_soc, $prov_soc, $paese_soc, $cf_soc, $datanascita_soc, $comunenascita_soc, $provnascita_soc, $paesenascita_soc, $telefono_soc, $altrotel_soc, $email_soc, $note_soc, $img_soc, $ID_soc);
	mysqli_stmt_execute($stmt1);



	$return['padre'] = $padre;
	$return['madre'] = $madre;
	$return['maestro'] = $maestro;
	$return['sql2'] = $sql2;
	echo json_encode($return);
?>
