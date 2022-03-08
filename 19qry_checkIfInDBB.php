<?include_once("database/databaseBii.php");
	$ID_fam = $_POST['ID_fam_alu'];

	$sql = "SELECT annopreiscrizione_fam FROM tab_famiglie WHERE ID_fam = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $annopreiscrizione_fam );
	while (mysqli_stmt_fetch($stmt)) {
	}
	$return['annopreiscrizione_fam'] = $annopreiscrizione_fam;
	
	echo json_encode($return);
?>

