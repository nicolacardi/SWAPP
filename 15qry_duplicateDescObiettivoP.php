<?	include_once("database/databaseii.php");

    $ID_obd = $_POST['ID_obd'];

	$sql = "INSERT INTO tab_materievotiobiettividesc( ID_obi_obd, classe_obd, desc_obd, ord_obd ) 
	SELECT ID_obi_obd, classe_obd, desc_obd, 0 FROM tab_materievotiobiettividesc WHERE ID_obd =?;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_obd);
	mysqli_stmt_execute($stmt);
	$return['test']=$sql;
	echo json_encode($return);
?>
