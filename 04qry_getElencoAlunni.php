<?include_once("database/databaseii.php");
//$ID_mae = $_POST['ID_mae'];

$annoscolastico_cla = $_POST['annoscolastico_cla'];
$whereannocorrente = " WHERE annoscolastico_cla = '".$annoscolastico_cla."' ";

$sql = "SELECT DISTINCT ID_alu, nome_alu, cognome_alu, classe_cla, sezione_cla, aselme_cla FROM (tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) ".$whereannocorrente." AND listaattesa_cla = 0 ORDER BY classe_cla, sezione_cla, cognome_alu";
//QUERY PARAMETRICA DA FARE - DIFFICILE
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_alu, $nome_alu, $cognome_alu, $classe_cla, $sezione_cla, $aselme_cla);
mysqli_stmt_store_result($stmt);

?>

<select name="selectalunno"   id="selectalunno" onchange="">
    <option value="Tutti">Tutti gli alunni</option>
    <?while (mysqli_stmt_fetch($stmt)) {?>
        <option value="<?=$ID_alu?>"><?echo("(".$classe_cla.$sezione_cla.") ".$nome_alu." ".$cognome_alu);?></option>
    <?}?>
</select>