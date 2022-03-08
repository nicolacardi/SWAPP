<?	include_once("database/databaseii.php");
	$codmat_mat = $_POST['codmat_mat_new'];
    $descmateria_mat = $_POST['descmateria_mat_new'];
    $aselme_mat = $_POST['selectaselme_mat_new'];
    $tipodoc_mat = $_POST['selecttipodoc_mat_new'];
	$sql = "INSERT INTO tab_materievoti (codmat_mat, descmateria_mat, aselme_mat, tipodoc_mat) VALUES ( ? , ? , ? , ? );";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "sssi", $codmat_mat, $descmateria_mat, $aselme_mat, $tipodoc_mat );
	mysqli_stmt_execute($stmt);
	$return['msg'] = "Inserimento nuova Materia per pagella andato a buon fine";
	$return['test']=$sql;
    echo json_encode($return);
?>
