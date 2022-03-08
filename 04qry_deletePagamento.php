<?include_once("database/databaseii.php");
	$ID_pag = $_POST['ID_pag'];

	$sql1 = "DELETE FROM tab_pagamenti WHERE ID_pag = ? ;";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "i", $ID_pag);
	mysqli_stmt_execute($stmt1);

	$return['test'] = $sql1;
    echo json_encode($return);
?>
