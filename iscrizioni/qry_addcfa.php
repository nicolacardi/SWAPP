<?include_once("../database/databaseBii.php");
	
	$ID_fam_cfa = $_POST['ID_fam_cfa'];
	$nome_cfa = $_POST['nome_cfa_new'];
	$cognome_cfa = $_POST['cognome_cfa_new'];
	$dataluogonascita_cfa = $_POST['dataluogonascita_cfa_new'];
	$gradoparentela_cfa = $_POST['gradoparentela_cfa_new'];
	
	$sql = "INSERT INTO tab_composizionefam (ID_fam_cfa, nome_cfa, cognome_cfa, dataluogonascita_cfa, gradoparentela_cfa) VALUES( ?, ?, ?, ?, ?)";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "sssss", $ID_fam_cfa, $nome_cfa, $cognome_cfa, $dataluogonascita_cfa, $gradoparentela_cfa);	
	mysqli_stmt_execute($stmt);
	
		echo json_encode($return);

?>
