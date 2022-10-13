<?
    include_once("database/databaseii.php"); //è nel database B che vado a guardare!
	$ID_fam = $_POST['ID_fam_alu'];

	$sql = "SELECT ID_fam, sociomadre_fam, sociopadre_fam, nomemadre_fam, cognomemadre_fam, nomepadre_fam, cognomepadre_fam FROM ".$_SESSION['databaseB'].".tab_famiglie WHERE ID_fam = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_fam_alu, $sociomadreB_fam, $sociopadreB_fam, $nomemadre_fam, $cognomemadre_fam, $nomepadre_fam, $cognomepadre_fam );
	$n=0;
	while (mysqli_stmt_fetch($stmt)) {
		$n++;
	}
	
    $sql = "SELECT ID_fam, sociomadre_fam, sociopadre_fam FROM ".$_SESSION['databaseA'].".tab_famiglie WHERE ID_fam = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_fam_alu, $sociomadreA_fam, $sociopadreA_fam );
	$n=0;
	while (mysqli_stmt_fetch($stmt)) {
		$n++;
	}
    $socioMadreChanged = false;
    if ($sociomadreA_fam != $sociomadreB_fam) {$socioMadreChanged = true;}

    $socioPadreChanged = false;
    if ($sociopadreA_fam != $sociopadreB_fam) {$socioPadreChanged = true;}

    $testA = [$nome_soc, $cognome_soc, $indirizzo_soc, $comune_soc, $CAP_soc, $prov_soc, $paese_soc, $cf_soc, $datanascita_soc, $comunenascita_soc, $provnascita_soc, $paesenascita_soc, $telefono_soc, $altrotel_soc, $email_soc, $note_soc, $img_soc, $dataiscrizione_soc, $datadisiscrizione_soc, $datarichiestaiscrizione_soc, $motivocessazione_soc, $datarestituzionequota_soc, $quotapagata_soc, $ID_soc];

	$return['socioMadreDa'] = $sociomadreA_fam;
	$return['socioPadreDa'] = $sociopadreA_fam;

	$return['socioMadreChanged'] = $socioMadreChanged;
	$return['socioPadreChanged'] = $socioPadreChanged;
	$return['nomemadre_fam'] = $nomemadre_fam;
    $return['nomepadre_fam'] = $nomepadre_fam;
    $return['cognomemadre_fam'] = $cognomemadre_fam;
    $return['cognomepadre_fam'] = $cognomepadre_fam;

    
	echo json_encode($return);
?>

