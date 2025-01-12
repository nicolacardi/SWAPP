<!-- TAB DATI ANAGRAFICI ************************************************************************************-->
    <div class="tab-pane active" id="DatiAnagrafici">

<!-- NOME COGNOME e M/F PARTE SUPERIORE *********************************************************************-->
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1 mt10">

            <div class="col-sm-3 col-sm-offset-3 col-md-3 col-md-offset-3 itemSchedaAnagrafica">
                <div class="row">
                    Nome
                </div>
                <div class="row">
                    <input class="tablecell5" type="text"  id="nome_alu_det" name="nome_alu_det" value="<?=$nome_alu_det?>" >
                </div>
            </div>
            <div class="col-sm-3 col-md-3 itemSchedaAnagrafica">
                <div class="row">
                    Cognome
                </div>
                <div class="row">
                    <input class="tablecell5" type="text"  id="cognome_alu_det" name="cognome_alu_det" value="<?=$cognome_alu_det?>" >
                </div>
            </div>
            <div class="col-xs-2 col-xs-offset-5 col-sm-1 col-sm-offset-0 col-md-1 col-md-offset-0 itemSchedaAnagrafica">
                <div class="row">
                    M/F
                </div>
                <div class="row">
                    <input class="tablecell5" type="text"  id="mf_alu_det" name="mf_alu_det" maxlength="1" value="<?=$mf_alu_det?>" >
                </div>
            </div>
            <div class="col-xs-2 col-xs-offset-5 col-sm-1 col-sm-offset-0 col-md-1 col-md-offset-0 itemSchedaAnagrafica hideonlessthan1280">
                <div class="row">
                    <div style="margin-top: 13px;">
                        <button class="btnBlu hideonlessthan1280" type="Button" style="height: 40px; font-size: 11px;" onclick="MostraModalFratelli();">Fratelli: <?echo($fratelli."<br>");?> Mod. famiglia</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">	
<!-- RIQUADRO 1 FOTO e NOTE *********************************************************************************-->
            <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
                <div class="RiquadroInfoLong">
                    <h4>Foto & Note</h4>
                    <div style="text-align: center; margin-top: 19px; ">
                        <button type="Button" class="btnBlu hideonlessthan1280 mb5" data-toggle="modal" id="launchModalCrop" onclick="openCroppie('');" >Cerca Foto</button>
                        <!--data-target="#modalFormCroppie"-->
                    </div>
                    <div class="parent" style="text-align: center; ">
                        <!--<img id="imgSfondo" width="100" height="100" alt="" src="assets/photos/imgs/unknown.png" data-src="assets/photos/imgs/unknown.png" data-src-retina="iassets/photos/mgs/unknown.png">-->

                        <img id="imgContainerx" class="imgContainerx" width="100" height="100" alt="" 
                        src="assets/photos/imgs/<? if ($img_alu != "") { echo (str_replace(' ', '', $img_alu).'?'.rand(100000,999999));} else {echo('unknown.png?'.rand(100000,999999));}?>" 
                        >

                        <!--
                            data-src="assets/photos/imgs/<?//if ($img_alu != "") { echo (str_replace(' ', '', $img_alu).'?'.rand(100000,999999));} else {echo('unknown.png?'.rand(100000,999999));}?>" 
                        data-src-retina="assets/photos/imgs/<?//=$img_alu.'?'.rand(100000,999999);?>"
                        -->
                    </div>
                    <!--imgName è una input dove viene scritto il nome del file caricato-->
                    <!--questo campo va aggiornato in fase di primo caricamento perchè è da qui che viene pescato il valore da salvare poi in fase di salvataggio anagrafica-->
                    <input  class="form-control imgName" id="imgName" name="imgName" maxlength="30" placeholder="immagine" value="<?=str_replace(' ', '', $img_alu)?>">

                    <div  class="row mt5">
                        Note
                    </div>
                    <div  class="row mt5">
                        <textarea class="tablecell7 noteAlunno " type="text"  id="note_alu_det" name="note_alu_det"><?=$note_alu?></textarea>
                    </div>
                    


                    <div class="row" style="margin-top: 1px;">
                        Scuola di Provenienza
                    </div>
                    <div  class="row mt5">
                        <input class="tablecell7" type="text"  id="scuolaprovenienza_alu_det"  maxlength="50" name="scuolaprovenienza_alu_det" value = "<?=$scuolaprovenienza_alu_det?>">
                    </div>
                    <div  class="row mt5">
                        Indirizzo sc. Provenienza
                    </div>
                    <div  class="row mt5">
                        <input class="tablecell7" type="text"  id="indirizzoscproven_alu_det"  maxlength="50" name="indirizzoscproven_alu_det" value = "<?=$indirizzoscproven_alu_det?>">
                    </div>

                    <button class="btnBlu20" style=" width: 45%; margin-bottom: 0px; margin-top: 0px;" onclick="setName();">= <?=$shortnameScuola?></button>


                </div>
            </div>
