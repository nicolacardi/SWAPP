<?include_once("database/databaseii.php");
	
	$login_usr = $_POST['login_usr'];



	//trovo user
	$sql = "SELECT bloccato_usr FROM ".$_SESSION['databaseB'].".tab_users2 WHERE login_usr = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $login_usr);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $bloccato_usr);
	while (mysqli_stmt_fetch($stmt)) {
	}
	
    if ($bloccato_usr ==0) {$blocca_usr =1;}
    if ($bloccato_usr ==1) {$blocca_usr =0;}
    
    $sql1= "UPDATE ".$_SESSION['databaseB'].".tab_users2 SET bloccato_usr = ? WHERE login_usr = ?";
    $stmt1 = mysqli_prepare($mysqli, $sql1);
    mysqli_stmt_bind_param($stmt1, "is", $blocca_usr, $login_usr);
    mysqli_stmt_execute($stmt1);

		

	$return['test'] =  $sql ;
     echo json_encode($return);
?>
