<?include_once("database/databaseii.php");

$ID_ora = $_POST['ID_ora'];
$materia = $_POST['materia'];
$ID_mae = $_POST['ID_mae'];
$data = $_POST['data'];

$data = date('Y-m-d', strtotime(str_replace('/','-', $data)));

$ora = $_POST['ora'];
$classe = $_POST['classe'];
$sezione = $_POST['sezione'];

$sql ="INSERT INTO tab_orario (data_ora, ora_ora, codmat_ora, classe_ora, sezione_ora, ID_mae_ora, secondomaestro_ora) ".
" VALUES ('".$data."', ".$ora.", '".$materia."', '".$classe."', '".$sezione."', ".$ID_mae.", 1) ;";
mysqli_query($mysqli, $sql);
$ID_oraAppenainserito = mysqli_insert_id($mysqli);

//ora devo anche aggiornare IDfirmatutor con l'ID appena inserito: infatti NB!!!!: nell'IDfirmatutor viene scritto l'ID di tab_orario
//del record di tab_orario dove è stato scritto il tutor della stessa ora!
$sql2 ="UPDATE tab_orario SET IDfirmatutor_ora = ? WHERE ID_ora = ? ";
$stmt2 = mysqli_prepare($mysqli, $sql2);
mysqli_stmt_bind_param($stmt2, "ii", $ID_oraAppenainserito, $ID_ora);
mysqli_stmt_execute($stmt2);

$return['test'] = "sql2: ".$sql2." IDorainserita (ora del tutor): ".$ID_oraAppenainserito." IDoraassociata (ora del maestro principale): ".$ID_ora;
echo json_encode($return);
?>
