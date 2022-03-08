<?include_once("database/databaseii.php");

	$ID_cla = $_POST['ID_cla'];
    $annoscolastico_cla = $_POST['annoscolastico_cla'];
    $ID_alu = $_POST['ID_alu'];
    $sezione = $_POST['sezione'];

    $sql1 = "UPDATE tab_classialunni SET sezione_cla = ? WHERE ID_cla = ? ";

    $stmt1 = mysqli_prepare($mysqli, $sql1);
    mysqli_stmt_bind_param($stmt1, "si", $sezione, $ID_cla);
    mysqli_stmt_execute($stmt1);
	
    $sql2 = "UPDATE tab_classialunnivoti SET sezione_cla = ? WHERE annoscolastico_cla = ? AND ID_alu_cla = ?";

    $stmt2 = mysqli_prepare($mysqli, $sql2);
    mysqli_stmt_bind_param($stmt2, "ssi", $sezione, $annoscolastico_cla, $ID_alu);
    mysqli_stmt_execute($stmt2);

    $sql3 = "UPDATE tab_certcompetenze SET sezione_cer = ? WHERE annoscolastico_cer = ? AND ID_alu_cer = ?";

    $stmt3 = mysqli_prepare($mysqli, $sql3);
    mysqli_stmt_bind_param($stmt3, "ssi", $sezione, $annoscolastico_cla, $ID_alu);
    mysqli_stmt_execute($stmt3);

	$return['test1'] = $sql1;
    $return['test2'] = $sql2;
    $return['test3'] = $sql3;
    echo json_encode($return);
?>
