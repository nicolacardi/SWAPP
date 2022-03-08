<?include_once("database/databaseii.php");
	
	//questa routine serve per
	//verificare se il maestro che fa da tutor è già impegnato in quell'ora nella stessa classe o altrove
    $ID_ora = $_POST['ID_ora'];
	$ID_mae = $_POST['ID_mae'];
	$dataGG = $_POST['data'];
	$ora = $_POST['ora'];

    //Vedo se il maestro non è già impegnato in altra classe
    $sql2 = "SELECT ID_ora, codmat_ora, classe_ora, sezione_ora FROM tab_orario WHERE ID_mae_ora  = ? AND data_ora  = ? AND ora_ora = ? AND !(ID_ora = ?) ;";
    $stmt2 = mysqli_prepare($mysqli, $sql2);
    mysqli_stmt_bind_param($stmt2, "isii", $ID_mae, $dataGG, $ora, $ID_ora);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $ID_ora, $codmat_ora, $classe_oraPrec, $sezione_oraPrec);
    $ID_oraPrec = 0;
    while (mysqli_stmt_fetch($stmt2)) {
        $ID_oraPrec++;
    }
    if ($ID_oraPrec != 0) {
        $return['responso'] = "NO_2";
        //per l'ulteriore maestro non mostro tutto il messaggio ma solo una parte
        $msg = "Il tutor è già impegnato almeno in classe ".$classe_oraPrec." ".$sezione_oraPrec;
        $return['msg'] = $msg;
    } else {
        $return['msg'] = "";
        $return['responso'] = "OK";
    }
	$return['test'] = $ID_oraPrec;
    echo json_encode($return);
?>
