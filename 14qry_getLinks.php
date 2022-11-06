<?
    include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	$tab_lnk = $_POST ['tab_lnk'];
	$IDext_lnk = $_POST['IDext_lnk'];
    ?>
    <table id="tabellaLinks" style="margin: auto; ">
        <thead style="font-size: 10px;">
            <tr>
                <th style="width: 25px">

                </th>
                <th>
                    <input class="tablelabel0 w50px" type="text" value = "N" disabled>
                </th>
                <th>
                    <input class="tablelabel0 w175px" type="text" value = "Titolo Documento" disabled>
                </th>
                <th>
                    <input class="tablelabel0 w175px" type="text" value = "LINK" disabled>
                </th>
                <th>
                    <input class="tablelabel0 w50px" type="text" value = "Vai" disabled>
                </th>
                <th style="width: 25px">
				</th>

            </tr>
        </thead>
        <tbody id="tabellaLinksBody">
            <tr>
            </tr>
            <?
            $sql = "SELECT ID_lnk, titolo_lnk, link_lnk FROM tab_links WHERE tab_lnk = ? AND IDext_lnk = ? ORDER BY data_lnk";
            $stmt = mysqli_prepare($mysqli, $sql);
            mysqli_stmt_bind_param($stmt, "si", $tab_lnk, $IDext_lnk);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $ID_lnk, $titolo_lnk, $link_lnk);
            $linkN = 0;
            while (mysqli_stmt_fetch($stmt)) {
                $linkN++;
                ?>
                <tr>
                    <td>
                        <img title="Elimina Link" class="iconaStd" src="assets/img/Icone/times-circle-solid.svg" onclick = "eliminaLink('tab_verbali', <?=$IDext_lnk?>, <?=$ID_lnk?>);">
                    </td>
                    <td>
                        <input class="tablecell3 disab w50px" type="text" value = "<?=$linkN;?>" disabled>
                    </td>
                    <td class="h25 va-top">
                        <input class="tablecell3 disab w175px" type="text" id="titolo_lnk<?=$linkN?>" name="titolo_lnk" value = "<?=$titolo_lnk;?>">
                        <input class="tablecell3 disab w175px" type="text" id="ID_lnk<?=$linkN?>" name="ID_lnk" value = "<?=$ID_lnk;?>" hidden>
                    </td>
                    <td class="h25 va-top">
                        <input class="tablecell3 disab w175px" type="text" id="link_lnk<?=$linkN?>" name="link_lnk" value = "<?=$link_lnk;?>">
                    </td>
                    <td class="h25 va-top">
                        <a href="<?=$link_lnk;?>" target="_blank">
                            <img class="iconaStd" src="assets/img/Icone/attachment.svg" alt="Image Decription">
                        </a>
                    </td>
                </tr>

                <?

            }
            
            ?>
            <tr id="aggiungihtml">
                <td>
                    <img id="plusaggiungi" title="Aggiungi nuovo Link" class="iconaStd" src='assets/img/Icone/circle-plus.svg' onclick="aggiungiLink();">
                </td>
            </tr>
        </tbody>
    </table>
    <input id="linkN_hidden" value ="<?=$linkN?>" hidden>
    <!-- <input id="addingLink" value ="0" > -->

    <script>

    function aggiungiLink() {
        //qui devo aggiungere una riga AL POSTO del td che c'è
		appendhtml = "<td></td><td class='h25 va-top'><input class='tablecell3 disab w175px' type='text' id='titolo_lnk_new' name='titolo_lnk_new'><td class='h25 va-top'><input class='tablecell3 disab w175px' type='text' id='link_lnk_new' name='link_lnk_new'></td>"
        //"<td id='pulsantinosalva'><img  title='salva nuovo componente' style='width: 20px; cursor: pointer' src='assets/img/Icone/save-regular.svg' onclick='savenew_lnk();'>salva</td>";
		$('#aggiungihtml').append(appendhtml);
		$('#inmodifica').val("1");
		$('#plusaggiungi').css('visibility','hidden');
		$('#addingLink').val(1);
	}






    </script>

