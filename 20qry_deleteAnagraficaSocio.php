<?include_once("database/databaseii.php");
	
	$ID_soc = $_POST['ID_soc'];
	
	//cancello da tab_anagraficasoci
	$sql4 = "DELETE FROM tab_anagraficasoci ".
	" WHERE ID_soc = ? ;";	
	$stmt4 = mysqli_prepare($mysqli, $sql4);
	mysqli_stmt_bind_param($stmt4, "i", $ID_soc);	
	mysqli_stmt_execute($stmt4);

	echo json_encode($return);
?>
