<? 
	include_once("../database/databaseBii.php");

	$cknonmostrarepiu_fam = $_POST['cknonmostrarepiu_fam'];
	
	$sql2 = "UPDATE tab_famiglie SET nonmostrarepiu_fam = ". $cknonmostrarepiu_fam ." WHERE ID_fam = ". $_SESSION['ID_fam'];
	//QUERY PARAMETRICA DA FARE
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_execute($stmt2);


	echo json_encode($return);
    
?>