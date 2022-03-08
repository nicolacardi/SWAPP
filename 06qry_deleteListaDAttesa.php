<?	include_once("database/databaseii.php");
	$ID_alu_lda = $_POST['ID_alu_lda'];
	$sql = "DELETE FROM tab_listadattesa WHERE ID_alu_lda = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_alu_lda);
	mysqli_stmt_execute($stmt);
	$return['msg'] = "Cancellazione Lista D'attesa a buon fine";
	echo json_encode($return);
?>
