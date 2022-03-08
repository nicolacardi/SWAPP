<?include_once("database/databaseii.php");

$ID_ret_pag = $_POST['ID_ret_pag'];
$ID_alu_pag = $_POST['ID_alu_pag'];
$data_pag = $_POST['data_pag'];
$importo_pag = $_POST['importo_pag'];
$causale_pag = $_POST['causale_pag'];
$tipo_pag = $_POST['tipo_pag'];
$soggetto_pag = $_POST['soggetto_pag'];
$annoscolastico_pag = $_POST['annoscolastico_pag'];

$sql ="INSERT INTO tab_pagamenti (ID_ret_pag, ID_alu_pag, data_pag, importo_pag, causale_pag, tipo_pag, soggetto_pag, annoscolastico_pag) ".
    " VALUES ('".$ID_ret_pag."', ".$ID_alu_pag.", '".$data_pag."', '".$importo_pag."', '".$causale_pag."', ".$tipo_pag.", ".$soggetto_pag.",  '".$annoscolastico_pag."') ;";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_execute($stmt);


$return['test'] = $sql;
echo json_encode($return);
?>
