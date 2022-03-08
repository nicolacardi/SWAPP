<?	include_once("database/databaseii.php");
	$codmat_mtt = $_POST['codmat_mtt_new'];
    $descmateria_mtt = $_POST['descmateria_mtt_new'];
    if ($_POST['as_mtt_new'] == 'on') { $as_mtt = 1;} else { $as_mtt = 0;}
    if ($_POST['el_mtt_new'] == 'on') { $el_mtt = 1;} else { $el_mtt = 0;}
    if ($_POST['me_mtt_new'] == 'on') { $me_mtt = 1;} else { $me_mtt = 0;}
    if ($_POST['su_mtt_new'] == 'on') { $su_mtt = 1;} else { $su_mtt = 0;}


	$sql = "INSERT INTO tab_materie (codmat_mtt, descmateria_mtt, as_mtt, el_mtt, me_mtt, su_mtt) VALUES ( ? , ? , ? , ? , ?, ?);";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssiiii", $codmat_mtt, $descmateria_mtt, $as_mtt, $el_mtt, $me_mtt, $su_mtt );
	mysqli_stmt_execute($stmt);
	$return['msg'] = "Inserimento nuova Materia andato a buon fine";
	$return['test']=$sql;
    echo json_encode($return);
?>
