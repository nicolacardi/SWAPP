<?include_once("database/databaseii.php");
	$stato = $_POST['stato'];
    if ($stato ==0) {$stato =1;} else {$stato =0;}
    
	$sql = "UPDATE tab_parametri SET val_par = ? WHERE parname_par = 'spedisciAGenitori' ";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "i", $stato);
    mysqli_stmt_execute($stmt);

    echo json_encode($return);
?>
