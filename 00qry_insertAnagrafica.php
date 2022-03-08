<?include_once("database/databaseii.php");
	

	$nomemadre_fam_new = ucwords(strtolower(addslashes($_POST['nomemadre_fam_new'])));
	$cognomemadre_fam_new = ucwords(strtolower(addslashes($_POST['cognomemadre_fam_new'])));
	$nomepadre_fam_new = ucwords(strtolower(addslashes($_POST['nomepadre_fam_new'])));
	$cognomepadre_fam_new = ucwords(strtolower(addslashes($_POST['cognomepadre_fam_new'])));
	$telefonomadre_fam_new = addslashes($_POST['telefonomadre_fam_new']);
	$telefonopadre_fam_new = addslashes($_POST['telefonopadre_fam_new']);
	$emailmadre_fam_new = addslashes($_POST['emailmadre_fam_new']);
	$emailpadre_fam_new = addslashes($_POST['emailpadre_fam_new']);
	$sociomadre_fam_new = $_POST['sociomadre_fam_new'];
	$sociopadre_fam_new = $_POST['sociopadre_fam_new'];
	
	if ($sociomadre_fam_new == "on") {$sociomadre_fam_new = 1;} else {$sociomadre_fam_new = 0;}
	if ($sociopadre_fam_new == "on") {$sociopadre_fam_new = 1;} else {$sociopadre_fam_new = 0;}

	//se la selezione nella select vale none allora devo inserire una nuova famiglia
	$selectFamiglia = $_POST['selectFamiglia'];
	
	
	if ($selectFamiglia == "none"){
		//inserisco nuova famiglia con i dati che ho

		$sql1 = "INSERT INTO tab_famiglie ( 
		nomemadre_fam, 
		cognomemadre_fam, 
		nomepadre_fam, 
		cognomepadre_fam, 
		cognome_fam, 
		telefonomadre_fam, 
		telefonopadre_fam, 
		emailmadre_fam, 
		emailpadre_fam, 
		sociomadre_fam, 
		sociopadre_fam) 
		VALUES ( 
		? ,
		? ,
		? ,
		? ,
		? ,
		? ,
		? ,
		? ,
		? ,
		? ,
		?);";


		$stmt1 = mysqli_prepare($mysqli, $sql1);
		mysqli_stmt_bind_param($stmt1, "sssssssssii", $nomemadre_fam_new, $cognomemadre_fam_new, $nomepadre_fam_new, $cognomepadre_fam_new, $cognomepadre_fam_new, $telefonomadre_fam_new, $telefonopadre_fam_new, $emailmadre_fam_new, $emailpadre_fam_new, $sociomadre_fam_new, $sociopadre_fam_new);
		mysqli_stmt_execute($stmt1);
		$ID_fam_alu = mysqli_insert_id($mysqli);
	} else {
		//altrimenti (la selezione non è NONE) devo inserire come ID_fam il valore della selectfamiglia
		//e IN TEORIA non dovrei fare l'UPDATE dei dati della famiglia...ma se nell'occasione uno li modifica? sarebbe da fare
		$ID_fam_alu = $selectFamiglia;
	}
	
	//infine come ultima cosa effettuo la insert in tab_anagrafica alunni
	
	$nome_alu = ucwords(strtolower(addslashes($_POST['nome_alu_new'])));
	$cognome_alu = ucwords(strtolower(addslashes($_POST['cognome_alu_new'])));
	
	$mf_alu = $_POST['mf_alu_new'];
	$indirizzo_alu = addslashes($_POST['indirizzo_alu_new']);
	$citta_alu = addslashes($_POST['citta_alu_new']);
	$CAP_alu = $_POST['CAP_alu_new'];
	$prov_alu = $_POST['prov_alu_new'];
	$paese_alu = addslashes($_POST['paese_alu_new']);
	$cf_alu = addslashes($_POST['cf_alu_new']);
	$datanascita_alu = $_POST['datanascita_alu_new'];
	if ($datanascita_alu != "") {
		//$datanascita_alu = date('Y-m-d', strtotime(str_replace('/','-', $datanascita_alu))); SERVE?
	} else {
		$datanascita_alu = '1900-01-01';
	}

	$comunenascita_alu = addslashes($_POST['comunenascita_alu_new']);
	$provnascita_alu = $_POST['provnascita_alu_new'];
	$paesenascita_alu = addslashes($_POST['$paesenascita_alu_new']);

	$datanascita_alu = date('Y-m-d', strtotime(str_replace('/','-', $datanascita_alu)));
	
	$sql2 = "INSERT INTO tab_anagraficaalunni (
		nome_alu, 
		cognome_alu, 
		mf_alu, 
		ID_fam_alu, 
		indirizzo_alu, 
		citta_alu, 
		CAP_alu, 
		prov_alu, 
		paese_alu, 
		cf_alu, 
		datanascita_alu, 
		comunenascita_alu, 
		provnascita_alu, 
		paesenascita_alu) 
		VALUES ( 
		? ,
		? ,
		? ,
		? ,
		? ,
		? ,
		? ,
		? ,
		? ,
		? ,
		? ,
		? ,
		? ,
		?
		)";

	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "sssissssssssss", $nome_alu, $cognome_alu, $mf_alu, $ID_fam_alu, $indirizzo_alu, $citta_alu, $CAP_alu, $prov_alu, $paese_alu, $cf_alu, $datanascita_alu, $comunenascita_alu, $provnascita_alu, $paesenascita_alu);
	mysqli_stmt_execute($stmt2);
	
	$ID = mysqli_insert_id($mysqli);

	
	$return['ID'] = $ID;
	$return['ID_fam_alu'] = $ID_fam_alu;
	$return['test'] = $ID;
 	
     echo json_encode($return);
?>
