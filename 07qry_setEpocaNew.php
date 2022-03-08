<?include_once("database/databaseii.php");

$data_ora = $_POST['data'];
$ora_ora = $_POST['ora'];
$classe_ora = $_POST['classe'];
$sezione_ora = $_POST['sezione'];
$epoca_ora = $_POST['epoca'];

if ($epoca_ora== 'true') { $epoca_ora = 1;} else { $epoca_ora = 0;}

$sql ="UPDATE tab_orario SET epoca_ora = ? WHERE data_ora = ? AND ora_ora = ? AND classe_ora = ? AND sezione_ora = ?;";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "isiss", $epoca_ora, $data_ora, $ora_ora, $classe_ora, $sezione_ora);
mysqli_stmt_execute($stmt);
$return['test'] = $epoca_ora;
echo json_encode($return);
?>
