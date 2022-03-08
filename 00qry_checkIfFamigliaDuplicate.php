<?include_once("database/databaseii.php");
	
	//viene verificata la già presenza del solo cognome del padre...
	$cognomepadre_fam = addslashes($_POST['cognomepadre_fam_new']);
	$cognomemadre_fam = addslashes($_POST['cognomemadre_fam_new']);
	
	if ($cognomemadre_fam == "") {
		//se il cognome della madre è vuoto verifico soltanto se viene trovato il cognome del padre
		//cioè indipendentemente dal fatto che tra le famiglie presenti la madre si chiami in un modo o nell'altro
		//io segnalo di aver trovato il cognome del padre se viene trovato
		$sql3 = "SELECT ID_fam FROM tab_famiglie WHERE cognomepadre_fam = ? ;";
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		mysqli_stmt_bind_param($stmt3, "s", $cognomepadre_fam);
		mysqli_stmt_execute($stmt3);
		mysqli_stmt_bind_result($stmt3, $ID_alu);
		$k = 0;
		while (mysqli_stmt_fetch($stmt3)) {
			$k++;
		}
		$return['test'] = $k;
	} else {
		//se il cognome della madre NON è vuoto allora verifico se viene trovato anche il cognome della madre
		//e solo se trovo entrambe io segnalo di aver trovato la famiglia
		//in questo modo NON obbligo ad esempio la famiglia Cardi-De Haag a chiamarsi Cardi2-De Haag
		$sql3 = "SELECT ID_fam FROM tab_famiglie WHERE cognomepadre_fam = ? AND cognomemadre_fam = ?;";
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		mysqli_stmt_bind_param($stmt3, "ss", $cognomepadre_fam, $cognomemadre_fam);
		mysqli_stmt_execute($stmt3);
		mysqli_stmt_bind_result($stmt3, $ID_alu);
		$k = 0;
		while (mysqli_stmt_fetch($stmt3)) {
			$k++;
		}
		$return['test'] = $k;
	}

     echo json_encode($return);
?>
