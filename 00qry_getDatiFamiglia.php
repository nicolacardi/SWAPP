<?include_once("database/databaseii.php");
	
	$ID_fam = $_POST['ID_fam'];
	
	$sql = "SELECT nomemadre_fam, cognomemadre_fam, nomepadre_fam, cognomepadre_fam, telefonomadre_fam, telefonopadre_fam, altrotelmadre_fam, altrotelpadre_fam, emailmadre_fam, emailpadre_fam, sociomadre_fam, sociopadre_fam FROM tab_famiglie WHERE ID_fam = ?; ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $nomemadre_fam, $cognomemadre_fam, $nomepadre_fam, $cognomepadre_fam, $telefonomadre_fam, $telefonopadre_fam, $altrotelmadre_fam, $altrotelpadre_fam, $emailmadre_fam, $emailpadre_fam, $sociomadre_fam, $sociopadre_fam);

	
	while (mysqli_stmt_fetch($stmt)) {
		$return['nomemadrefam'] = $nomemadre_fam;
		$return['cognomemadre_fam'] = $cognomemadre_fam;
		$return['nomepadre_fam'] = $nomepadre_fam;
		$return['cognomepadre_fam'] = $cognomepadre_fam;
		$return['telefonomadre_fam'] = $telefonomadre_fam;
		$return['telefonopadre_fam'] = $telefonopadre_fam;
		$return['altrotelmadre_fam'] = $altrotelmadre_fam;
		$return['altrotelpadre_fam'] = $altrotelpadre_fam;
		$return['emailmadre_fam'] = $emailmadre_fam;
		$return['emailpadre_fam'] = $emailpadre_fam;
		$return['sociomadre_fam'] = $sociomadre_fam;
		$return['sociopadre_fam'] = $sociopadre_fam;
	}

    echo json_encode($return);
?>
