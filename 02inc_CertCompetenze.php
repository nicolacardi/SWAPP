<?
$sql = "SELECT codmat_mat, votocertcomp_cer, descmateria_mat, ord_mat 
FROM tab_materievoti  LEFT JOIN  tab_certcompetenze ON codmat_cer = codmat_mat 
AND ID_alu_cer = ? AND annoscolastico_cer = ?  
WHERE codmat_mat <> 'CXX' AND aselme_mat = ? AND tipodoc_mat = 11 ORDER BY ord_mat;";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "iss", $ID_alu, $annoscolastico_cla, $aselme_cla);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $codmat_cer, $votocertcomp_cer, $descmateria_mat, $ord_mat);
mysqli_stmt_store_result($stmt);
?>

<!-- ********************************************** TAB CERT COMPETENZE **********************************************-->
<div class="tab-pane" id="CertCompetenze">
    <table id="tabellaCertCompetenze" style="width:80%; margin-top: 5px;margin-left: 35px;">
        <tbody style="">
            <tr>
                <td style="width: 15%">
                    <button class="btnBlu w100" onclick="salvaCert(<?=$ID_alu;?>, '<?=$annoscolastico_cla;?>', '<?=$classe_cla;?>', '<?=$sezione_cla;?>');">Salva</button>
                </td>
                <td style="width: 25%">
                    <button class="btnBlu" style="width: 100%; margin-left: 10px; " id="Pagelle"
                    onclick="scaricaPagellaPOST(event, <?=$ID_alu;?>, '<?=$annoscolastico_cla;?>', '<?=$classe_cla;?>', '<?=$sezione_cla;?>', 2, 'CerCom');" title="Cert. Competenze->Excel">Cert. Competenze</button>	
                </td>
                <td style="width: 50%">
                </td>
                <td style="width: 1%">
                </td>
                <td style="width: 5%">
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>
            </tr>
            <?$i = 1;
            while (mysqli_stmt_fetch($stmt)) {?>
                <tr>
                    <td colspan="3">
                        <textarea class="tablecell6 voti materia ta" type="text" style="padding-left: 30px; text-align: left; height: 30px; font-size: 12px;" disabled><? echo ($descmateria_mat); ?></textarea>
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        <? $opzioniVoti = array("A", "B", "C", "D"); ?>
                        <select id="selectVotoCert<?echo($i);?>"  style=" margin-left: 0px"  name="<?=$codmat_cer?>" onchange="requery();">
                            <option value="0" <? if($votocertcomp_cer=="0" || !(in_array($votocertcomp_cer, $opzioniVoti))) {echo ('selected');} ?>>-</option>
                            <option value="A" <? if($votocertcomp_cer=="A") {echo ('selected');} ?>>A</option>
                            <option value="B" <? if($votocertcomp_cer=="B") {echo ('selected');} ?>>B</option>
                            <option value="C" <? if($votocertcomp_cer=="C") {echo ('selected');} ?>>C</option>
                            <option value="D" <? if($votocertcomp_cer=="D") {echo ('selected');} ?>>D</option>
                        </select>
                    </td>
                </tr>
            <?
            $i++;
            }?>
            
            <?

            
            $sql9 = "SELECT codmat_mat, votocertcomp_cer, descmateria_mat, ord_mat 
            FROM tab_materievoti  LEFT JOIN  tab_certcompetenze ON codmat_cer = codmat_mat 
            AND ID_alu_cer = ? AND annoscolastico_cer = ?  
            WHERE codmat_mat = 'CXX' AND aselme_mat = ? AND tipodoc_mat = 11 ORDER BY ord_mat;";
            $stmt9 = mysqli_prepare($mysqli, $sql9);
            mysqli_stmt_bind_param($stmt9, "iss", $ID_alu, $annoscolastico_cla, $aselme_cla);
            mysqli_stmt_execute($stmt9);
            mysqli_stmt_bind_result($stmt9, $codmat_cer, $votocertcomp_cer, $descmateria_mat, $ord_mat);
            mysqli_stmt_store_result($stmt9);
            while (mysqli_stmt_fetch($stmt9)) {?>
            <tr>
                <td colspan="5">
                    <textarea class="tablecell6 voti materia ta" type="text" style="height: 40px; font-size: 12px;" disabled><? echo addslashes($descmateria_mat); ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <textarea class="tablecell6 voti" id="selectVotoCert11" name="CXX" type="text" style="height: 90px; font-size: 12px;" maxlength="255" ><? echo ($votocertcomp_cer); ?></textarea>
                </td>
            </tr>
            <?}?>
        </tbody>
    </table>
</div>