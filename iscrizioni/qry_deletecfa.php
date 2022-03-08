<?include_once("../database/databaseBii.php");
	
	$ID_cfa = $_POST['ID_cfa'];
	
	//cancello da tab_composizionefam
	$sql = "DELETE FROM tab_composizionefam ".
	" WHERE ID_cfa = ? ;";	
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_cfa);	
	mysqli_stmt_execute($stmt);

		echo json_encode($return);
?>