<!-- RIQUADRO 2 NATO ****************************************************************************************-->
            <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
                <div class="RiquadroInfoLong">
                    <h4>Nato/a</h4>
                    <div class="row mt30">
                        il
                    </div>
                    <div  class="row mt5">
                        <input style="text-align: center; width: 50%" class="tablecell3 dpd" type="text"  id="datanascita_alu_det"  maxlength="10" name="datanascita_alu_det" value = "<? echo(timestamp_to_ggmmaaaa($datanascita_alu_det)) ?>">
                    </div>
                    <div  class="row mt5">
                        Comune
                    </div>
                    <div  class="row mt5">
                        <input class="tablecell7 search-comune" type="text"  id="comunenascita_alu_det"  maxlength="50" name="comunenascita_alu_det" value = "<?=$comunenascita_alu_det?>">
                    </div>
                        <div class="col-md-12 DropDownContainer">
                            <div class="showcomune" name="showComuneNascita_det" id="showComuneNascita_det" ></div>
                        </div>
                    <div  class="row mt5">
                        Provincia
                    </div>
                    <div  class="row mt5">
                        <input style="width: 20%" class="tablecell7" type="text"  id="provnascita_alu_det"  maxlength="4" name="provnascita_alu_det" value = "<?=$provnascita_alu_det?>">
                    </div>
                    <div  class="row mt5">
                        Paese
                    </div>
                    <div  class="row mt5">
                        <input class="tablecell7" type="text"  id="paesenascita_alu_det"  maxlength="50" name="paesenascita_alu_det" value = "<?=$paesenascita_alu_det?>">
                    </div>
                    <div  class="row mt5">
                        Cittadinanza
                    </div>
                    <div  class="row mt5">
                        <input class="tablecell7" type="text"  id="cittadinanza_alu_det"  maxlength="50" name="cittadinanza_alu_det" value = "<?=$cittadinanza_alu_det?>">
                    </div>
                    <div class="row" style="margin-top: 3px;">
                        <button class="btnBlu20" style=" width: 40%;" onclick="trovaCF('alunno', event);">C.F.</button>
                    </div>
                    <div  class="row mt5">
                        <input class="tablecell7" type="text"  id="cf_alu_det"  maxlength="16" name="cf_alu_det" value = "<?=$cf_alu_det?>">
                    </div>
                </div>
            </div>
