<?include_once("database/databaseii.php");
	$ID_clq = $_POST['ID_clq'];
    $sql = "DELETE FROM tab_colloquifam WHERE ID_clq = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "i", $ID_clq);
    mysqli_stmt_execute($stmt);
    echo json_encode($return);
?>
