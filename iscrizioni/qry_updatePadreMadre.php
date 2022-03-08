<? 
	include_once("../database/databaseBii.php");
	$padremadre = $_POST['padremadre'];
	
	
	if ($padremadre == "padre") {
	
		$nomecampoA = array(
		"sociopadre_fam", 
		"nomepadre_fam",
		"cognomepadre_fam",
		"comunenascitapadre_fam",
		"provnascitapadre_fam",
		"paesenascitapadre_fam",
		"datanascitapadre_fam",
		"cfpadre_fam", 
		"indirizzopadre_fam",
		"comunepadre_fam",
		"provpadre_fam",
		"paesepadre_fam",
		"CAPpadre_fam",
		"telefonopadre_fam",
		"altrotelpadre_fam",
		"emailpadre_fam",
		"titolopadre_fam",
		"profpadre_fam",
		"ckautorizzazionepadre_fam",
		"ckcarpoolingpadre_fam");
	} else {
		$nomecampoA = array(
		"sociomadre_fam", 
		"nomemadre_fam",
		"cognomemadre_fam",
		"comunenascitamadre_fam",
		"provnascitamadre_fam",
		"paesenascitamadre_fam",
		"datanascitamadre_fam",
		"cfmadre_fam", 
		"indirizzomadre_fam",
		"comunemadre_fam",
		"provmadre_fam",
		"paesemadre_fam",
		"CAPmadre_fam",
		"telefonomadre_fam",
		"altrotelmadre_fam",
		"emailmadre_fam",
		"titolomadre_fam",
		"profmadre_fam",
		"ckautorizzazionemadre_fam",
		"ckcarpoolingmadre_fam");
	}
	
	$campiN = count($nomecampoA);
	
	$valcampo = array();

	for ($x = 0; $x < ($campiN); $x++) {
		
		$valcampo[$x] = $_POST[$nomecampoA[$x]];
		if (substr ($nomecampoA[$x], 0, 4)  == "data") {$valcampo[$x] = date('Y-m-d', strtotime(str_replace('/','-', $valcampo[$x])));} //qui va convertita la data
		$setstring = $setstring. $nomecampoA[$x]." = ? , ";
	}
	$setstring = substr($setstring, 0, -2);
	
	$sql = "UPDATE tab_famiglie SET ". $setstring. " WHERE ID_fam = ". $_SESSION['ID_fam'];
	 $stmt = mysqli_prepare($mysqli, $sql);
	 mysqli_stmt_bind_param ( $stmt, "isssssssssssssssssii", $valcampo[0], $valcampo[1], $valcampo[2], $valcampo[3], $valcampo[4], $valcampo[5], $valcampo[6], $valcampo[7], $valcampo[8], $valcampo[9], $valcampo[10], $valcampo[11], $valcampo[12], $valcampo[13], $valcampo[14], $valcampo[15], $valcampo[16], $valcampo[17], $valcampo[18], $valcampo[19]);
	 mysqli_stmt_execute($stmt);

	$return['test'] =  $nomecampoA;
	$return['test2'] =  $valcampo;
	$return['sql'] =  $sql;
	echo json_encode($return);
    
?>