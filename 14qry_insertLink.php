<?	include_once("database/databaseii.php");
    $tab_lnk = $_POST['tab_lnk'];
	$titolo_lnk = $_POST['titolo_lnk'];
    $IDext_lnk = $_POST['IDext_lnk'];
	$link_lnk = $_POST['link_lnk'];


	$sql = "INSERT INTO tab_links (tab_lnk, titolo_lnk, IDext_lnk, link_lnk) VALUES ( ? , ? , ? , ?);";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssis", $tab_lnk, $titolo_lnk, $IDext_lnk, $link_lnk );
	mysqli_stmt_execute($stmt);
	$return['msg'] = "Inserimento nuovo link andato a buon fine";
	$return['test']=$sql;
    echo json_encode($return);
?>
