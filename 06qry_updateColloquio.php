<?include_once("database/databaseii.php");

	$ID_clq = $_POST['ID_clq'];
	$data_clq = date('Y-m-d', strtotime(str_replace('/','-', $_POST['data_clq'])));
	if ( !empty($_POST['incontrocon_clq'])) {
		$incontrocon_clq = implode(",", $_POST['incontrocon_clq']);
    }

    $note_clq = addslashes($_POST['note_clq']);

    $ckpadre_clq = $_POST['ckpadre_clq'];
    $ckmadre_clq = $_POST['ckmadre_clq'];

    $richiestoda_clq = $_POST['richiestoda_clq'];

    $tipo_clq = $_POST['tipo_clq'];

    $visibileda_clq = $_POST['visibileda_clq'];

    $sql = "UPDATE tab_colloquifam SET data_clq = ?, incontrocon_clq = ?, note_clq = ?, ckpadre_clq = ?, ckmadre_clq = ?, richiestoda_clq = ?, tipo_clq = ?, visibileda_clq = ?
    WHERE ID_clq = ? ";

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "sssiiiiii", $data_clq, $incontrocon_clq, $note_clq, $ckpadre_clq, $ckmadre_clq, $richiestoda_clq, $tipo_clq, $visibileda_clq, $ID_clq );
    mysqli_stmt_execute($stmt);
	
	$return['test'] = $sql;
     echo json_encode($return);
?>
