<?	include_once("database/databaseii.php");

    $ID_mat = $_POST['ID_mat'];
    $codmat_mat = $_POST['codmat_mat'];
    $descmateria_mat = $_POST['descmateria_mat'];
    $aselme_mat = $_POST['aselme_mat'];
    $ord_mat = $_POST['ord_mat'];
	$tipodoc_mat = $_POST['tipodoc_mat']; //aggiunta

	$sql = "UPDATE tab_materievoti SET codmat_mat = ? , descmateria_mat = ?, aselme_mat = ?, ord_mat = ?, tipodoc_mat= ? WHERE ID_mat = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "sssiii", $codmat_mat, $descmateria_mat, $aselme_mat, $ord_mat, $tipodoc_mat, $ID_mat);
	mysqli_stmt_execute($stmt);
	$return['test']=$sql."- ID_mat=".$ID_mat."- codmat_mat=".$codmat_mat."- descmateria_mat=".$descmateria_mat."- aselme_mat=".$aselme_mat."- ord_mat=".$ord_mat."- tipodoc_mat=".$tipodoc_mat;
	echo json_encode($return);
?>
