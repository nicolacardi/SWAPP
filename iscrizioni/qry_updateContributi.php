<? 
	include_once("../database/databaseBii.php");

	//estraggo tutti i figli di ID_fam
			//E' stata inibita la possibilità di modificare le quote manualmente ma si possono modificare selezionando dalle combobox
			//Non aveva più senso aggiornare in database la quotapromessa, adesso torna il senso
			//Cè però questa nota "questo aggiornamento determinava problemi quando non viene iscritto un figlio: si setta a zero! Meglio togliere l'update, che è ormai inutile."
			//VERIFICARE COSA ACCADE QUANDO NON SI ISCRIVE UN FIGLIO

	$sql = "SELECT ID_alu FROM tab_anagraficaalunni WHERE ID_fam_alu = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $_SESSION['ID_fam']);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu);
	mysqli_stmt_store_result ($stmt);
	$n = 0;
	while (mysqli_stmt_fetch($stmt)) {
		$n++;
		//per ciascuno inserisco quanto scritto nel form

		$quotapromessa_alu = intval($_POST["quotapromessa_alu".$ID_alu]);
		//scelgo di scrivere SIA come ratepromesse_alu SIA come ratepromesse_fam lo stesso valore scelto
		$ratepromesse_alu = intval($_POST["selectnumerorate_fam"]);
		$tipoquota_alu = intval($_POST["selecttipoquota".$ID_alu]);

		$sql2 = "UPDATE tab_anagraficaalunni SET quotapromessa_alu = ?, ratepromesse_alu = ? , tipoquota_alu = ? WHERE ID_alu = ? ";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param ( $stmt2, "iiii", $quotapromessa_alu, $ratepromesse_alu, $tipoquota_alu, $ID_alu);
		mysqli_stmt_execute($stmt2);
	}
	
	$ratepromesse_fam = $_POST["selectnumerorate_fam"];
	$quotacontraggiuntivo_fam = $_POST["quotacontraggiuntivo_fam"];
	$ratecontraggiuntivo_fam = $_POST["ratecontraggiuntivo_fam"];
	//NB nei form serialized le checkbox restituiscono on se checked e NON RESTUISCONO NULLA se non checked 
	if ($_POST["richcolloquio_fam"] == 'on') { $richcolloquio_fam = 1;} else { $richcolloquio_fam = 0;} 
	$intestazionefatt_fam = $_POST["selectintestazionefatt_fam"];
	$pulizie_fam = $_POST["pulizie_fam"];
	$modalitapag_fam = $_POST["selectmodalitapag_fam"];
	$sql3 = "UPDATE tab_famiglie SET ratepromesse_fam = ?, quotacontraggiuntivo_fam = ?, ratecontraggiuntivo_fam = ?, richcolloquio_fam = ?, intestazionefatt_fam = ?, pulizie_fam = ?, modalitapag_fam = ? WHERE ID_fam = ? ";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param ( $stmt3, "iiiisiii", $ratepromesse_fam, $quotacontraggiuntivo_fam, $ratecontraggiuntivo_fam, $richcolloquio_fam, $intestazionefatt_fam, $pulizie_fam, $modalitapag_fam, $_SESSION['ID_fam']);
	mysqli_stmt_execute($stmt3);

	$return['sql'] = $sql;
	$return['sql2'] = $sql2;
	$return['sql3'] = $sql3;
	$return['test'] = $n;
	echo json_encode($quotapromessa_alu);
    
?>