<?	include_once("database/databaseii.php");
	$ID_mae = $_POST['ID_mae'];
	$socio_mae = $_POST['socio_mae'];
	$nome_mae = addslashes($_POST['nome_mae']);
	$cognome_mae = addslashes($_POST['cognome_mae']);
	$indirizzo_mae = addslashes($_POST['indirizzo_mae']);
	$citta_mae = addslashes(ucwords(strtolower($_POST['citta_mae'])));
	$CAP_mae = $_POST['CAP_mae'];
	$prov_mae = strtoupper($_POST['prov_mae']);
	$paese_mae = addslashes(ucwords(strtolower($_POST['paese_mae'])));
	$cf_mae = strtoupper($_POST['cf_mae']);
	$datanascita_mae = $_POST['datanascita_mae'];
	$datanascita_mae = date('Y-m-d', strtotime(str_replace('/','-', $datanascita_mae)));
	$comunenascita_mae = addslashes(ucwords(strtolower($_POST['comunenascita_mae'])));
	$provnascita_mae = strtoupper($_POST['provnascita_mae']);
	$paesenascita_mae = addslashes(ucwords(strtolower($_POST['paesenascita_mae'])));
	$cittadinanza_mae = addslashes(strtoupper($_POST['cittadinanza_mae']));
	$titolo_mae = addslashes($_POST['titolo_mae']);
	$telefono_mae = $_POST['telefono_mae'];
	$altrotelefono_mae = $_POST['altrotelefono_mae'];
	$note_mae = addslashes($_POST['note_mae']);
	$email_mae = addslashes($_POST['email_mae']);
	$img_mae = $_POST['img_mae'];
	$vede_mae= $_POST['vede_mae'];
	$in_organico_mae = $_POST['in_organico_mae'];
	$tipo_per = $_POST['tipo_per'];
	$mf_mae = $_POST['mf_mae'];
	$login_usr = $_POST['login_usr'];
	$ID_usr_mae = $_POST['ID_usr_mae'];

	$matricola_mae = $_POST['matricola_mae'];
	$matrinps_mae = $_POST['matrinps_mae'];
	$matrinail_mae = $_POST['matrinail_mae'];
	$certpencg_mae = $_POST['certpencg_mae'];

	$dataass_mae = $_POST['dataass_mae'];
	if ($dataass_mae != '') {
		$dataass_mae = date('Y-m-d', strtotime(str_replace('/','-', $dataass_mae)));
	} else {
		$dataass_mae = '1900-01-01';
	}

	$datalic_mae = $_POST['datalic_mae'];
	if ($datalic_mae != '') {
		$datalic_mae = date('Y-m-d', strtotime(str_replace('/','-', $datalic_mae)));
	} else {
		$datalic_mae = '1900-01-01';
	}
	$tipocontr_mae = $_POST['tipocontr_mae'];
	$livello_mae = $_POST['livello_mae'];
	$orecontr_mae = $_POST['orecontr_mae'];
	$ud_mae = $_POST['ud_mae'];
	$parttimeperc_mae = $_POST['parttimeperc_mae'];
	$iban_mae = $_POST['iban_mae'];
	$noterapporto_mae = $_POST['noterapporto_mae'];
	$ral_mae = $_POST['ral_mae'];



	// $sql = "UPDATE tab_anagraficamaestri SET ".
	// "in_organico_mae = ".$in_organico_mae." , ".
	// "tipo_per = ".$tipo_per." , ".
	// "nome_mae = '".$nome_mae."' , ".
	// "cognome_mae = '".$cognome_mae."' , ".
	// "indirizzo_mae = '".$indirizzo_mae."' , ".
	// "citta_mae = '".$citta_mae."' , ".
	// "CAP_mae = ".$CAP_mae." , ".
	// "prov_mae = '".$prov_mae."' , ".
	// "paese_mae = '".$paese_mae."' , ".
	// "cf_mae = '".$cf_mae."' , ".
	// "datanascita_mae = '".$datanascita_mae."' , ".
	// "comunenascita_mae = '".$comunenascita_mae."' , ".
	// "provnascita_mae = '".$provnascita_mae."' , ".
	// "paesenascita_mae = '".$paesenascita_mae."' , ".
	// "titolo_mae = '".$titolo_mae."' , ".
	// "telefono_mae = '".$telefono_mae."' , ".
	// "email_mae = '".$email_mae."' , ".
	// "note_mae = '".$note_mae."' , ".
	// "img_mae = '".$img_mae."' ".	
	// " WHERE ID_mae  = ? ;";

	$sql = "UPDATE tab_anagraficamaestri SET 
	socio_mae = ?,
	in_organico_mae = ?,
	tipo_per = ?,
	mf_mae= ?,
	nome_mae = ?,
	cognome_mae = ?,
	indirizzo_mae = ?,
	citta_mae = ?,
	CAP_mae = ?,
	prov_mae = ?,
	paese_mae = ?,
	cf_mae = ?,
	datanascita_mae = ?,
	comunenascita_mae = ?,
	provnascita_mae = ?,
	paesenascita_mae = ?,
	cittadinanza_mae = ?, 
	titolo_mae = ?,
	telefono_mae = ?,
	altrotelefono_mae = ?,
	email_mae = ?,
	note_mae = ?,
	img_mae = ?,
	vede_mae = ?,
	
	matricola_mae = ?,
	matrinps_mae = ?,
	matrinail_mae = ?,
	certpencg_mae = ?,
	dataass_mae = ?,
	datalic_mae = ?,
	tipocontr_mae = ?,
	livello_mae = ?,
	orecontr_mae = ?,
	ud_mae = ?,
	parttimeperc_mae = ?,
	iban_mae = ?,
	noterapporto_mae = ?,
	ral_mae = ?
	 WHERE ID_mae  = ? ;";

	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "iiisssssissssssssssssssissssssiiiiissii", $socio_mae, $in_organico_mae, $tipo_per, $mf_mae, $nome_mae, $cognome_mae, $indirizzo_mae, $citta_mae, $CAP_mae, $prov_mae, $paese_mae, $cf_mae, $datanascita_mae, $comunenascita_mae, $provnascita_mae, $paesenascita_mae, $cittadinanza_mae, $titolo_mae, $telefono_mae, $altrotelefono_mae, $email_mae, $note_mae, $img_mae, $vede_mae,
	$matricola_mae,	$matrinps_mae, $matrinail_mae, $certpencg_mae, $dataass_mae, $datalic_mae, $tipocontr_mae, $livello_mae, $orecontr_mae, $ud_mae, $parttimeperc_mae, $iban_mae, $noterapporto_mae, $ral_mae, $ID_mae);
	mysqli_stmt_execute($stmt);

	$sql1 = "UPDATE tab_users SET ".
		"login_usr = '".$login_usr."' ".
		" WHERE ID_usr  = ".$ID_usr_mae." ;";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_execute($stmt1);
	$return['msg'] = "Dati del maestro ". $nome_mae . " " . $cognome_mae ." aggiornati";
	$return['test'] = $sql;		
	echo json_encode($return);
?>
