<?	include_once("database/databaseii.php");
//riceve in input l'anno scolastico e aselme e restituisce val_paa e val2_paa

$annoscolastico = $_POST['annoscolastico'];
$aselme = $_POST['aselme'];

$sql = "SELECT val_paa, val2_paa FROM tab_parametrixanno WHERE annoscolastico_paa = ? AND parname_paa = 'tipopagella_".$aselme."'";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "s", $annoscolastico);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $val_paa, $val2_paa);
while (mysqli_stmt_fetch($stmt))
{}
$return['val_paa']= $val_paa;
$return['val2_paa']= $val2_paa;

echo json_encode($return);
?>

