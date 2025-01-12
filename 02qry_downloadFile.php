<?include_once("database/databaseii.php");
	
	$ID_doc = $_POST['ID_doc'];
	
	$sql = "SELECT titolo_doc, contenuto_doc FROM tab_documenti WHERE ID_doc = ? ;";
	
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $ID_doc);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $titolo_doc, $contenuto_doc);

	if (mysqli_stmt_fetch($stmt)) {
        echo json_encode([
            'success' => true,
            'titolo_doc' => $titolo_doc,
            'contenuto_doc' => $contenuto_doc
        ]);
    } else {
        echo json_encode(['success' => false]);
    }

?>
