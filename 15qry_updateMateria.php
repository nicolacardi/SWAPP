<?	include_once("database/databaseii.php");

    $ID_mtt = $_POST['ID_mtt'];
    $codmat_mtt = $_POST['codmat_mtt'];
    $descmateria_mtt = $_POST['descmateria_mtt'];
    $as_mtt = $_POST['as_mtt'];
    $el_mtt = $_POST['el_mtt'];
    $me_mtt = $_POST['me_mtt'];
    $su_mtt = $_POST['su_mtt'];
    $ord_mtt = $_POST['ord_mtt'];

	$sql = "UPDATE tab_materie SET codmat_mtt = ? , descmateria_mtt = ?, as_mtt = ?, el_mtt = ?, me_mtt = ?, su_mtt = ?, ord_mtt = ? WHERE ID_mtt = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssiiiiii", $codmat_mtt, $descmateria_mtt, $as_mtt, $el_mtt, $me_mtt, $su_mtt, $ord_mtt, $ID_mtt);
	mysqli_stmt_execute($stmt);
	$return['test']=$sql;
	echo json_encode($return);
?>
