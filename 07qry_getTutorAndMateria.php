<?include_once("database/databaseii.php");
//questa routine serve per estrarre il tutor del maestro da mostrare nel modalTutor


    $data = $_POST['data'];
    $classe = $_POST['classe'];
    $sezione = $_POST['sezione'];
    $materia = $_POST['materia'];
    $ID_mae = $_POST['ID_mae'];
    $ID_ora = $_POST['ID_ora'];    //ID dell'ora principale

    //devo intanto risalire all'anno scolastico a partire dalla data (così viene salvato in tab_classimaestri)
    $sql3 = "SELECT annoscolastico_asc FROM tab_anniscolastici WHERE datainizio_asc <= ? AND datafine_asc > ?";
    //attenzione: d'estate questa query non darà risultati! ci vorrebbe anche una datafineanno diversa da datafine_asc!
    $stmt3 = mysqli_prepare($mysqli, $sql3);
    mysqli_stmt_bind_param($stmt3,  "ss", $data, $data);
    mysqli_stmt_execute($stmt3);
    mysqli_stmt_bind_result($stmt3, $annoscolastico_asc);
    while (mysqli_stmt_fetch($stmt3)) {
    }

    //estraggo la descrizione della materia
    $sql4 = "SELECT descmateria_mtt FROM tab_materie WHERE codmat_mtt = ?";
    //attenzione: d'estate questa query non darà risultati! ci vorrebbe anche una datafineanno diversa da datafine_asc!
    $stmt4 = mysqli_prepare($mysqli, $sql4);
    mysqli_stmt_bind_param($stmt4,  "s", $materia);
    mysqli_stmt_execute($stmt4);
    mysqli_stmt_bind_result($stmt4, $descmateria_mtt);
    while (mysqli_stmt_fetch($stmt4)) {
    }

    //ora ho tutto per selezionare il tutor (eventuale)

    // 210207 $sql2 = "SELECT nome_mae, cognome_mae, tutor_cma FROM tab_classimaestri LEFT JOIN tab_anagraficamaestri ON ID_mae = tutor_cma WHERE ID_mae_cma = ? AND classe_cma = ? AND sezione_cma = ? AND codmat_cma = ? AND annoscolastico_cma = ?";
    $sql2 = "SELECT nome_mae, cognome_mae, ID_mae FROM tab_classimaestri LEFT JOIN tab_anagraficamaestri ON ID_mae = ID_mae_cma WHERE tutordi_cma = ? AND classe_cma = ? AND sezione_cma = ? AND codmat_cma = ? AND annoscolastico_cma = ?";
    $stmt2 = mysqli_prepare($mysqli, $sql2);
    mysqli_stmt_bind_param($stmt2,  "issss", $ID_mae, $classe, $sezione, $materia, $annoscolastico_asc);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $nome_mae, $cognome_mae, $tutor_cma);
    // 210207 mysqli_stmt_bind_result($stmt2, $nome_mae, $cognome_mae, $ID_mae);
    while (mysqli_stmt_fetch($stmt2)) {
    }



    //infine vado ad estrarre da tab_orario l'IDfirmatutor_ora per capire se c'è per l'ora principale corrente selezionato un tutor
    //nell'IDfirmatuor viene scritto l'ID_ora di tab_orario nel quale c'è indicata l'ora del tutor!
	$sql5 = "SELECT IDfirmatutor_ora FROM tab_orario WHERE ID_ora = ?";
    $stmt5 = mysqli_prepare($mysqli, $sql5);
    mysqli_stmt_bind_param($stmt5,  "i", $ID_ora);
    mysqli_stmt_execute($stmt5);
    mysqli_stmt_bind_result($stmt5, $IDfirmatutor_ora);
    while (mysqli_stmt_fetch($stmt5)) {
    }

    $return['materia'] = $descmateria_mtt;
    $return['nomecognome_tutor'] = $nome_mae." ".$cognome_mae;
    $return['ID_tutor'] = $tutor_cma;
    //210207 $return['ID_tutor'] = $ID_mae;
    $return['IDfirmatutor_ora'] = $IDfirmatutor_ora; //potrebbe essere vuoto oppure valorizzato con l'ID del record di tab_orario dove sta l'ora del tutor
    echo json_encode($return);
?>