<div class="tab-pane" id="Formazione">
    <div class="row" style="font-size:16px; text-align: center; margin-top: 30px; ">
        <div class="col-md-4 col-sm-3 col-xs-0 itemSchedaAnagrafica">
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 itemSchedaAnagrafica">
            <button class="btnBlu" style=" width: 90%; margin-top:5px; margin-bottom:5px; " id="AggiungiFormazione" onclick="MostraModalAggiungiFormazione();">Inserisci Nuova Formazione</button>
        </div>
    </div>
    <div id="listaiscrizioni" >
        <div class="row" style="text-align: center; margin-top: 5px; margin-bottom: 5px; font-size: 16px;">	
            - CORSI DI FORMAZIONE -
        </div>
        <div class="row">
            <div class="col-md-1 col-sm-0 col-xs-0 col-0">
            </div>
            <div class="col-md-10 col-sm-12 col-xs-12 col-12 no-gutter">
                <div class="col-md-1 col-sm-1 col-xs-1">
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <input class="tablelabel3" type="text"  value = "Categoria">
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <input class="tablelabel3" type="text"  value = "Titolo">
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3" style="">
                    <input class="tablelabel3" type="text"  value = "Descrizione">
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1" style="">
                    <input class="tablelabel3" type="text"  value = "Data Attestato">
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1">
                    <input class="tablelabel3" type="text"  value = "Data Scadenza">
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1" style="">
                    <input style="width: 70%;" class="tablelabel3" type="text"  value = "FOR/AGG">
                </div>
            </div>
        </div>
        <?
        //************************************************************************** Estraggo lista classi ************************************************
        $sql3 = "SELECT ".
        " ID_tit, cat_tit, nome_tit, desc_tit, data_tit, scad_tit, showscad_tit, ckformagg_tit ".//campi di tab_classimaestri
        "FROM tab_titolimaestri WHERE ID_mae_tit = ?;";
        $stmt3 = mysqli_prepare($mysqli, $sql3);
        mysqli_stmt_bind_param($stmt3, "i", $ID_mae);
        mysqli_stmt_execute($stmt3);
        mysqli_stmt_bind_result($stmt3, $ID_tit, $cat_tit, $nome_tit, $desc_tit, $data_tit, $scad_tit, $showscad_tit, $ckformagg_tit);
        $k=0;
        while (mysqli_stmt_fetch($stmt3)) {
            $k++;?>	
            <div class="row">
                <div class="col-md-1 col-sm-0 col-xs-0 col-0" >
                </div>
                <div class="col-md-10 col-sm-12 col-xs-12 col-12 no-gutter">
                    <div class="col-md-1 col-sm-1 col-xs-1" style="text-align: right; ">
                        <img title="Elimina questo record" class="iconaStd" src='assets/img/Icone/times-circle-solid.svg' onclick="showModalDeleteThisFormazione(<?=$ID_tit?>);">
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <input class="tablecell5" type="text"  id="cat_tit<?=$ID_tit?>" name="cat_tit" value = "<?=$cat_tit?>" readonly="readonly">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <input class="tablecell5" type="text"  id="nome_tit<?=$ID_tit?>" name="nome_tit" value = "<?=$nome_tit?>">
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-3" style="">
                        <input class="tablecell5" type="text"  id="desc_tit<?=$ID_tit?>" name="desc_tit" value = "<?=$desc_tit?>">
                    </div>

                    <div class="col-md-1 col-sm-1 col-xs-1" style="">
                        <input class="tablecell5 dpd" type="text"  id="data_tit<?=$ID_tit?>" name="data_tit" value = "<? if (!($data_tit == '1970-01-01')) {echo(timestamp_to_ggmmaaaa($data_tit));}?>">
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1" style="display: inline;">
                        <input class="tablecell5 dpd" type="text"  id="scad_tit<?=$ID_tit?>" name="scad_tit" value = "<?if (!($scad_tit == '1970-01-01') &&($showscad_tit != 1)) {echo(timestamp_to_ggmmaaaa($scad_tit));}?>">
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1" style="">
                        <input style="width: 70%;" class="tablecell5 ckformagg" type="text"  id="formagg_tit<?=$ID_tit?>"  maxlength ="1" name="formagg_tit" value = "<?=$ckformagg_tit?>">

                        <img title="Salva le modifiche" class="iconaStd" src='assets/img/Icone/save-regular-blue.svg' onclick="salvaFormazione(<?=$ID_tit?>);">
                    </div>
                </div>
            </div>
        <?}?>
    </div>
</div>