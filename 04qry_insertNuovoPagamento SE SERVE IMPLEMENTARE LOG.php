<?include_once("database/databaseii.php");

$ID_ret_pag = $_POST['ID_ret_pag'];
$ID_alu_pag = $_POST['ID_alu_pag'];
$data_pag = $_POST['data_pag'];
$importo_pag = $_POST['importo_pag'];
$causale_pag = $_POST['causale_pag'];
$tipo_pag = $_POST['tipo_pag'];
$soggetto_pag = $_POST['soggetto_pag'];
$annoscolastico_pag = $_POST['annoscolastico_pag'];

$sql1 ="INSERT INTO tab_pagamenti (ID_ret_pag, ID_alu_pag, data_pag, importo_pag, causale_pag, tipo_pag, soggetto_pag, annoscolastico_pag) ".
    " VALUES ('".$ID_ret_pag."', ".$ID_alu_pag.", '".$data_pag."', '".$importo_pag."', '".$causale_pag."', ".$tipo_pag.", ".$soggetto_pag.",  '".$annoscolastico_pag."') ;";
$stmt = mysqli_prepare($mysqli, $sql1);
mysqli_stmt_execute($stmt);

//QUI VADO AD INSERIRE IL LOG TEMPORANEO
$sqllog1 ="INSERT INTO tab_log (operazione_log, utente_log) VALUES ('".addslashes($sql1)."', ".$_SESSION['ID_usr'].") ;";
$stmt = mysqli_prepare($mysqli, $sqllog1);
mysqli_stmt_execute($stmt);


//Porto qui dentro l'update della tabella tab_mensilirette
if ($causale_pag == 1) {

    //ora SE causale_pag = 1 (si tratta delle rette di un mese) calcolo il nuovo totale e faccio l'update in tabella tab_mensilirette
    $sql2 = "SELECT SUM(importo_pag) as totalePag FROM tab_pagamenti WHERE ID_ret_pag = ? ";
    $stmt2 = mysqli_prepare($mysqli, $sql2);
    mysqli_stmt_bind_param($stmt2, "i", $ID_ret_pag);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $totalePag);
    while (mysqli_stmt_fetch($stmt2)) {
    }

//QUI VADO AD INSERIRE IL LOG TEMPORANEO

$sqllog2 ="INSERT INTO tab_log (operazione_log, utente_log) VALUES ('".$sql2." - con ID_ret_pag = ".$ID_ret_pag."', ".$_SESSION['ID_usr'].") ;";
$stmt = mysqli_prepare($mysqli, $sqllog2);
mysqli_stmt_execute($stmt);

    $sql3 = "UPDATE tab_mensilirette SET pagato_ret = ? WHERE ID_ret = ?";
    $stmt3 = mysqli_prepare($mysqli, $sql3);
    mysqli_stmt_bind_param($stmt3, "ii", $totalePag, $ID_ret_pag);	
    mysqli_stmt_execute($stmt3);

$sqllog3 ="INSERT INTO tab_log (operazione_log, utente_log) VALUES ('".$sql3." - con pagato_ret = ".$totalePag." - con ID_ret_pag = ".$ID_ret_pag."', ".$_SESSION['ID_usr'].") ;";
$stmt = mysqli_prepare($mysqli, $sqllog3);
mysqli_stmt_execute($stmt);

}



$return['test'] = $sql1;
echo json_encode($return);
?>
