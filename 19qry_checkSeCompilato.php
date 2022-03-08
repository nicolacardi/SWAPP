<?include_once("database/databaseii.php"); //è nel database B che vado a guardare!
	$ID_fam = $_POST['ID_fam_alu'];

	$sql = "SELECT ID_fam, cognome_fam, iscrizionecompleta_fam FROM ".$_SESSION['databaseB'].".tab_famiglie WHERE ID_fam = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_fam_alu, $cognome_fam, $iscrizionecompleta_fam );
	$n=0;
	while (mysqli_stmt_fetch($stmt)) {
		$n++;
	}
	
	if (($n != 0) && ($iscrizionecompleta_fam != 0)) {$return['giapresenteegiacompilato'] = 1; } else { $return['giapresenteegiacompilato'] = 0;}
	$return['cognome_fam'] = $cognome_fam;
	$return['records'] = $n;
	$return['iscrizionecompleta_fam'] = $iscrizionecompleta_fam;
	
	echo json_encode($return);
?>

