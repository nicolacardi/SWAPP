<?  include_once("database/databaseii.php");?>
<table id="tabellaObiettivi" style="display: inline-block;">

        <thead style="font-size: 10px;">
            <tr>
                <th style="width: 25px">
                    
                </th>

                <th style="width: 80px">
                    <input class="tablelabel0 w100" type="text" value = "Codice Obiettivo" disabled>
                </th>
                <th style="width: 25px">

                </th>
            </tr>
        </thead>
        <tbody>
    <?  $IDmat = $_POST['IDmat'];
        $sql = "SELECT ID_obi, ID_mat_obi, codob_obi, descob_obi FROM tab_materievotiobiettivi WHERE ID_mat_obi= ?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "i", $IDmat);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $ID_obi, $ID_mat_obi, $codob_obi, $descob_obi);
        while (mysqli_stmt_fetch($stmt)) {?>
            
            <tr>
                <td>
                <img title="Elimina Obiettivo" class="iconaStd" src="assets/img/Icone/times-circle-solid.svg" onclick = "deleteCodiceObiettivo(<?=$ID_obi?>, <?=$IDmat?>);">
                </td>
                <td>
                    <input class="tablecell6 disab" type="text" id="codob_obi<?=$ID_obi?>" name="codob_obi<?=$ID_obi?>" value = "<?=$codob_obi?>" readonly>
                </td>
                <td>
                
                </td>
            </tr>
            
        <?}?>
        <tr>
            <td>
                
            </td>

            <td>
                <input class="tablecell6 disab" type="text" id="codob_obi_new" maxlength = "3" name="codob_obi<?=$ID_obi?>" value = "<?=$codob_obi?>">
            </td>
            <td>
                <img id="plusaggiungi" title="Aggiungi nuovo Componente"  class="iconaStd" src='assets/img/Icone/save-regular-blue.svg' onclick="aggiungiCodiceObiettivo(<?=$IDmat?>);">
            </td>
        </tr>

    </tbody>
</table>
