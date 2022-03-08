<?include_once("database/databaseii.php");
	$ID_alu = $_POST['ID_alu_cla'];
	$commento_alu = $_POST['commento_alu'];
	$sql = "UPDATE tab_anagraficaalunni SET ".
	" commento_alu = ? ".
	" WHERE ID_alu = ? ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "si", $commento_alu, $ID_alu);	
	mysqli_stmt_execute($stmt);
	$return['sql'] = $sql;
	$return['ID_alu']= $ID_alu;
    echo json_encode($return);
?>