<!-- RIQUADRO 3 RESIDENZA ***********************************************************************************-->
            <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
                <div class="RiquadroInfoLong">
                    <h4 class="mb5" >Residenza</h4>
                    <button class="btnBlu20" style=" width: 45%; margin-bottom: 0px; margin-top: 0px;" onclick="CopiaResidenza('madre','alu');">= madre</button>
                    <button class="btnBlu20" style=" width: 45%; margin-bottom: 0px; margin-top: 0px;" onclick="CopiaResidenza('padre','alu');">= padre</button>
                    <div class="row" style=" margin-top: 3px;">
                        Via
                    </div>
                    <div  class="row mt5">
                        <input class="tablecell7" type="text"  id="indirizzo_alu_det"  maxlength="50" name="indirizzo_alu_det" value = "<?=$indirizzo_alu_det?>">
                    </div>
                    <div  class="row mt5">
                        Comune
                    </div>
                    <div  class="row mt5">
                        <input class="tablecell7 search-comune" type="text"  id="citta_alu_det"  maxlength="50" name="citta_alu_det" value = "<?=$citta_alu_det?>">
                    </div>
                            <div class="col-md-12 DropDownContainer">
                                <div class="showcomune" name="showComuneResidenza_det" id="showComuneResidenza_det" ></div>
                            </div>
                    <div  class="row mt5">
                        Provincia
                    </div>
                    <div  class="row mt5">
                        <input style="width: 20%" class="tablecell7" type="text"  id="prov_alu_det"  maxlength="4" name="prov_alu_det" value = "<?=$prov_alu_det?>">
                    </div>
                    <div  class="row mt5">
                        Paese
                    </div>
                    <div  class="row mt5">
                        <input class="tablecell7" type="text"  id="paese_alu_det"  maxlength="50" name="paese_alu_det" value = "<?=$paese_alu_det?>">
                    </div>
                    <div  class="row mt5">
                        CAP
                    </div>
                    <div  class="row mt5">
                        <input style="width: 50%; text-align: center;" class="tablecell7" type="text"  id="CAP_alu_det"  maxlength="5" name="CAP_alu_det" value = "<?=$CAP_alu_det?>">
                    </div>
                </div>
            </div>
