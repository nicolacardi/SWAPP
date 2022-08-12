<?  include_once("database/databaseii.php");
//questo file prepara l'html da inserire nel modal per l'inserimento dei votiObiettivi
$ID_cla =       $_POST['ID_cla'];         //ID del record della materia classialunnivoti (dove andiamo a scrivere i voti e i giudizi)
$ID_mat_obi =   $_POST['ID_mat_obi'];     //ID della materia di cui si cercano gli obiettivi in tab_materievotiobiettivi e tab_materievotiobiettividesc
$classe_obd =   $_POST['classe_obd'];     //classe
$quad =         $_POST['quad'];           //quadrimestre

//devo ripetere le codifiche dei voti da mostrare in quanto il file presente non viene included ma viene richiamato da una POST
$CODtipovoto = array("idle", "0", "AC", "BA", "IN", "AV");
$DESCtipovoto = array("idle", "-", "In Via di Acquisizione", "Base", "Intermedio", "Avanzato");
$CODtipovotoN = count($CODtipovoto) - 1 ;

$w1 = 110;
$fontS = 12;
$Hriga = '44px';
?>
<input id ="ID_cla_hidden"  type="text"  value = "<?=$ID_cla;?>" hidden> <?//a questo record verranno associati i voti dati agli obiettivi?>
<input id ="quad_hidden"    type="text"  value = "<?=$quad;?>" hidden>   <?//vi è un solo form per entrambi i quadrimestri quindi serve distinguere per quale si sta lavorando?>
<table id ="tabellaObiettivi" style="display: inline-block;">
    <thead style="font-size: 10px;">
        <tr>
            <th style="width: 2px">
                <!-- <input class="tablelabel0 w100" type="text" value = "ID_cla" disabled>  -->
            </th>
            <th style="width: 2px">
                <!-- <input class="tablelabel0 w100" type="text" value = "ID_clo" disabled>  -->
            </th>
            <th style="width: 2px">
                 <!-- <input class="tablelabel0 w100" type="text" value = "ID_obi" disabled> -->
            </th>
            <th style="width: 35px">
                <input class="tablelabel0 w100" type="text" value = "Cod." disabled>
            </th>
            <th style="width: 300px">
                <input class="tablelabel0 w100" type="text" value = "Obiettivo" disabled>
            </th>
            <th style="width: 110px">
                <input class="tablelabel0 w100" type="text" value = "Obiettivo" disabled>
            </th>
        </tr>
    </thead>
    <tbody>
        <?



        $sql = "SELECT ID_clo, ID_obi, ID_mat_obi, codob_obi, descob_obi, desc_obd, classe_obd, ID_clo, vot1_clo, vot2_clo 
        FROM (( tab_materievotiobiettivi JOIN tab_materievotiobiettividesc ON ID_obi = ID_obi_obd AND classe_obd = ? )
        LEFT JOIN tab_classialunnivotiobiettivi ON ID_obi = ID_obi_clo AND ID_cla_clo = ? ) WHERE ID_mat_obi = ? ORDER BY codob_obi";

        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "sii", $classe_obd, $ID_cla, $ID_mat_obi);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $ID_clo, $ID_obi, $ID_mat_obi, $codob_obi, $descob_obi, $desc_obd, $classe_obd, $ID_clo, $vot1_clo, $vot2_clo);

        $n_obiettivo = 0;
        while (mysqli_stmt_fetch($stmt)) {
            if ($quad == 1) { $vot_clo = $vot1_clo;} else { $vot_clo = $vot2_clo;}
            $n_obiettivo ++;
            ?>
            <tr>
                <td>
                    <!-- ID_clo<?//=$ID_clo?> classe_obd<?//=$classe_obd?> ID_cla<?//=$ID_cla?> ID_mat_obi<?//=$ID_mat_obi?> -->
                    <input class="tablecell6 disab" style= "height: 46px;" type="text" id="ID_cla<?=$n_obiettivo?>" name="ID_cla<?=$n_obiettivo?>" value = "<?=$ID_cla?>" hidden>
                </td>
                <td>
                    <input class="tablecell6 disab" style= "height: 46px;" type="text" id="ID_clo<?=$n_obiettivo?>" name="ID_clo<?=$n_obiettivo?>" value = "<?=$ID_clo?>" hidden>
                </td>
                <td>
                    <input class="tablecell6 disab" style= "height: 46px;" type="text" id="ID_obi<?=$n_obiettivo?>" name="ID_obi<?=$n_obiettivo?>" value = "<?=$ID_obi?>" hidden>
                </td>
                <td>
                    <input class="tablecell6 disab" style= "height: 46px;" type="text" id="codob_obi<?=$ID_obi?>" name="codob_obi<?=$ID_obi?>" value = "<?=$codob_obi?>" readonly>
                </td>
                <td style="padding-top: 4px;">
                    <textarea class="w100" style="min-height: 46px; resize: vertical;" readonly><?=$desc_obd?></textarea>
                </td>
                <td>
                <select id ="vot<?=$quad?>_clo<?=$n_obiettivo?>" class="votcellgiu" style="height:<?=$Hriga?>; font-size: <?=$fontS?>px;" >
                    <?for ($x = 1; $x <= $CODtipovotoN; $x++) {?>
                        <option value="<?=$CODtipovoto[$x]?>" 
                            <? if($vot_clo==$CODtipovoto[$x]) {echo ('selected');} ?>><?=$DESCtipovoto[$x]?></option>
                    <?}
                    ?>
                </select>
                </td>
            </tr>
            
        <?}?>
        <input id ="n_obiettivi_hidden" type="text"  value = "<?=$n_obiettivo;?>" hidden>

    </tbody>
</table>


