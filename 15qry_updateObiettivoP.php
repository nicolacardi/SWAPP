<?	include_once("database/databaseii.php");

    $ID_obd = $_POST['ID_obd'];
    $classe_obd = $_POST['classe_obd'];
    $desc_obd = $_POST['desc_obd'];
    $ord_obd = $_POST['ord_obd'];


	$sql = "UPDATE tab_materievotiobiettividesc SET classe_obd = ? , desc_obd = ?, ord_obd = ? WHERE ID_obd = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssii", $classe_obd, $desc_obd, $ord_obd, $ID_obd);
	mysqli_stmt_execute($stmt);
	$return['test']=$sql;
	echo json_encode($return);
?>
