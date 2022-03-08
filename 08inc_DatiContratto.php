<!-- ********************************************** TAB DATI RAPPORTO **********************************************-->
<div class="tab-pane" id="DatiRapporto">
    <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1 mt10" >
        <div class="col-sm-3 col-sm-offset-3 col-md-3 col-md-offset-3 itemSchedaAnagrafica">
            <div class="row">
                Nome
            </div>
            <div class="row">
                <input class="tablecell5" type="text"  value="<?=$nome_mae_det?>" disabled>
            </div>
        </div>
        <div class="col-sm-3 col-md-3 itemSchedaAnagrafica">
            <div class="row">
                Cognome
            </div>
            <div class="row">
                <input class="tablecell5" type="text"  value="<?=$cognome_mae_det?>" disabled>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">	
        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
            <div class="RiquadroInfoShort">
                <h4>Dati Identificativi</h4>
                <div class="row mt30">
                    Matricola
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="matricola_mae" name="matricola_mae" value = "<?=$matricola_mae?>">
                </div>
                <div  class="row mt5">
                    Matricola INPS
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="matrinps_mae" name="matrinps_mae" value = "<?=$matrinps_mae?>">
                </div>
                <div  class="row mt5">
                    Matricola INAIL
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="matrinail_mae" name="matrinail_mae" value = "<?=$matrinail_mae?>">
                </div>
                <div  class="row mt5">
                    Cert. Penale Cas. Giud.
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="certpencg_mae" name="certpencg_mae" value = "<?=$certpencg_mae?>">
                </div>
            </div>
        </div>



        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
            <div class="RiquadroInfoShort">
                <h4>Contratto</h4>
                <div class="row mt30">
                    Data inizio Contratto
                </div>
                <div  class="row mt5">
                        <input class="datepicker tablecell6 dpd w50 center" id="dataass_mae" type="text" value="<?
                        if ( $dataass_mae == "1900-01-01" || $dataass_mae == "0000-00-00") {
                            
                        } else {
                            echo (timestamp_to_ggmmaaaa($dataass_mae));
                        } ?>" />
                </div>
                <div  class="row mt5">
                    Data fine Contratto
                </div>
                <div  class="row mt5">
                    <input class="datepicker tablecell6 dpd w50 center" id="datalic_mae" type="text" value="<?
                        if ( $datalic_mae == "1900-01-01" || $datalic_mae == "0000-00-00") {
                            
                        } else {
                            echo (timestamp_to_ggmmaaaa($datalic_mae));
                        } ?>" />
                </div>
                <div  class="row mt5" >
                    <div class="col-sm-8">
                        <div  class="row">
                            Tipo Contratto
                        </div>
                        <div  class="row mt5" style="margin-left: 2px; margin-right: 2px;">
                            <select name="selectTipocontr_mae "  id="selectTipocontr_mae">
                                <option value="0" <?if ($tipocontr_mae == 0) {echo ("selected");}?>>-</option>
                                <option value="1" <?if ($tipocontr_mae == 1) {echo ("selected");}?>>Volontario</option>
                                <option value="2" <?if ($tipocontr_mae == 2) {echo ("selected");}?>>Tempo Determinato</option>
                                <option value="3" <?if ($tipocontr_mae == 3) {echo ("selected");}?>>Tempo Indeterminato</option>
                            </select>
                        </div>
                    </div>
                    <div  class="col-sm-4">
                        <div  class="row">
                            Livello
                        </div>
                        <div  class="row mt5" style="margin-left: 2px; margin-right: 2px;">
                            <select name="selectLivello_mae "  id="selectLivello_mae">
                                <option value="0" <?if ($livello_mae == 0) {echo ("selected");}?>>-</option>
                                <option value="1" <?if ($livello_mae == 1) {echo ("selected");}?>>1</option>
                                <option value="2" <?if ($livello_mae == 2) {echo ("selected");}?>>2</option>
                                <option value="3" <?if ($livello_mae == 3) {echo ("selected");}?>>3</option>
                                <option value="4" <?if ($livello_mae == 4) {echo ("selected");}?>>4</option>
                                <option value="5" <?if ($livello_mae == 5) {echo ("selected");}?>>5</option>
                                <option value="6" <?if ($livello_mae == 6) {echo ("selected");}?>>6</option>
                                <option value="7" <?if ($livello_mae == 7) {echo ("selected");}?>>7</option>
                                <option value="8" <?if ($livello_mae == 8) {echo ("selected");}?>>8</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div  class="row mt5" style="margin-left: 2px; margin-right: 2px;">
                    <div  class="col-xs-4">
                        <div  class="row">
                            u.d.
                        </div>
                        <div  class="row mt5">
                            <input class="tablecell7" type="number"  id="ud_mae" name="ud_mae" value = "<?=$ud_mae?>">
                        </div>
                    </div>
                    <div  class="col-xs-4">
                        <div  class="row">
                            Ore sett.
                        </div>
                        <div  class="row mt5">
                            <input class="tablecell7" type="number"  id="orecontr_mae" name="orecontr_mae" value = "<?=$orecontr_mae?>">
                        </div>
                    </div>
                    <div  class="col-xs-4">
                        <div  class="row">
                            % part Time
                        </div>
                        <div  class="row mt5">
                            <input class="tablecell7" type="number"  id="parttimeperc_mae" name="parttimeperc_mae" value = "<?=$parttimeperc_mae?>">
                        </div>
                    </div>
                </div>

                
            </div>
        </div>


        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">			
             <div class="RiquadroInfoShort">
                <h4>Dati Economici</h4>
                <div class="row mt30">
                    IBAN
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="iban_mae" name="iban_mae" value = "<?=$iban_mae?>">
                </div>
                <div class="row">
                    RAL euro
                </div>
                <div  class="row mt5">
                    <input class="tablecell7 w50 center"  type="text"  id="ral_mae" name="ral_mae" value = "<?=$ral_mae?>">
                </div>
            </div>
        </div>

        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">			
             <div class="RiquadroInfoShort">
                <h4>NOTE Rapporto</h4>

                <div  class="row mt5">
                    <textarea style="height: 250px;" class="tablecell7" type="text"  id="noterapporto_mae" name="noterapporto_mae"><?=$noterapporto_mae?></textarea>
                </div>
            </div>
        </div>


        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
            
        </div>
        <div class="col-md-12" style="text-align: center; font-size: 14px; ">
            <div class="row" style="font-size:16px; margin-top:5px; text-align: center;">
                <div class="col-sm-12">
                    <button class="btnBlu hideonlessthan1280" style=" width: 40%; margin-bottom: 10px;" onclick="aggiornaAnagrafica('DatiRapporto');">Salva Modifiche Anagrafica</button>
                </div>
            </div>
        </div>
    </div>
</div>