<?	include_once("database/databaseii.php");

    $ID_clo =       $_POST['ID_clo'];
    $ID_cla_clo =   $_POST['ID_cla_clo'];
    $ID_obi_clo =   $_POST['ID_obi_clo'];
    $vot1_clo =     $_POST['vot1_clo'];
    $vot2_clo =     $_POST['vot2_clo'];
    $quad =         $_POST['quad'];
    if ($quad == 1 ) { $vot_clo = $vot1_clo;}  else { $vot_clo = $vot2_clo;}

    if ($ID_clo == "") {
        //A VOLTE FUNZIONA MALE! INSERISCE QUANDO NON DOVREBBE E COSI' CREA DOPPIONI
        $sql = "INSERT INTO tab_classialunnivotiobiettivi (ID_cla_clo, ID_obi_clo, vot".$quad."_clo) VALUES ( ? , ? , ?);";  
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "iis", $ID_cla_clo, $ID_obi_clo, $vot_clo );
        mysqli_stmt_execute($stmt);
        $return['msg'] = "Inserimento Voti Obiettivi andato a buon fine";
        $return['test']=$sql;
    } else {
        $sql = "UPDATE tab_classialunnivotiobiettivi SET vot".$quad."_clo = ? WHERE ID_clo = ?;";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "si", $vot_clo, $ID_clo);
        mysqli_stmt_execute($stmt);
        $return['msg'] = "Aggiornamento Voti Obiettivi andato a buon fine";
        $return['test']=$sql;
    }
    echo json_encode($return);
?>
