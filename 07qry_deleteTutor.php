<?include_once("database/databaseii.php");
    $ID_ora = $_POST['ID_ora'];
    $sql1 = "SELECT IDfirmatutor_ora FROM tab_orario WHERE ID_ora = ? ;";
    $stmt1 = mysqli_prepare($mysqli, $sql1);
    mysqli_stmt_bind_param($stmt1, "i", $ID_ora);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_bind_result($stmt1, $IDfirmatutor_ora);
	while (mysqli_stmt_fetch($stmt1)) {
    }
    
	//trovo il maestro per la materia in questione (usando quindi anche l'anno scolastico, la classe e la sezione)	
    $sql2 = "DELETE FROM tab_orario WHERE ID_ora = ? ;";
    $stmt2 = mysqli_prepare($mysqli, $sql2);
    mysqli_stmt_bind_param($stmt2, "i", $IDfirmatutor_ora);
	mysqli_stmt_execute($stmt2);

    $sql3 = "UPDATE tab_orario SET IDfirmatutor_ora = 0 WHERE ID_ora = ? ;";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "i", $ID_ora);
	mysqli_stmt_execute($stmt3);
	while (mysqli_stmt_fetch($stmt3)) {
    }
	$return['test'] = "sql1 che trova IDfirmatutor_ora: ".$sql1." - IDfirmatutor_ora:".$$IDfirmatutor_ora;
    echo json_encode($return);
?>
