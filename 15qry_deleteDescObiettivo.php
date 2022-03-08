<?  include_once("database/databaseii.php");
    $ID_obd = $_POST['ID_obd'];
    $sql = "DELETE FROM tab_materievotiobiettividesc WHERE ID_obd = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "i", $ID_obd);
    mysqli_stmt_execute($stmt);
    $return['test'] = $sql;
    echo json_encode($return);
?>
