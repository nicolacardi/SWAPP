<?include_once("database/databaseii.php");
	
	$ID_ret = $_POST['ID_ret'];
    $importo = $_POST['importo'];
    $tipo =  $_POST['tipo'];
    
    if ($tipo == "D") { $campo = 'default_ret' ;} else { $campo = 'concordato_ret';}

    $sql = "UPDATE tab_mensilirette 
    SET ".$campo." = ? 
    WHERE ID_ret = ? ";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $importo, $ID_ret);
    mysqli_stmt_execute($stmt);

	$return['test']= 'aggiornamento quota '.$ID_ret.' di tipo '.$tipo.' a '.$importo.' avvenuto';
	echo json_encode($return);
?>
