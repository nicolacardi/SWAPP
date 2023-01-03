<?

//questa dovrebbe diventare INUTILE: non dovrebbe più chiamarla nessuno
include_once("database/databaseii.php");

$ID_ret_pag = $_POST['ID_ret_pag'];
$causale_pag = $_POST['causale_pag'];
$ID_alu = $_POST ['ID_alu'];
$annoscolastico = $_POST ['annoscolastico'];

if ($causale_pag == 1) {
    //ora SE causale_pag = 1 (si tratta delle rette di un mese) calcolo il nuovo totale e faccio l'update in tabella tab_mensilirette
    $sql2 = "SELECT SUM(importo_pag) as totalePag FROM tab_pagamenti WHERE ID_ret_pag = ? ";
    $stmt2 = mysqli_prepare($mysqli, $sql2);
    mysqli_stmt_bind_param($stmt2, "i", $ID_ret_pag);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $totalePag);
    while (mysqli_stmt_fetch($stmt2)) {
    }

    $sql3 = "UPDATE tab_mensilirette SET pagato_ret = ? WHERE ID_ret = ?";
    $stmt3 = mysqli_prepare($mysqli, $sql3);
    mysqli_stmt_bind_param($stmt3, "ii", $totalePag, $ID_ret_pag);	
    mysqli_stmt_execute($stmt3);
} else {
    //in questo caso si tratta NON di pagamenti di rette bensì di ALTRI pagamenti: il totale si calcola diversamente
    $sql2 = "SELECT SUM(importo_pag) as totalePag FROM tab_pagamenti WHERE ID_alu_pag = ? AND causale_pag <> 1 AND annoscolastico_pag = ?";
    $stmt2 = mysqli_prepare($mysqli, $sql2);
    mysqli_stmt_bind_param($stmt2, "is", $ID_alu, $annoscolastico);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $totalePag);
    while (mysqli_stmt_fetch($stmt2)) {
    }

    //QUESTA E' L'UNICA ISTRUZIONE DI UPDATE DI tab_pagamentialtri rimasta
    // $sql3 = "UPDATE tab_pagamentialtri SET pagato_pga = ? WHERE ID_alu_pga = ? AND annoscolastico_pga = ?";
    // $stmt3 = mysqli_prepare($mysqli, $sql3);
    // mysqli_stmt_bind_param($stmt3, "iis", $totalePag, $ID_alu, $annoscolastico);	
    // mysqli_stmt_execute($stmt3);
}
$return['test'] = $sql;
echo json_encode($return);
?>
