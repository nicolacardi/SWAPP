<?	include_once("database/databaseii.php");
	$campo= $_REQUEST['campo'];
	$inputVal= addslashes($_REQUEST['inputVal']);
	//$inputVal= ($_REQUEST['inputVal']);
	//$sql = "SELECT `ID_alu`, `nome_alu`, `cognome_alu` FROM `tab_anagraficaalunni` WHERE ".$campo." LIKE '%".$inputVal."%' ";
	$sql = "SELECT `ID_alu`, `nome_alu`, `cognome_alu` FROM `tab_anagraficaalunni` WHERE ".$campo." LIKE CONCAT('%',?,'%') ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $inputVal );
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu, $nome_alu, $cognome_alu);
	mysqli_stmt_store_result($stmt);
	while (mysqli_stmt_fetch($stmt)) {
		$nome_alu = str_replace("'", "`",($nome_alu));
		$cognome_alu = str_replace("'", "`", ($cognome_alu));

		echo "<p><span hidden>".$ID_alu."+</span><input id='nomeselected".$ID_alu."' style=' cursor: pointer; text-align: center; background-color: transparent; border: 0px; width: 40%; outline: none;' value='".$nome_alu."' readonly><input id='cognomeselected".$ID_alu."' style='cursor: pointer;  text-align: center; background-color: transparent; border: 0px; width: 40%; outline: none;' value='".$cognome_alu."' readonly></p>";	
	}
?>
