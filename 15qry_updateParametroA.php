<?	include_once("database/databaseii.php");
	$ID_paa = $_POST['ID_paa'];
    $val_paa = $_POST['val_paa'];
    $val2_paa = $_POST['val2_paa'];
    $parname_paa = $_POST['parname_paa'];
    $tipovoti_paa = $_POST['tipovoti_paa'];
	$nchar_paa = $_POST['nchar_paa'];
	$sql = "UPDATE tab_parametrixanno SET parname_paa = ? , val_paa = ?, val2_paa = ?, tipovoti_paa = ?, nchar_paa = ? WHERE ID_paa = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "sssiii", $parname_paa, $val_paa, $val2_paa, $tipovoti_paa, $nchar_paa, $ID_paa);
	mysqli_stmt_execute($stmt);
	$return['test']=$sql." valore:".$val_paa." ID parametro:".$ID_paa;
	echo json_encode($return);
?>
