<?	
	//questa routine viene utilizzata quando si modifica l'anagrafica socio (CASO 1)
	//ma deve funzionare anche quando si modifica l'anagrafica PRINCIPALE (scheda alunno) (CASO 2)
	//e IN CONSEGUENZA deve essere modificata l'anagrafica socio
	//questa situazione pone alcuni temi:
	//1. quale anagrafica devo modificare? potrebbero essere entrambe presenti
	//2. che dati arrivano qui? sono diversi da quelli della situazione di cui sopra e si chiamano anche diversamente

	//la seconda situazione, per chiarezza, si comprende dal fatto che viene passato "padremadre" = "any"

	include_once("database/databaseii.php");
	$pm = $_POST['padremadre'];
	$ID_fam_soc = $_POST['ID_fam_soc'];

	if ($pm == "any") {
		//CASO 2: sto modificando l'anagrafica alunni nella sezione dei genitori: devo dunque ciclare per aggiornare il padre e/o la madre
		$padremadreA = ["padre", "madre"];
		foreach ($padremadreA as $padremadre) {
			//in questo caso come prima cosa devo provare sia con "padre" sia con "madre" per capire quale dei due (o se entrambi) sono presenti
			$sql = "SELECT ID_soc FROM tab_anagraficasoci WHERE padremadre_soc = ? AND ID_fam_soc = ? ;";
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_bind_param($stmt, "si", $padremadre, $ID_fam_soc);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $ID_soc);
			mysqli_stmt_store_result($stmt);
			$k = 0;
			while (mysqli_stmt_fetch($stmt)) {
				$k++;
				$nome_soc = addslashes($_POST['nome'.$padremadre.'_fam']);
				$cognome_soc = addslashes($_POST['cognome'.$padremadre.'_fam']);
				$indirizzo_soc = addslashes($_POST['indirizzo'.$padremadre.'_fam']);
				$comune_soc = addslashes(ucwords(strtolower($_POST['comune'.$padremadre.'_fam'])));
				$CAP_soc = intval($_POST['CAP'.$padremadre.'_fam']);
				$prov_soc = strtoupper($_POST['prov'.$padremadre.'_fam']);
				$paese_soc = addslashes(ucwords(strtolower($_POST['paese'.$padremadre.'_fam'])));
				$cf_soc = strtoupper($_POST['cf'.$padremadre.'_fam']);
				$datanascita_soc = $_POST['datanascita'.$padremadre.'_fam'];
				$datanascita_soc = date('Y-m-d', strtotime(str_replace('/','-', $datanascita_soc)));
				$comunenascita_soc = addslashes(ucwords(strtolower($_POST['comunenascita'.$padremadre.'_fam'])));
				$provnascita_soc = strtoupper($_POST['provnascita'.$padremadre.'_fam']);
				$paesenascita_soc = addslashes(ucwords(strtolower($_POST['paesenascita'.$padremadre.'_fam'])));
				$telefono_soc = $_POST['telefono'.$padremadre.'_fam'];
				$altrotel_soc = $_POST['altrotel'.$padremadre.'_fam'];
				$note_soc = addslashes($_POST['note'.$padremadre.'_fam']);
				$email_soc = addslashes($_POST['email'.$padremadre.'_fam']);
				$img_soc = $_POST['img'.$padremadre.'_fam'];

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
				mysqli_stmt_bind_param($stmt1, "ssssissssssssssssi", $nome_soc, $cognome_soc, $indirizzo_soc, $comune_soc, $CAP_soc, $prov_soc, $paese_soc, $cf_soc, $datanascita_soc, $comunenascita_soc, $provnascita_soc, $paesenascita_soc, $telefono_soc, $altrotel_soc, $email_soc, $note_soc, $img_soc, $ID_soc);
				mysqli_stmt_execute($stmt1);


				//devo anche andare ad aggiornare in database B
				$sql2 = "UPDATE ".$_SESSION['databaseB'].".tab_famiglie SET socio".$pm."_fam = 1 WHERE ID_fam = ?;";
				$stmt2 = mysqli_prepare($mysqli, $sql2);
				mysqli_stmt_bind_param($stmt2, "i", $ID_fam_soc);
				mysqli_stmt_execute($stmt2);

			}





		}

	} else {
		//CASO 1: sto aggiornando proprio l'anagrafica socio
		$ID_soc = $_POST['ID_soc'];
		$nome_soc = addslashes($_POST['nome_soc']);
		$cognome_soc = addslashes($_POST['cognome_soc']);
		$indirizzo_soc = addslashes($_POST['indirizzo_soc']);
		$comune_soc = addslashes(ucwords(strtolower($_POST['comune_soc'])));
		$CAP_soc = intval($_POST['CAP_soc']);
		$prov_soc = strtoupper($_POST['prov_soc']);
		$paese_soc = addslashes(ucwords(strtolower($_POST['paese_soc'])));
		$cf_soc = strtoupper($_POST['cf_soc']);
		$datanascita_soc = $_POST['datanascita_soc'];
		$datanascita_soc = date('Y-m-d', strtotime(str_replace('/','-', $datanascita_soc)));
		$comunenascita_soc = addslashes(ucwords(strtolower($_POST['comunenascita_soc'])));
		$provnascita_soc = strtoupper($_POST['provnascita_soc']);
		$paesenascita_soc = addslashes(ucwords(strtolower($_POST['paesenascita_soc'])));
		$telefono_soc = $_POST['telefono_soc'];
		$altrotel_soc = $_POST['altrotel_soc'];
		$note_soc = addslashes($_POST['note_soc']);
		$email_soc = addslashes($_POST['email_soc']);
		$img_soc = $_POST['img_soc'];

		$tipo_soc = $_POST['tipo_soc'];
		$mf_soc = $_POST['mf_soc'];

		$dataiscrizione_soc = $_POST['dataiscrizione_soc'];
		if ($dataiscrizione_soc !="") {$dataiscrizione_soc = date('Y-m-d', strtotime(str_replace('/','-', $dataiscrizione_soc)));} 
		else {$dataiscrizione_soc = NULL;}

		$datadisiscrizione_soc = $_POST['datadisiscrizione_soc'];
		if ($datadisiscrizione_soc !="") {$datadisiscrizione_soc = date('Y-m-d', strtotime(str_replace('/','-', $datadisiscrizione_soc)));}
		else {$datadisiscrizione_soc = NULL;}

		$datarichiestaiscrizione_soc = $_POST['datarichiestaiscrizione_soc'];
		if ($datarichiestaiscrizione_soc !="") { $datarichiestaiscrizione_soc = date('Y-m-d', strtotime(str_replace('/','-', $datarichiestaiscrizione_soc)));}
		else {$datarichiestaiscrizione_soc = NULL;}

		$datarestituzionequota_soc = $_POST['datarestituzionequota_soc'];
		if ($datarestituzionequota_soc !="") {$datarestituzionequota_soc = date('Y-m-d', strtotime(str_replace('/','-', $datarestituzionequota_soc)));}
		else {$datarestituzionequota_soc = NULL;}

		$quotapagata_soc = intval($_POST['quotapagata_soc']);

		$ckrinunciaquota_soc = $_POST['ckrinunciaquota_soc'];

		$motivocessazione_soc = $_POST['motivocessazione_soc'];


		$sql = "UPDATE tab_anagraficasoci SET 

		tipo_soc = ?,
		mf_soc= ?,
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
		img_soc = ?,

		dataiscrizione_soc = ?,
		datadisiscrizione_soc = ?,
		datarichiestaiscrizione_soc = ?,
		datarestituzionequota_soc = ?,
		quotapagata_soc = ?, 
		ckrinunciaquota_soc = ?,
		motivocessazione_soc = ?
		
		WHERE ID_soc  = ? ;";

		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "isssssissssssssssssssssiisi", $tipo_soc, $mf_soc, $nome_soc, $cognome_soc, $indirizzo_soc, $comune_soc, $CAP_soc, $prov_soc, $paese_soc, $cf_soc, $datanascita_soc, $comunenascita_soc, $provnascita_soc, $paesenascita_soc, $telefono_soc, $altrotel_soc, $email_soc, $note_soc, $img_soc, $dataiscrizione_soc, $datadisiscrizione_soc, $datarichiestaiscrizione_soc, $datarestituzionequota_soc, $quotapagata_soc, $ckrinunciaquota_soc, $motivocessazione_soc, $ID_soc);
		mysqli_stmt_execute($stmt);



	}
	
	$return['msg'] = "Dati del socio ". $nome_soc . " " . $cognome_soc ." aggiornati";
	$return['test'] = $sql;		
	$testA = [$nome_soc, $cognome_soc, $indirizzo_soc, $comune_soc, $CAP_soc, $prov_soc, $paese_soc, $cf_soc, $datanascita_soc, $comunenascita_soc, $provnascita_soc, $paesenascita_soc, $telefono_soc, $altrotel_soc, $email_soc, $note_soc, $img_soc, $dataiscrizione_soc, $datadisiscrizione_soc, $datarichiestaiscrizione_soc, $motivocessazione_soc, $datarestituzionequota_soc, $quotapagata_soc, $ID_soc];
	$return['testA'] = $testA;	
	echo json_encode($return);
?>