<!-- RIQUADRO 4 ALTRI DATI **********************************************************************************-->
            <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
                <div class="RiquadroInfoLong">	
                    <h4 class="mb5" >ALTRI DATI</h4>		
                    
                    <!-- <div class="row" style="margin-top: 5px; ">
                        Scuola di 1^ Provenienza
                    </div>
                    <div  class="row mt5">
                        <input class="tablecell7" type="text"  id="scuolaprimaprovenienza_alu_det"  maxlength="50" name="scuolaprimaprovenienza_alu_det" value = "<?//=$scuolaprimaprovenienza_alu_det?>">
                    </div>
                    <div  class="row mt5">
                        Indirizzo sc. 1^ Provenienza
                    </div>
                    <div  class="row mt5">
                        <input class="tablecell7" type="text"  id="indirizzoscprimaproven_alu_det"  maxlength="50" name="indirizzoscprimaproven_alu_det" value = "<?//=$indirizzoscprimaproven_alu_det?>">
                    </div> -->
                    <div style="text-align: left; margin-left: 40px; ">
                        <div class="row mt5">
                            <input style="width:10%;" class="tablecell" type="checkbox"  id="ckautfoto_alu_det" name="ckautfoto_alu_det" value="AutorizzazioneFoto" <? if ($ckautfoto_alu_det == 1) { echo ('checked');} ?>> Aut. Foto-Video 
                        </div>
                        <div class="row mt5">
                            <input style="width:10%;" class="tablecell" type="checkbox"  id="ckautmateriale_alu_det" name="ckautmateriale_alu_det" value="AutorizzazioneMateriale" <? if ($ckautmateriale_alu_det == 1) { echo ('checked');} ?>> Aut. uso Materiale 
                        </div>
                        <div class="row mt5">
                            <input style="width:10%;" class="tablecell" type="checkbox"  id="ckautuscite_alu_det" name="ckautuscite_alu_det" value="AutorizzazioneUscite" <? if ($ckautuscite_alu_det == 1) { echo ('checked');} ?>> Aut. Uscite 
                        </div>
                        <div class="row mt5">
                            <input style="width:10%;" class="tablecell" type="checkbox"  id="ckautuscitaautonoma_alu_det" name="ckautuscitaautonoma_alu_det" value="AutorizzazioneUscitaAutonoma" <? if ($ckautuscitaautonoma_alu_det == 1) { echo ('checked');} ?>> Aut. Uscita Autonoma 
                        </div>

                        <? if ($_SESSION['ISC_mostra_trasportopubblico'] == 1) {?>
                            <div class="row mt5">
                                <input style="width:10%;" class="tablecell" type="checkbox"  id="cktrasportopubblico_alu_det" name="cktrasportopubblico_alu_det" value="RichiestaTrasportoPubblico" <? if ($cktrasportopubblico_alu_det == 1 || $cktrasportopubblico_alu_det == 2) { echo ('checked');} ?>> Rich. Trasp. Pubblico 
                            </div>
                        <?}?>
                        
                        <div class="row mt5">
                            <input style="width:10%;" class="tablecell" type="checkbox"  id="DSA_alu_det" name="DSA_alu_det" value="DSA" <? if ($DSA_alu_det == 1) { echo ('checked');} ?>> DSA 

                            <input style="width:10%;" class="tablecell" type="checkbox"  id="disabilita_alu_det" name="disabilita_alu_det" value="Disabilita" <? if ($disabilita_alu_det == 1) { echo ('checked');} ?>  > Disabilità 
                        </div>
                        <div  class="row mt5" id="titleDettaglidisabilita_alu_det">
                            Dettagli Disabilità
                        </div>
                        <div  class="row mt5">
                            <textarea class="tablecell8 noteMiniText" type="text"  id="dettaglidisabilita_alu_det" name="dettaglidisabilita_alu_det"><?=$dettaglidisabilita_alu_det?></textarea>
                        </div>
                        <? if ($_SESSION['ISC_mostra_mensa'] == 1) {?>
                            <div class="row mt5">
                                <input style="width:10%;" class="tablecell" type="checkbox"  id="ckmensa_alu_det" name="ckmensa_alu_det" value="SceltaMensa" <? if ($ckmensa_alu_det == 1) { echo ('checked');} ?>> Mensa
                            </div>
                        <?}?>
                        <? if ($_SESSION['ISC_mostra_doposcuola'] == 1) {?>
                            <div class="row mt5">
                                <input style="width:10%;" class="tablecell" type="checkbox"  id="ckdoposcuola_alu_det" name="ckdoposcuola_alu_det" value="DopoScuola" <? if ($ckdoposcuola_alu_det == 1) { echo ('checked');} ?>> Doposcuola
                            </div>
                        <?}?>
                        <? if ($_SESSION['ISC_mostra_sceltareligione'] == 1) {?>
                            <div class="row mt5">
                                <input style="width:10%;" class="tablecell" type="checkbox"  id="ckreligione_alu_det" name="ckreligione_alu_det" value="SceltaReligione" <? if ($ckreligione_alu_det == 1) { echo ('checked');} ?>> Religione
                            </div>

                            <div class="row" style="margin-top: 12px;">
                                <select id="selectaltreligione_alu"  class="w100px" style="margin-left: 0px;">

                                    <option value="1" <?if ($altreligione_alu_det ==1){echo("selected");}?>>Att. didattiche e Formative</option>	
                                    <option value="2" <?if ($altreligione_alu_det ==2){echo("selected");}?>>Att. di studio e/o ricerca individuali con assistenza docenti</option>
                                    <option value="3" <?if ($altreligione_alu_det ==3){echo("selected");}?>>Non frequenza della scuola nelle ore di insegnamento della religione cattolica</option>
                                    <option value="0" <?if ($ckreligione_alu_det == 1) {echo ('selected');}?>>-</option>
                                </select>
                                Alternativa a Religione
                            </div>
                        <?}?>

                        <div class="row" style="margin-top: 12px;">
                            <select id="selectintestazionefatt_fam"  class="w100px"  style="margin-left: 0px">
                                <option value="0" <?if ($intestazionefatt_fam == NULL) {echo ('selected');}?>>-</option>
                                <option value="madre" <?if ($intestazionefatt_fam == 'madre') {echo ('selected');}?>>madre</option>
                                <option value="padre" <?if ($intestazionefatt_fam == 'padre') {echo ('selected');}?>>padre</option>
                                <option value="altro" <?if ($intestazionefatt_fam == 'altro') {echo ('selected');}?>>altro</option>
                            </select>
                            intestazione fattura
                        </div>

                        <!-- if ($ISC_mostra_trasportopubblico ==1) -->
                            
                    
                    </div>
                </div>
            </div>
<!-- BUTTON SALVA *******************************************************************************************-->
            <div class="col-md-12" style="text-align: center; font-size: 14px; ">
                <div class="row" style="font-size:16px; margin-top:5px; text-align: center;">
                    <div class="col-sm-12">
                        <button class="btnBlu hideonlessthan1280 mb5" style=" width: 40%;" onclick="aggiornaAnagrafica('DatiAnagrafici');">Salva Modifiche Anagrafica</button>
                    </div>
                </div>
            </div>
        </div>

    </div>