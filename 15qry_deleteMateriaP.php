<? include_once("database/databaseii.php");
	$ID_mat = $_POST['ID_mat'];

    $sql = "DELETE FROM tab_materievoti ".
    " WHERE ID_mat = ? ;";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "i", $ID_mat);	
    mysqli_stmt_execute($stmt);

    //trovi gli obiettivi corrispondenti alla materia, da tab_materievotiobiettivi
    $sql2 = "SELECT ID_obi FROM tab_materievotiobiettivi WHERE ID_mat_obi = ? ;";
    $stmt2 = mysqli_prepare($mysqli, $sql2);
    mysqli_stmt_bind_param($stmt2, "i", $ID_mat);	
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $ID_obi);
    mysqli_stmt_store_result($stmt2);
	//per ciascun obiettivo cancello in tab_materievotiobiettividesc ogni descrizione
	while (mysqli_stmt_fetch($stmt2)) {
        $sql3 = "DELETE FROM tab_materievotiobiettividesc WHERE ID_obi_obd = ? ;";
        $stmt3 = mysqli_prepare($mysqli, $sql3);
        mysqli_stmt_bind_param($stmt3, "i", $ID_obi);	
        mysqli_stmt_execute($stmt3);
	}

    //solo infine cancello anche gli obiettivi
    $sql4 = "DELETE FROM tab_materievotiobiettivi WHERE ID_mat_obi = ? ;";
    $stmt4 = mysqli_prepare($mysqli, $sql4);
    mysqli_stmt_bind_param($stmt4, "i", $ID_mat);	
    mysqli_stmt_execute($stmt4);


    $return['msg'] = "Cancellazione Materia effettuata";

    echo json_encode($return);
?>
