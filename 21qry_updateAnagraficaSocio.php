<?	include_once("database/databaseii.php");
	$ID_soc = $_POST['ID_soc'];
	$nome_soc = addslashes($_POST['nome_soc']);
	$cognome_soc = addslashes($_POST['cognome_soc']);
	$indirizzo_soc = addslashes($_POST['indirizzo_soc']);
	$citta_soc = addslashes(ucwords(strtolower($_POST['citta_soc'])));
	$CAP_soc = intval($_POST['CAP_soc']);
	$prov_soc = strtoupper($_POST['prov_soc']);
	$paese_soc = addslashes(ucwords(strtolower($_POST['paese_soc'])));
	$cf_soc = strtoupper($_POST['cf_soc']);
	$datanascita_soc = $_POST['datanascita_soc'];
	$datanascita_soc = date('Y-m-d', strtotime(str_replace('/','-', $datanascita_soc)));
	$comunenascita_soc = addslashes(ucwords(strtolower($_POST['comunenascita_soc'])));
	$provnascita_soc = strtoupper($_POST['provnascita_soc']);
	$paesenascita_soc = addslashes(ucwords(strtolower($_POST['paesenascita_soc'])));
	$cittadinanza_soc = addslashes(strtoupper($_POST['cittadinanza_soc']));
	$telefono_soc = $_POST['telefono_soc'];
	$altrotelefono_soc = $_POST['altrotelefono_soc'];
	$note_soc = addslashes($_POST['note_soc']);
	$email_soc = addslashes($_POST['email_soc']);
	$img_soc = $_POST['img_soc'];
	
	$tipo_soc = $_POST['tipo_soc'];
	$mf_soc = $_POST['mf_soc'];
	


	// $dataass_soc = $_POST['dataass_soc'];
	// if ($dataass_soc != '') {
	// 	$dataass_soc = date('Y-m-d', strtotime(str_replace('/','-', $dataass_soc)));
	// } else {
	// 	$dataass_soc = '1900-01-01';
	// }


	$sql = "UPDATE tab_anagraficasoci SET 

	tipo_soc = ?,
	mf_soc= ?,
	nome_soc = ?,
	cognome_soc = ?,
	indirizzo_soc = ?,
	citta_soc = ?,
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
	altrotelefono_soc = ?,
	email_soc = ?,
	note_soc = ?,
	img_soc = ?
	
	 WHERE ID_soc  = ? ;";

	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "isssssisssssssssssssi", $tipo_soc, $mf_soc, $nome_soc, $cognome_soc, $indirizzo_soc, $citta_soc, $CAP_soc, $prov_soc, $paese_soc, $cf_soc, $datanascita_soc, $comunenascita_soc, $provnascita_soc, $paesenascita_soc, $cittadinanza_soc, $telefono_soc, $altrotelefono_soc, $email_soc, $note_soc, $img_soc, $ID_soc);
	mysqli_stmt_execute($stmt);

	
	$return['msg'] = "Dati del socio ". $nome_soc . " " . $cognome_soc ." aggiornati";
	$return['test'] = $sql;		
	echo json_encode($return);
?>
