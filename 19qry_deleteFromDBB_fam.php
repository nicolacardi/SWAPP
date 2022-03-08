<?include_once("database/databaseii.php");
	
	$ID_fam_alu = $_POST['ID_fam_alu'];



	//trovo user
	$sql2 = "SELECT ID_usr_fam FROM ".$_SESSION['databaseB'].".tab_famiglie WHERE ID_fam = ?";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "i", $ID_fam_alu);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $ID_usr_fam);
	while (mysqli_stmt_fetch($stmt2)) {
	}
	
	//trovo se ci sono fratelli e per ogni fratello faccio quanto segue
	$sql1 = "SELECT ID_alu FROM ".$_SESSION['databaseB'].".tab_anagraficaalunni WHERE ID_fam_alu = ?";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "i", $ID_fam_alu);
	mysqli_stmt_execute($stmt1);
	mysqli_stmt_bind_result($stmt1, $ID_alu);
	mysqli_stmt_store_result($stmt1);
	//percorrerà la while qui di seguito una volta per ogni fratello
	while (mysqli_stmt_fetch($stmt1)) {

		$sqlD1= "DELETE FROM ".$_SESSION['databaseB'].".tab_anagraficaalunni WHERE ID_alu = ?";
		$stmtD1 = mysqli_prepare($mysqli, $sqlD1);
		mysqli_stmt_bind_param($stmtD1, "i", $ID_alu);
		mysqli_stmt_execute($stmtD1);

		$sqlD2 = "DELETE FROM ".$_SESSION['databaseB'].".tab_classialunni WHERE ID_alu_cla = ?";
		$stmtD2 = mysqli_prepare($mysqli, $sqlD2);
		mysqli_stmt_bind_param($stmtD2, "i", $ID_alu);
		mysqli_stmt_execute($stmtD2);

	}
	
	$sqlD3 = "DELETE FROM ".$_SESSION['databaseB'].".tab_composizionefam WHERE ID_fam_cfa = ?;";
	$stmtD3 = mysqli_prepare($mysqli, $sqlD3);
	mysqli_stmt_bind_param($stmtD3, "i", $ID_fam_alu);
	mysqli_stmt_execute($stmtD3);
		
	$sqlD4 = "DELETE FROM ".$_SESSION['databaseB'].".tab_famiglie WHERE ID_fam = ?;";
	$stmtD4 = mysqli_prepare($mysqli, $sqlD4);
	mysqli_stmt_bind_param($stmtD4, "i", $ID_fam_alu);
	mysqli_stmt_execute($stmtD4);
	
	$sqlD5 = "DELETE FROM ".$_SESSION['databaseB'].".tab_users WHERE ID_usr = ?;";
	$stmtD5 = mysqli_prepare($mysqli, $sqlD5);
	mysqli_stmt_bind_param($stmtD5, "i", $ID_usr_fam);
	mysqli_stmt_execute($stmtD5);
		

	$return['test'] =  $sql2." con : ID_fam_alu ".$ID_fam_alu." e ".$sqlD5."con : ID_usr_fam trovato da precedente: ".$ID_usr_fam ;
     echo json_encode($return);
?>
