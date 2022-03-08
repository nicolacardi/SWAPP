<?  include_once("database/databaseii.php");

$filename = "reportpulizia.txt";

    $handle = fopen($filename, "w");
    fwrite($handle, "\n INIZIA");


$sql = "SELECT ID_clo, ID_cla_clo, ID_obi_clo FROM tab_classialunnivotiobiettivi";

$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_cloOR, $ID_cla_clo, $ID_obi_clo);
mysqli_stmt_store_result($stmt);


while (mysqli_stmt_fetch($stmt)) {
    $contaquanti= 0; 
    $sql2 = "SELECT ID_clo FROM tab_classialunnivotiobiettivi WHERE ID_cla_clo = ? AND ID_obi_clo = ?";
    $stmt2 = mysqli_prepare($mysqli, $sql2);
    mysqli_stmt_bind_param($stmt2, "ii", $ID_cla_clo, $ID_obi_clo);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $ID_clo);
    mysqli_stmt_store_result($stmt2);
    while (mysqli_stmt_fetch($stmt2)) {
        $contaquanti++;
    }
    if ($contaquanti != 1) {
        fwrite($handle, $ID_cloOR."ce ne sarebbero stati".$contaquanti."\n");
    	$sql3 = "DELETE FROM tab_classialunnivotiobiettivi WHERE ID_cla_clo = ? AND ID_obi_clo = ? AND ID_clo <> ? ;";
        $stmt3 = mysqli_prepare($mysqli, $sql3);
        mysqli_stmt_bind_param($stmt3, "iii", $ID_cla_clo, $ID_obi_clo, $ID_cloOR);
        mysqli_stmt_execute($stmt3);
    }
}

fclose($handle);
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$filename.'"');
readfile($filename);
?>
