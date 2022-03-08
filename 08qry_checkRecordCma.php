<?include_once("database/databaseii.php");
	//$ID_mae_cma = $_POST['ID_mae_cma'];
	$classe_cma = $_POST['classe_cma'];
	$sezione_cma = $_POST['sezione_cma'];
	//$ruolo_cma = $_POST['ruolo_cma'];
    $codmat_cma = $_POST['codmat_cma'];
    $annoscolastico_cma = $_POST['annoscolastico_cma'];
	$sql2 = "SELECT ID_cma, nome_mae, cognome_mae, aselme_cls FROM (tab_classimaestri JOIN tab_anagraficamaestri ON ID_mae_cma = ID_mae) JOIN tab_classi ON classe_cma = classe_cls WHERE codmat_cma = ? AND classe_cma = ? AND sezione_cma = ? AND annoscolastico_cma = ?";
    $stmt2 = mysqli_prepare($mysqli, $sql2);
    mysqli_stmt_bind_param($stmt2, "ssss", $codmat_cma, $classe_cma, $sezione_cma, $annoscolastico_cma);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $ID_cma, $nome_mae, $cognome_mae, $aselme_cls );
    $n=0;
	while (mysqli_stmt_fetch($stmt2)) {
        $n++;
    }
    if ($n != 0 && $aselme_cls != "AS" && $aselme_cls != "NI") {
        //il vincolo lo devo dare solamente per i maestri di primaria e secondaria in quanto ci sono più maestre  di asilo nella stessa classe
        $return['msg'] = "Materia già insegnata in ".$classe_cma." ".$sezione_cma." da ".$nome_mae." ".$cognome_mae;
        $return['recordcmaGiaPresente'] = true;
    } else {
        $return['msg'] = "Inserimento materia di insegnamento <br> completato con successo! ".
        $return['recordcmaGiaPresente'] = false;
    }
    echo json_encode($return);

?>

