<?include_once("database/databaseii.php");
	$nome_soc_new = addslashes($_POST['nome_soc_new']);
	$cognome_soc_new = addslashes($_POST['cognome_soc_new']);
	if ($_POST['datanascita_soc_new'] == "") {
		$datanascita_soc_new= "1900-01-01";
	} else {
		$datanascita_soc_new = date('Y-m-d', strtotime(str_replace('/','-', $_POST['datanascita_soc_new']))); ;
	}
	$comunenascita_soc_new = addslashes($_POST['comunenascita_soc_new']);
	$provnascita_soc_new = $_POST['provnascita_soc_new'];
	$paesenascita_soc_new = addslashes($_POST['paesenascita_soc_new']);
	$cf_soc_new = $_POST['cf_soc_new'];
	$mf_soc_new = $_POST['mf_soc_new'];
	$indirizzo_soc_new = addslashes($_POST['indirizzo_soc_new']);
	$comune_soc_new = addslashes($_POST['comune_soc_new']);
	$prov_soc_new = $_POST['prov_soc_new'];
	$paese_soc_new = addslashes($_POST['paese_soc_new']);
	$CAP_soc_new = $_POST['CAP_soc_new'];
	$telefono_soc_new = $_POST['telefono_soc_new'];
	$email_soc_new = $_POST['email_soc_new'];
	$note_soc_new = addslashes($_POST['note_soc_new']);
	$selecttipo = $_POST['selecttipo'];

	$sql3 = "INSERT INTO tab_anagraficasoci (tipo_soc, nome_soc, cognome_soc, indirizzo_soc, comune_soc, CAP_soc, prov_soc, paese_soc, mf_soc, cf_soc, datanascita_soc, comunenascita_soc, provnascita_soc, paesenascita_soc, telefono_soc, email_soc, note_soc ) ".
	" VALUES ( ".$selecttipo.", '".$nome_soc_new."', '".$cognome_soc_new."', '".$indirizzo_soc_new."', '".$comune_soc_new."', '".$CAP_soc_new."', '".$prov_soc_new."', '".$paese_soc_new."', '".$mf_soc_new."', '".$cf_soc_new."', '".$datanascita_soc_new."', '".$comunenascita_soc_new."', '".$provnascita_soc_new."', '".$paesenascita_soc_new."', '".$telefono_soc_new."', '".$email_soc_new."', '".$note_soc_new."' )";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_execute($stmt3);
	$return['msg'] = "Inserimento Anagrafica socio andato a buon fine";
	$return['nome_soc_new'] = $nome_soc_new;
	$return['sql'] = $sql;
	$return['sql2'] = $sql2;
	$return['sql3'] = $sql3;
	$return['test'] = $datanascita_soc_new;
	echo json_encode($return);
?>
