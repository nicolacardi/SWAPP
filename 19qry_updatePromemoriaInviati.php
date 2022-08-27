<?	include_once("database/databaseBii.php");
	$ID_fam_alu = $_POST['ID_fam_alu'];
	$annoscolastico_cla = $_POST['annoscolastico_cla'];
	
    $sql = "SELECT promemoriainviati_fam  FROM tab_famiglie WHERE ID_fam = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam_alu);
	mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $promemoriainviati_fam);
    while (mysqli_stmt_fetch($stmt)) {}

    $promemoriainviati_fam = $promemoriainviati_fam + 1;

    $sql = "UPDATE tab_famiglie SET promemoriainviati_fam = ? WHERE ID_fam = ?;";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $promemoriainviati_fam, $ID_fam_alu);
    mysqli_stmt_execute($stmt);

    $return['test']=$promemoriainviati_fam;
	echo json_encode($return);
?>
