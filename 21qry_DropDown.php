<?include_once("database/databaseii.php");
	$campo= $_REQUEST['campo'];
	$inputVal= $_REQUEST['inputVal'];
	//poichè i maestri supervisori hanno accesso alla pagina Schede Maestri
	//in base al role_usr devo pescare tutto il personale oppure 
	//(solo caso maestro supervisore role_usr = 3) SOLO i maestri
	$role_usr= $_REQUEST['role_usr'];

    $sql = "SELECT `ID_soc`, `nome_soc`, `cognome_soc` FROM `tab_anagraficasoci` WHERE ".$campo." LIKE CONCAT('%',?,'%') ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $inputVal );
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_soc, $nome_soc, $cognome_soc);
	mysqli_stmt_store_result($stmt);
	while (mysqli_stmt_fetch($stmt)) {
		$nome_soc = str_replace(' ', '-',($nome_soc));
		$cognome_soc = str_replace(' ', '-', ($cognome_soc));
		echo "<p><span hidden>".$ID_soc."+</span><input id='nomeselected".$ID_soc."' style=' text-align: center; background-color: transparent; border: 0px; width: 40%;' value=".$nome_soc."><input id='cognomeselected".$ID_soc."' style='text-align: center; background-color: transparent; border: 0px; width: 40%;' value=".$cognome_soc."></p>";	
	}
?>