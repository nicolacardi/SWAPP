<?
//questa routine fa parte della procedura richiesta dai maestri e poi mai terminata di modificare i giudizi a partire da degli standard
//e' rimasta lettera <morta class=""></morta>

include_once("database/databaseii.php");
$classe = $_POST ['classe'];
$materia = $_POST ['materia'];
$quadrimestre = $_POST ['quadrimestre'];?>

<?$sql = "SELECT descmateria_mat FROM tab_materievoti WHERE codmat_mat = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "s", $materia);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $descmateria_mat);
while (mysqli_stmt_fetch($stmt)){}?>


<div class="col-md-12" style="font-size: 16px; margin-bottom: 20px; ">
    Classe: <?=$classe?> - Materia/Area: <?=$descmateria_mat?> - Quadrimestre: <?=$quadrimestre?>
</div>
<?$sql = "SELECT descrizione_gds, combo_gds FROM tab_giudizidesc WHERE classe_gds = ? AND materia_gds = ? ORDER BY combo_gds; ";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "ss", $classe, $materia);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $descrizione_gds, $combo_gds);
$ncombotot = 0;
while (mysqli_stmt_fetch($stmt)){
    $ncombotot++;
}
?> <input type="text" id="ncombos" value="<?=$ncombotot?>" hidden><?
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $descrizione_gds, $combo_gds);
mysqli_stmt_store_result($stmt);
?><div class="col-md-10 col-md-offset-1"><?
$ncombo = 0;
while (mysqli_stmt_fetch($stmt)) {
    $ncombo++;
    //per ogni combo, cioè per ogni record, ora devo estrarre i valori dall'altra tabella
    $sql2 = "SELECT valore_gvl, voto_gvl FROM tab_giudizival WHERE classe_gvl = ? AND materia_gvl = ? AND quadrimestre_gvl = ? AND combo_gvl = ? ORDER BY combo_gvl , ordincombo_gvl; ";
    $stmt2 = mysqli_prepare($mysqli, $sql2);
    mysqli_stmt_bind_param($stmt2, "ssss", $classe, $materia, $quadrimestre, $combo_gds);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $valore_gvl, $voto_gvl);
    ?>
    <div class="row" >
        <input type="text" id="desc<?=$ncombo?>" value="<?=$descrizione_gds?>" hidden>
        <?echo ($descrizione_gds);?>
    </div>

    <select name="select<?=$ncombo?> style=" id="select<?=$ncombo?>" style="width: 100%; margin-bottom: 15px; " onchange="concatenaSelect();">
        <option value="">-</option>
        <? while (mysqli_stmt_fetch($stmt2)) {?>
        <option value="<?=$valore_gvl?>">
        <column><?if ($voto_gvl!="") {echo("[".$voto_gvl."]");}?></column>
            <column><?=$valore_gvl?></column>
        </option>
        <?}?>
    </select>
<?}?>
    <textarea style="width: 100%; height: 100px; margin-top:10px;" id="giudizio" ></textarea>
</div>
<script>
	function concatenaSelect() {
	    let ncombos = $("#ncombos").val();
	    giudizio = "";
	    for (i = 1; i <= ncombos; i++) {
	        combo = $("#select" + i);
	        combodesc = $("#desc" + i);
	        if (combo.val() != undefined && combo.val() != "") {
	            giudizio = giudizio + combodesc.val() + " " + combo.val() + "\n" ;
	        }
        }
        giudizio = giudizio.slice(0, -1);
	    $("#giudizio").html(giudizio);
	}
</script>
