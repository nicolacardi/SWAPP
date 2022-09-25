<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	$ID_fam_mae_soc = $_POST['ID_fam_mae_soc']; //uso la stessa variabile sia che qui si stia arrivando cercando un padre/madre che un maestro, ecco perchè si chiama così
    $padremadre_soc = $_POST['padremadre_soc'];



	if ($padremadre_soc == "maestro") {
		//se maestro devo guardare a ID_mae_soc
		$sql = "SELECT ID_soc, ID_mae_soc, tipo_soc, dataiscrizione_soc, datapagamentoquota_soc, quotapagata_soc, datadisiscrizione_soc FROM tab_anagraficasoci WHERE ID_mae_soc = ?";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "i", $ID_fam_mae_soc);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $ID_soc, $ID_mae, $tipo_soc, $dataiscrizione_soc, $datapagamentoquota_soc, $quotapagata_soc, $datadisiscrizione_soc);
		
		$return['dataiscrizione_soc'] = NULL;
		$return['ID_soc'] = 0;


	} else {
		//se padre/madre devo guardare a ID_fam_soc + padremadre_soc
		$sql = "SELECT ID_soc, ID_fam_soc, tipo_soc, dataiscrizione_soc, datapagamentoquota_soc, quotapagata_soc, datadisiscrizione_soc FROM tab_anagraficasoci WHERE ID_fam_soc = ? AND padremadre_soc = ?";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "is", $ID_fam_mae_soc, $padremadre_soc);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $ID_soc, $ID_fam_soc, $tipo_soc, $dataiscrizione_soc, $datapagamentoquota_soc, $quotapagata_soc, $datadisiscrizione_soc);
		
		$return['dataiscrizione_soc'] = NULL;
		$return['ID_soc'] = 0;

	}


	while (mysqli_stmt_fetch($stmt)) {
		$return['dataiscrizione_soc'] = timestamp_to_ggmmaaaa($dataiscrizione_soc);
		$return['datadisiscrizione_soc'] = timestamp_to_ggmmaaaa($datadisiscrizione_soc);
		$return['tipo_soc'] = $tipo_soc;

		$return['ID_soc'] = $ID_soc;

	}
    echo json_encode($return);
