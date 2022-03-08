<?	include_once("database/databaseii.php");

    $ID_mat = $_POST['ID_mat'];
    $codmat_mat = $_POST['codmat_mat'];
    $descmateria_mat = $_POST['descmateria_mat'];
    $aselme_mat = $_POST['aselme_mat'];
    $ord_mat = $_POST['ord_mat'];

	$sql = "UPDATE tab_materievoti SET codmat_mat = ? , descmateria_mat = ?, aselme_mat = ?, ord_mat = ? WHERE ID_mat = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "sssii", $codmat_mat, $descmateria_mat, $aselme_mat, $ord_mat, $ID_mat);
	mysqli_stmt_execute($stmt);
	$return['test']=$sql;
	echo json_encode($return);
?>
