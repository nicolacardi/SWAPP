<? 
	include_once("../database/databaseBii.php");
	$copiada = $_POST['copiada'];
	$sql = "SELECT indirizzo".$copiada."_fam, comune".$copiada."_fam, CAP".$copiada."_fam, prov".$copiada."_fam, paese".$copiada."_fam FROM tab_famiglie WHERE ID_fam = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param ( $stmt, "i", $_SESSION['ID_fam'] );
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $indirizzo, $comune, $CAP, $prov, $paese);
	while (mysqli_stmt_fetch($stmt)) {
	}
	$return['indirizzo'] = $indirizzo;
	$return['comune'] = $comune;
	$return['prov'] = $prov;
	$return['CAP'] = $CAP;
	$return['paese'] = $paese;
	$return['sql'] = $sql;
	echo json_encode($return);
?>