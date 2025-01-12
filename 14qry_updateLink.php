<?	include_once("database/databaseii.php");

    $ID_lnk = $_POST['ID_lnk'];
	$titolo_lnk = $_POST['titolo_lnk'];
	$link_lnk = $_POST['link_lnk'];


    $sql = "UPDATE tab_links SET titolo_lnk = ? , link_lnk = ? WHERE ID_lnk = ?";

	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssi", $titolo_lnk, $link_lnk, $ID_lnk );
	mysqli_stmt_execute($stmt);
	$return['msg'] = "Aggiornamento link andato a buon fine";
	$return['test']=$sql;
    echo json_encode($return);
?>
