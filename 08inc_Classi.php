<!-- ********************************************** TAB CLASSI ASSEGNATE **********************************************-->
<div class="tab-pane"  id="Classi">
    <div class="row center" style="font-size:16px; margin-top: 30px; ">
        <div class="col-md-4 col-sm-3 col-xs-0 itemSchedaAnagrafica">
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 itemSchedaAnagrafica">
            <button class="btnBlu" style=" width: 90%; margin-top:5px; margin-bottom:5px; " id="AggiungiRecordcma" onclick="MostraModalAggiungiRecordcma();">Inserimento Materia di insegnamento</button>
        </div>
    </div>
    <div id="listaiscrizioni" >
        <div class="row center mt5 mb5" style="font-size: 16px;">	
            CLASSI E MATERIE DI INSEGNAMENTO<br>PER ANNO SCOLASTICO
        </div>
        <div class="row">
            <div class="col-md-1 col-sm-0 col-xs-0 col-0">
            </div>
            <div class="col-md-10 col-sm-12 col-xs-12 col-12 no-gutter">
                <div class="col-md-1 col-sm-1 col-xs-1">
                </div>
                <div class="col-md-2 col-sm-3 col-xs-3">
                    <input class="tablelabel3" type="text"  value = "Anno Scolastico" readonly>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-3" style="">
                    <input class="tablelabel3" type="text"  value = "Materia" readonly>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2" style="">
                    <input class="tablelabel3" type="text"  value = "Classe" readonly>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <input class="tablelabel3" type="text"  value = "Sezione" readonly>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <input class="tablelabel3" type="text"  value = "Tutor" readonly>
                </div>
            </div>
        </div>
        <?
        //************************************************************************** Estraggo lista classi ************************************************
        $sql3 = "SELECT ID_cma, annoscolastico_cma, ruolo_cma, tutor_cma, tutordi_cma, codmat_cma, descmateria_mtt, classe_cma, sezione_cma, nome_mae, cognome_mae  FROM ((tab_classimaestri LEFT JOIN tab_materie ON codmat_cma = codmat_mtt) LEFT JOIN tab_classi ON classe_cma = classe_cls) LEFT JOIN tab_anagraficamaestri ON tutor_cma = ID_mae WHERE ID_mae_cma = ? ORDER BY annoscolastico_cma DESC, ord_cls ASC, descmateria_mtt ASC;";
        // $sql3 = "SELECT ID_cma, annoscolastico_cma, ruolo_cma, tutordi_cma, codmat_cma, descmateria_mtt, classe_cma, sezione_cma, nome_mae, cognome_mae  FROM ((tab_classimaestri LEFT JOIN tab_materie ON codmat_cma = codmat_mtt) LEFT JOIN tab_classi ON classe_cma = classe_cls) LEFT JOIN tab_anagraficamaestri ON ID_mae_cma = ID_mae WHERE tutordi_cma = ? ORDER BY annoscolastico_cma DESC, ord_cls ASC, descmateria_mtt ASC;";
        $stmt3 = mysqli_prepare($mysqli, $sql3);
        mysqli_stmt_bind_param($stmt3, "i", $ID_mae);
        mysqli_stmt_execute($stmt3);
        // 210207 mysqli_stmt_bind_result($stmt3, $ID_cma, $annoscolastico_cma, $ruolo_cma, $tutor_cma, $codmat_cma, $descmateria_mat, $classe_cma, $sezione_cma, $nometutor_mae, $cognometutor_mae);
        mysqli_stmt_bind_result($stmt3, $ID_cma, $annoscolastico_cma, $ruolo_cma, $tutor_cma, $tutordi_cma, $codmat_cma, $descmateria_mat, $classe_cma, $sezione_cma, $nometutor_mae, $cognometutor_mae);
        $k=0;
        while (mysqli_stmt_fetch($stmt3)) {
            $k++;?>	
            <div class="row">
                <div class="col-md-1 col-sm-0 col-xs-0 col-0" >
                </div>
                <div class="col-md-10 col-sm-12 col-xs-12 col-12 no-gutter">
                    <div class="col-md-1 col-sm-1 col-xs-1" style="text-align: right; padding-right: 10px; ">
                        <img title="Elimina questo record" class="iconaStd" src='assets/img/Icone/times-circle-solid.svg' onclick="showModalDeleteThisRecord(<?=$ID_cma?>);">
                    </div>
                    <div class="col-md-2 col-sm-3 col-xs-3">
                        <input class="tablecell5" type="text"  id="annoscolastico_cma<?=$ID_cma?>" value = "<?=$annoscolastico_cma?>" readonly>
                    </div>
                    <div class="col-md-2 col-sm-3 col-xs-3" style="">
                        <input class="tablecell5" type="text"  id="descmateria_mat<?=$ID_cma?>" value = "<?=$descmateria_mat?><?if ($tutordi_cma !=0) {echo(' ->tutor');}?>" readonly>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2" style="">
                        <input class="tablecell5" type="text"  id="classe_cma<?=$ID_cma?>" value = "<?=$classe_cma?>" readonly>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2" style="">
                        <input class="tablecell5" type="text"  id="sezione_cma<?=$ID_cma?>" value = "<?=$sezione_cma?>" readonly>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2" style="">
                        <input class="tablecell5" type="text"  id="nomecognometutor_mae<?=$ID_cma?>" value = "<?=$nometutor_mae." ".$cognometutor_mae?>" readonly>
                    </div>
                </div>
            </div>
        <?}?>
    </div>
</div>