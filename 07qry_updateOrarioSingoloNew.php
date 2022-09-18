<?include_once("database/databaseii.php");

//epoca_ora è il flag che indica se l'ora è di epoca...per ora scelgo di non inserire questo valore nei record dei secondi amestri e tutor...
//per cambiare è necessario passare alla routine corrente quel valore...
//ma ovviamente poi in caso di modifica di quel flag va modificato anche il record della seconda ora e/o tutor
//per ora non lo inserisco
$IDora2 = $_POST['IDora2'];
$materia2 = $_POST['materia2'];

//se è stato selezionato Pranzo o Intervallo non c'è un ID_mae, quindi bisogna mettercelo = 0 altrimenti la insert non funziona
if($materia2 == 'XX1' || $materia2 == 'XX3' || $materia2 == 'XX4') {
    $ID_mae2 = 0;
} else {
    $ID_mae2 = $_POST['ID_mae2'];
}
$data2 = $_POST['data2'];
$ora2 = $_POST['ora2'];
$classe2 = $_POST['classe2'];
$sezione2 = $_POST['sezione2'];


//verifico se ci sono altre materie già inserite per quest'ora
//se non ce ne sono la materia che stiamo inserendo è quella principale e quindi secondomaestro_ora va messo =0
//altrimenti va messo = 1
$sql = "SELECT ID_ora 
FROM tab_orario 
WHERE data_ora = ? AND ora_ora = ?
AND classe_ora = ? AND sezione_ora = ?";

$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $data2, $ora2, $classe2, $sezione2);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_ora);
$secondomaestro_ora = 0;
while (mysqli_stmt_fetch($stmt)) {
    $secondomaestro_ora = 1;
}


if ($IDora2 == 0) {
    $sql2 ="INSERT INTO tab_orario (data_ora, ora_ora, codmat_ora, classe_ora, sezione_ora, ID_mae_ora, secondomaestro_ora) ".
        " VALUES ('".$data2."', ".$ora2.", '".$materia2."', '".$classe2."', '".$sezione2."', ".$ID_mae2.", ".$secondomaestro_ora.") ;";
} else {
    $sql2 ="UPDATE tab_orario SET codmat_ora = '".$materia2."' , ID_mae_ora = ".$ID_mae2." , secondomaestro_ora = ".$secondomaestro_ora." ".
        " WHERE ID_ora= ".$IDora2.";";
}
$stmt2 = mysqli_prepare($mysqli, $sql2);
mysqli_stmt_execute($stmt2);
$return['test'] = $sql2;
echo json_encode($return);
?>
