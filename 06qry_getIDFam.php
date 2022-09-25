<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	$ID_alu = $_POST['ID_alu'];
    $padremadre_soc = $_POST['padremadre_soc'];
	$sql = "SELECT ID_fam_alu FROM tab_anagraficaalunni WHERE ID_alu = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_alu);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_fam);
	
    $return['ID_fam'] = 0;


	while (mysqli_stmt_fetch($stmt)) {
        $return['ID_fam'] = $ID_fam;

	}

    echo json_encode($return);?>
