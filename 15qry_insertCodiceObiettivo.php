<?  include_once("database/databaseii.php");
    $IDmat = $_POST['IDmat'];
    $codob_obi = $_POST['codob_obi'];
    $sql = "INSERT INTO  tab_materievotiobiettivi (ID_mat_obi, codob_obi) VALUES (?,?)";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "is", $IDmat, $codob_obi);
    mysqli_stmt_execute($stmt);
    $return['test'] = $sql;
    echo json_encode($return);
?>
