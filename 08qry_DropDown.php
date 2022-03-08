<?include_once("database/databaseii.php");
	$campo= $_REQUEST['campo'];
	$inputVal= $_REQUEST['inputVal'];
	//poichè i maestri supervisori hanno accesso alla pagina Schede Maestri
	//in base al role_usr devo pescare tutto il personale oppure 
	//(solo caso maestro supervisore role_usr = 3) SOLO i maestri
	$role_usr= $_REQUEST['role_usr'];
	if ($role_usr == 3) {
		$whereTipoPer = " AND tipo_per = 0 ";
	}
    $sql = "SELECT `ID_mae`, `nome_mae`, `cognome_mae` FROM `tab_anagraficamaestri` WHERE ".$campo." LIKE CONCAT('%',?,'%') ".$whereTipoPer;
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $inputVal );
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_mae, $nome_mae, $cognome_mae);
	mysqli_stmt_store_result($stmt);
	while (mysqli_stmt_fetch($stmt)) {
		$nome_mae = str_replace(' ', '-',($nome_mae));
		$cognome_mae = str_replace(' ', '-', ($cognome_mae));
		echo "<p><span hidden>".$ID_mae."+</span><input id='nomeselected".$ID_mae."' style=' text-align: center; background-color: transparent; border: 0px; width: 40%;' value=".$nome_mae."><input id='cognomeselected".$ID_mae."' style='text-align: center; background-color: transparent; border: 0px; width: 40%;' value=".$cognome_mae."></p>";	
	}
?>