<?include_once("database/databaseii.php");
	
	$ID_alu_cer = $_POST['ID_alu_cer'];
	$annoscolastico_cer = $_POST['annoscolastico_cer'];
	$compchiavecod_cer =  $_POST['compchiavecod_cer'];
	$certVal = addslashes($_POST['certVal']);

	
	
	//UPDATE di tab_classialunnivoti
	$sql = "UPDATE tab_certcompetenze SET ".
	" votocertcomp_cer = '".$certVal."' ".
	" WHERE ID_alu_cer = ? ".
	" AND annoscolastico_cer = ? ".
	" AND compchiavecod_cer = ? ";
	
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "iss", $ID_alu_cer, $annoscolastico_cer, $compchiavecod_cer);	
	mysqli_stmt_execute($stmt);


	$return['sql'] = $sql;


	
	echo json_encode($return);
?>
