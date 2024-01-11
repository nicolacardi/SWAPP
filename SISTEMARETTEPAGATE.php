<?  include_once("database/databaseii.php");

$filename = "reportpulizia.txt";

    $handle = fopen($filename, "w");
    fwrite($handle, "\n INIZIA");


$sql = "SELECT ID_ret_pag, SUM(importo_pag) FROM tab_pagamenti WHERE annoscolastico_pag = '2023-24' GROUP BY ID_ret_pag";

$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_ret_pag, $importo_pag);
mysqli_stmt_store_result($stmt);


while (mysqli_stmt_fetch($stmt)) {

    $sql2 = "SELECT ID_ret, pagato_ret, nome_alu, cognome_alu, mese_ret FROM tab_mensilirette LEFT JOIN tab_anagraficaalunni ON ID_alu_ret = ID_alu WHERE ID_ret  = ?";
    $stmt2 = mysqli_prepare($mysqli, $sql2);
    mysqli_stmt_bind_param($stmt2, "i", $ID_ret_pag);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $ID_ret, $pagato_ret, $nome_alu, $cognome_alu, $mese_ret);
    mysqli_stmt_store_result($stmt2);
    while (mysqli_stmt_fetch($stmt2)) {
        if ($importo_pag != $pagato_ret)
{
        //fwrite($handle, $ID_ret."#".$nome_alu." ".$cognome_alu."#".$mese_ret."# pagato: #".$importo_pag."# mese: #".$mese_ret."\n");

        $sql2 = "UPDATE tab_mensilirette SET pagato_ret = ".$importo_pag." WHERE ID_ret = ".$ID_ret.";";
        // $stmt = mysqli_prepare($mysqli, $sql);
        // mysqli_stmt_execute($stmt);
        fwrite($handle, $sql2."\n");
}


    }
}

fclose($handle);
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$filename.'"');
readfile($filename);
?>
