<? 
	include_once("database/databaseii.php");
	$ID_usr= $_POST['ID_usr'];
	$nonmostrarepiu_usr = $_POST['cknonmostrarepiu_usr'];
	
	$sql2 = "UPDATE tab_users SET nonmostrarepiu_usr = ". $nonmostrarepiu_usr ." WHERE ID_usr = ?;";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "i", $ID_usr);
	mysqli_stmt_execute($stmt2);
	
	$return['test'] = $sql2;
	echo json_encode($return);
    
?>