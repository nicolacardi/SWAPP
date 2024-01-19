<!-- ********************************************** TAB DATI PADRE **********************************************-->
<div class="tab-pane active" id="DatiPadre">
    <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1 mt10" >

         <div class="col-md-4 col-sm-4 itemSchedaAnagrafica">
        </div>

        <div class="col-md-2 col-sm-2 itemSchedaAnagrafica">
            <div class="row">
                Nome
            </div>
            <div class="row">
                <input class="tablecell5" type="text"  id="nomepadre_fam_det" name="nomepadre_fam_det" value="<?=$nomepadre_fam_det?>" >
            </div>
        </div>
        <div class="col-md-2 col-sm-2 itemSchedaAnagrafica">
            <div class="row">
                Cognome
            </div>
            <div class="row">
                <input class="tablecell5" type="text"  id="cognomepadre_fam_det" name="cognomepadre_fam_det" value="<?=$cognomepadre_fam_det?>" >
            </div>

        </div>
        <div class="col-md-1 col-sm-1 itemSchedaAnagrafica">
            <div class="row">
            (in libro soci))
            </div>
            <div class="row">
                <input style="width:20%;" class="tablecell" type="checkbox"  id="sociopadre_det" name="sociopadre_det" value="socio" <? if ($sociopadre_fam_det == 1) { echo ('checked');} ?> onclick="showModalAffiliazionePadreMadre(<?=$ID_fam_alu?>, 'padre', '<?=$nomepadre_fam_det?>', '<?=$cognomepadre_fam_det?>')">
            </div>
        </div>
        <div class="col-md-2 col-sm-2 itemSchedaAnagrafica">
            <div class="row">
                Ruolo
            </div>
            <select name="ruolopadre_fam"  style="margin-left: 0px"  id="ruolopadre_fam" onchange="ruolopadrechange()">
                <option value="padre" <?if ($ruolopadre_fam =='padre'){echo ('selected');}?>>padre</option>
                <?if($ruolomadre_fam != "deceduto") {?>
                    <option value="deceduto" <?if ($ruolopadre_fam =='deceduto'){echo ('selected');}?>>genitore deceduto</option>
                <?}?>
                <option value="tutore" <?if ($ruolopadre_fam =='tutore'){echo ('selected');}?>>tutore</option>
                <option value="affidatario" <?if ($ruolopadre_fam =='affidatario'){echo ('selected');}?>>affidatario</option>
                <option value="nondisp" <?if ($ruolopadre_fam =='nondisp'){echo ('selected');}?>>non disponibile</option>
            </select>
        </div>    
    </div>
    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
            <div class="RiquadroInfoShort">
                <h4>Foto & Note</h4>
                <div style="text-align: center; margin-top: 19px; ">
                    <button type="Button" class="btnBlu hideonlessthan1280 mb5" data-toggle="modal" id="launchModalCrop" onclick="openCroppie('padri');">Cerca Foto</button>
                </div>
                <div class="parent" style="text-align: center; ">
                    <!--<img id="imgSfondo" width="100" height="100" alt="" src="assets/photos/imgs/unknown.png" data-src="assets/photos/imgs/unknown.png" data-src-retina="assets/photos/imgs/unknown.png">-->
                    <img id="imgContainerxpadri" class="imgContainerx" width="100" height="100" alt="" src="assets/photos/imgspadri/<? if ($imgpadre_fam != "") { echo (str_replace(' ', '', $imgpadre_fam).'?'.rand(100000,999999));} else {echo('unknown.png?'.rand(100000,999999));}?>" >
                    <!--
                        data-src="assets/photos/imgspadri/<?//if ($imgpadre_fam != "") { echo (str_replace(' ', '', $imgpadre_fam).'?'.rand(100000,999999));} else {echo('unknown.png?'.rand(100000,999999));}?>" data-src-retina="assets/photos/imgspadri/<?//=$imgpadre_fam.'?'.rand(100000,999999);?>"
                    -->
                </div>
                <!--imgName è una input dove viene scritto il nome del file caricato-->
                <input class="form-control imgName" id="imgNamepadri" name="imgNamepadri" maxlength="30" placeholder="immagine" value="<?=str_replace(' ', '', $imgpadre_fam)?>">
                <br>
                <div class="row mt5">
                    Note
                </div>
                <div  class="row mt5">
                    <textarea class="tablecell7 noteAlunno" type="text"  id="notepadre_det" name="notepadre_det"><?=$notepadre_fam?></textarea>
                </div>
                <input style="width:10%;" class="tablecell" type="checkbox"  id="rapprpadre_fam" name="rapprpadre_fam" value="RappresentantePadre" <? if ($rapprpadre_fam == 1) { echo ('checked');} ?>> Rappresentante di classe
            </div>
        </div>
        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
            <div class="RiquadroInfoShort">
                <h4>Nato</h4>
                <div class="row mt30">
                    il
                </div>
                <div  class="row mt5">
                    <input style="text-align: center; width: 50%" class="tablecell7 dpd" type="text"  id="datanascitapadre_fam_det" name="datanascitapadre_fam_det" value = "<? echo(timestamp_to_ggmmaaaa($datanascitapadre_fam_det)) ?>">
                </div>
                <div  class="row mt5">
                    Comune
                </div>
                <div  class="row mt5">
                    <input class="tablecell7 search-comune" type="text"  id="comunenascitapadre_fam_det" name="comunenascitapadre_fam_det" value = "<?=$comunenascitapadre_fam_det?>">
                </div>
                    <div class="col-md-12 DropDownContainer">
                        <div class="showcomune" name="showComuneNascitaPadre_det" id="showComuneNascitaPadre_det"  ></div>
                    </div>
                <div  class="row mt5">
                    Provincia
                </div>
                <div  class="row mt5">
                    <input style="width: 20%" class="tablecell7" type="text"  id="provnascitapadre_fam_det" name="provnascitapadre_fam_det" value = "<?=$provnascitapadre_fam_det?>">
                </div>
                <div  class="row mt5">
                    Paese
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="paesenascitapadre_fam_det" name="paesenascitapadre_fam_det" value = "<?=$paesenascitapadre_fam_det?>">
                </div>
                <div  class="row mt5">
                    <button class="btnBlu20" style=" width: 40%;" onclick="trovaCF('padre', event);">C.F.</button>
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="cfpadre_fam_det" name="cfpadre_fam_det" value = "<?=$cfpadre_fam_det?>">
                </div>
            </div>
        </div>
        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
            <div class="RiquadroInfoShort"> 
                <h4 class="mb5" >Residenza</h4>
                <button class="btnBlu20" style=" width: 45%; margin-bottom: 0px; margin-top: 0px;" onclick="CopiaResidenza('alu','padre');">= figlio</button>
                <button class="btnBlu20" style=" width: 45%; margin-bottom: 0px; margin-top: 0px;" onclick="CopiaResidenza('madre','padre');">= madre</button>
                <div class="row" style=" margin-top: 3px;">
                    Via
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="indirizzopadre_fam_det" name="indirizzopadre_fam_det" value = "<?=$indirizzopadre_fam_det?>">
                </div>
                <div  class="row mt5">
                    Comune
                </div>
                <div  class="row mt5">
                    <input class="tablecell7 search-comune" type="text"  id="comunepadre_fam_det" name="comunepadre_fam_det" value = "<?=$comunepadre_fam_det?>">
                </div>
                        <div class="col-md-12 DropDownContainer">
                            <div class="showcomune" name="showComuneResidenzaPadre_det" id="showComuneResidenzaPadre_det" ></div>
                        </div>
                <div  class="row mt5">
                    Provincia
                </div>
                <div  class="row mt5">
                    <input style="width: 20%" class="tablecell7" type="text"  id="provpadre_fam_det" name="provpadre_fam_det" value = "<?=$provpadre_fam_det?>">
                </div>
                <div  class="row mt5">
                    Paese
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="paesepadre_fam_det" name="paesepadre_fam_det" value = "<?=$paesepadre_fam_det?>">
                </div>
                <div  class="row mt5">
                    CAP
                </div>
                <div  class="row mt5">
                    <input style="width: 50%; text-align: center;" class="tablecell7" type="text"  id="CAPpadre_fam_det" name="CAPpadre_fam_det" value = "<?=$CAPpadre_fam_det?>">
                </div>
            </div>
        </div>
        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
            <div class="RiquadroInfoShort"> 	
                <h4>ALTRI DATI</h4>		
                <div class="row mt30">
                    <div class="col-xs-6" >
                        Telefono
                    </div>
                    <div  class="col-xs-6">
                        Altro telefono
                    </div>
                </div>
                <div class="row mt5">
                    <div class="col-xs-6" >
                        <input class="tablecell7" type="text"  id="telefonopadre_fam_det" name="telefonopadre_fam_det" value = "<?=$telefonopadre_fam_det?>">
                    </div>
                    <div  class="col-xs-6">
                        <input class="tablecell7" type="text"  id="altrotelpadre_fam_det" name="altrotelpadre_fam_det" value = "<?=$altrotelpadre_fam_det?>">
                    </div>
                </div>
                <div  class="row mt5">
                    e-mail
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="emailpadre_fam_det" name="emailpadre_fam_det" value = "<?=$emailpadre_fam_det?>">
                </div>
                <div  class="row mt5">
                    titolo
                </div>
                <div  class="row mt5">
                    <div class="row">
                        <select name="titolopadre_fam_det"  style="margin-left: 0px"  id="titolopadre_fam_det">
                            <option value="">-selez.titolo-</option>
                            <option value="nessuno" <?if ($titolopadre_fam_det =='nessuno'){echo ('selected');}?>>nessuno</option>
                            <option value="lic.elementare" <?if ($titolopadre_fam_det =='lic.elementare'){echo ('selected');}?>>lic.elementare</option>
                            <option value="lic.media" <?if ($titolopadre_fam_det =='lic.media'){echo ('selected');}?>>lic.media</option>
                            <option value="diploma" <?if ($titolopadre_fam_det =='diploma'){echo ('selected');}?>>diploma</option>
                            <option value="laurea" <?if ($titolopadre_fam_det =='laurea'){echo ('selected');}?>>laurea</option>
                            <option value="altro" <?if ($titolopadre_fam_det =='altro'){echo ('selected');}?>>altro</option>
                        </select>
                    </div>
                </div>
                <div  class="row mt5">
                    professione
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="profpadre_fam_det" name="profpadre_fam_det" value = "<?=$profpadre_fam_det?>">
                </div>
                <div  class="row mt5">
                    IBAN
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="ibanpadre_fam" name="ibanpadre_fam" value = "<?=$ibanpadre_fam?>">
                </div>
            </div>
        </div>
        <div class="col-md-12" style="text-align: center; font-size: 14px; ">
            <div class="row" style="font-size:16px; margin-top:5px; text-align: center;">
                <div class="col-sm-12">
                    <button class="btnBlu hideonlessthan1280 mb5" onclick="aggiornaAnagrafica('DatiPadre');">Salva Modifiche Anagrafica</button>
                </div>
            </div>
        </div>
    </div>
</div>