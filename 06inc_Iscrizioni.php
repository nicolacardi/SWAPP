<!-- ********************************************** TAB ISCRIZIONI **********************************************-->
    <div class="tab-pane" id="Classi">
        <div class="row" style="font-size:16px; text-align: center; margin-top: 30px; ">
            <div class="col-md-4 col-sm-3 col-xs-0 itemSchedaAnagrafica">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 itemSchedaAnagrafica">
                <button class="btnBlu" style="width: 90%; margin-top:5px; margin-bottom:5px; " onclick="MostraModalIscrizione('normale');">Iscrizione a anno scolastico*</button>
                <br><span style="font-size: 10px;">*se l'alunno non frequenta già la scuola utilizzare la funzione di primo inserimento</span>
            </div>
            <!--<div class="col-md-2 col-sm-3 col-xs-6 itemSchedaAnagrafica">
                <button class="btnBlu mt5 mb5" style="width: 90%;" onclick="MostraModalIscrizione('listaattesa');">Iscrizione a <br>lista Attesa</button>
            </div>-->
        </div>
        <div id="listaiscrizioni" >
            <div class="row mb5 mt5" style="text-align: center; font-size: 16px;">	
                - ISCRIZIONI PER ANNO SCOLASTICO -
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-0 col-xs-0 col-0">
                </div>
                <div class="col-md-10 col-sm-12 col-xs-12 col-12 no-gutter">
                    <div class="col-md-2 col-sm-1 col-xs-1">
                    </div>
                    <div class="col-md-2 col-sm-3 col-xs-3">
                        <input class="tablelabel3" type="text"  value = "Anno Scolastico">
                    </div>
                    <div class="col-md-2 col-sm-3 col-xs-3">
                        <input class="tablelabel3" type="text" value = "Classe">
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1">
                        <input class="tablelabel3" type="text" value = "Sez.">
                    </div>

                    <?if ($_SESSION['scalino'] == 1) {?>
                        <div class="col-md-1 col-sm-1 col-xs-1">
                            <input class="tablelabel3" type="text" value = "Scalino">
                        </div>
                    <?}?>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <!--<input class="tablelabel3" type="text"  id="sezione_cla" name="sezione_cla" value = "data ritiro">-->
                    </div>
                </div>
            </div>
            <?//************************************************************************** Estraggo lista iscrizioni ************************************************
            $sql3 = "SELECT ID_cla, classe_cla, sezione_cla, annoscolastico_cla, listaattesa_cla, scalino_cla, ritirato_cla, dataritiro_cla FROM tab_classialunni WHERE ID_alu_cla = ? ORDER BY annoscolastico_cla DESC";
            $stmt3 = mysqli_prepare($mysqli, $sql3);
            mysqli_stmt_bind_param($stmt3, "i", $ID_alu_det);
            mysqli_stmt_execute($stmt3);
            mysqli_stmt_bind_result($stmt3, $ID_cla, $classe_cla, $sezione_cla, $annoscolastico_cla, $listaattesa_cla, $scalino_cla, $ritirato_cla, $dataritiro_cla);
            $k=0;
            while (mysqli_stmt_fetch($stmt3)) {
            $k++;?>	
            <div class="row">
                <div class="col-md-2 col-sm-0 col-xs-0 col-0" >
                </div>
                <div class="col-md-10 col-sm-12 col-xs-12 col-12 no-gutter">
                    <div class="col-md-2 col-sm-1 col-xs-1" style="text-align: right; padding-right: 10px; ">
                        <?if ($listaattesa_cla == 1) {?>
                            <img title="Alunno in lista d'attesa" style="width: 23px; margin-top: -3px; cursor: pointer" src='assets/img/Icone/hand-paper-solid.svg' onclick="mostraPrimoInserimento();">
                        <?}?>
                    <img title="Elimina questa iscrizione o lista d'attesa" class="iconaStd" src='assets/img/Icone/times-circle-solid.svg' onclick="showModalDeleteIscrizione('<?=$annoscolastico_cla?>');">
                    </div>
                    <div class="col-md-2 col-sm-3 col-xs-3">
                        <input class="tablecell5" type="text"  value = "<?=$annoscolastico_cla?>">
                    </div>
                    <div class="col-md-2 col-sm-3 col-xs-3" style="">
                        <input class="tablecell5" type="text"  value = "<?=$classe_cla?>">
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1" style="position:relative">
                        <input class="tablecell5" type="text"  value = "<?=$sezione_cla?>">
                        <img title="Cambio Sezione" class="cambio-sez" src="assets/img/Icone/sync-alt-solid.svg" onclick="showModalCambioSezione('<?=$sezione_cla?>', <?=$ID_cla?>, '<?=$annoscolastico_cla?>');">
                    </div>

                    <?if ($_SESSION['scalino'] == 1) {?>
                        <div class="col-md-1 col-sm-1 col-xs-1">
                            <input class="tablelabel3" type="checkbox" id="ckScalino<?=$ID_cla?>" <?if ($scalino_cla==1) { echo ('checked');}?> onclick="checkScalino(<?=$ID_cla?>)">
                        </div>
                    <?}?>
                    
                    <div class="col-md-2 col-sm-2 col-xs-2" style="">
                        <?if ($listaattesa_cla != 1) {?>
                        <img title="Uscita in corso d'anno" style="width: 23px; margin-top: -8px; cursor: pointer" src='assets/img/Icone/sign-out-alt-solid.svg' onclick="MostraModalUscita('<?=$annoscolastico_cla?>');">
                        <?}?>
                        <?if ($ritirato_cla == 1) {?>
                        <input style="width: 70%;background-color: red; color: white; text-align: center; font-size: 9px;" class="tablecell5" type="text"  id="dataritiro_cla" name="dataritiro_cla" value = "<?=$dataritiro_cla?>" disabled>
                        <?}?>
                    </div>
                    
                </div>
            </div>
            <?}?>
        </div>
    </div>