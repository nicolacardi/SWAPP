<? 
	include_once("../database/databaseBii.php");

	$sql2 = "UPDATE tab_famiglie SET ckpresavisione1_fam = 1, ckpresavisione2_fam = 1, ckpresavisione3_fam = 1 , ckpresavisione4_fam = 1, ckpresavisione5_fam = 1,  ckpresavisione6_fam = 1, ckpresavisione7_fam = 1  WHERE ID_fam = ". $_SESSION['ID_fam'];
	//QUERY PARAMETRICA DA FARE
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_execute($stmt2);

	$return['sql'] = $sql2;
	echo json_encode($return);
    
?>