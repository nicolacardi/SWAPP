<?include_once("database/databaseii.php");

	$ID_cla = $_POST['ID_cla'];
    $scalino_cla = $_POST['scalino_cla'];

    $sql = "UPDATE tab_classialunni SET scalino_cla = ? WHERE ID_cla = ? ";

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $scalino_cla, $ID_cla);
    mysqli_stmt_execute($stmt);
	
	$return['test'] = $sql;
    echo json_encode($return);
?>
