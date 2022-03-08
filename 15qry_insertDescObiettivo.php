<?  include_once("database/databaseii.php");
    $select_obiettivo = $_POST['select_obiettivo'];
    $classe_obd = $_POST['select_classe'];
    $desc_obd = $_POST['desc_obd'];
    $ID_obi_obd = strval(substr ($select_obiettivo, 3));
    $sql = "INSERT INTO  tab_materievotiobiettividesc (ID_obi_obd, classe_obd, desc_obd) VALUES (?,?,?)";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "iss", $ID_obi_obd, $classe_obd, $desc_obd);
    mysqli_stmt_execute($stmt);
        $return['test'] = $ID_obi_obd;
        echo json_encode($return);

?>
