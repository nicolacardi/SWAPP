<? include_once("database/databaseii.php");
	$ID_mtt = $_POST['ID_mtt'];

    //cancello da tab_users
    $sql3 = "DELETE FROM tab_materie ".
    " WHERE ID_mtt = ? ;";	
    $stmt3 = mysqli_prepare($mysqli, $sql3);
    mysqli_stmt_bind_param($stmt3, "i", $ID_mtt);	
    mysqli_stmt_execute($stmt3);
    $return['msg'] = "Cancellazione Materia effettuata";

    echo json_encode($return);
?>
