<?  include_once("database/databaseii.php");
    $ID_obi = $_POST['ID_obi'];
    $sql = "DELETE FROM tab_materievotiobiettivi WHERE ID_obi = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "i", $ID_obi);
    mysqli_stmt_execute($stmt);
    $return['test'] = $sql;
    echo json_encode($return);
?>
