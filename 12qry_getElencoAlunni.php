<?include_once("database/databaseii.php");
//$ID_mae = $_POST['ID_mae'];

$annoscolastico_cla = $_POST['annoscolastico_cla'];
$classe_cla = $_POST['classe_cla'];
$sezione_cla = $_POST['sezione_cla'];
$whereannocorrente = " WHERE annoscolastico_cla = '".$annoscolastico_cla."' ";
$whereclasse = "AND (classe_cla = '".$classe_cla."' AND sezione_cla = '".$sezione_cla."' AND listaattesa_cla = 0)";


$sql = "SELECT DISTINCT ID_alu, nome_alu, cognome_alu, classe_cla, sezione_cla, aselme_cla FROM (tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) ".$whereannocorrente.$whereclasse." ORDER BY classe_cla, sezione_cla, cognome_alu";
//QUERY PARAMETRICA DA FARE - DIFFICILE
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_alu, $nome_alu, $cognome_alu, $classe_cla, $sezione_cla, $aselme_cla);
mysqli_stmt_store_result($stmt);

?>

<select name="selectalunno"   id="selectalunno" onchange="">
<?while (mysqli_stmt_fetch($stmt)) {
	if (($classe_cla =="V") || ($classe_cla =="VIII")) { $CerCom = 1;} else { $CerCom = 0;}
	?>
	<option value="<?=$aselme_cla.$CerCom.$ID_alu?>"><?echo("(".$classe_cla.$sezione_cla.") ".$nome_alu." ".$cognome_alu);?></option>
<?}?>
</select>