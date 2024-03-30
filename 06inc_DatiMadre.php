<!-- ********************************************** TAB DATI MADRE **********************************************-->
<div class="tab-pane active" id="DatiMadre">
    <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1 mt10" >
        <div class="col-md-4 col-sm-4 itemSchedaAnagrafica">
        </div>
        <div class="col-md-2 col-sm-2 itemSchedaAnagrafica">
            <div class="row">
                Nome
            </div>
            <div class="row">
                <input class="tablecell5" type="text"  id="nomemadre_fam_det" name="nomemadre_fam_det" value="<?=$nomemadre_fam_det?>" >
            </div>
        </div>
        <div class="col-md-2 col-sm-2 itemSchedaAnagrafica">
            <div class="row">
                Cognome
            </div>
            <div class="row">
                <input class="tablecell5" type="text"  id="cognomemadre_fam_det" name="cognomemadre_fam_det" value="<?=$cognomemadre_fam_det?>" >
            </div>

        </div>
        <div class="col-md-1 col-sm-1 itemSchedaAnagrafica">
            <div class="row">
            (in libro soci)
            </div>
            <div class="row">
                <input style="width:20%;" class="tablecell" type="checkbox"  id="sociomadre_det" name="sociomadre_det" value="socio" <? if ($sociomadre_fam_det == 1) { echo ('checked');} ?> onclick="showModalAffiliazionePadreMadre(<?=$ID_fam_alu?>, 'madre', '<?=$nomemadre_fam_det?>', '<?=$cognomemadre_fam_det?>')">
            </div>
        </div>
        <div class="col-md-2 col-sm-2 itemSchedaAnagrafica">
            <div class="row">
                Ruolo
            </div>
            <select name="ruolomadre_fam"  style="margin-left: 0px"  id="ruolomadre_fam" onchange="ruolomadrechange()">
                <option value="madre" <?if ($ruolomadre_fam =='madre'){echo ('selected');}?>>madre</option>
                <?if($ruolopadre_fam != "deceduto") {?>
                    <option value="deceduto" <?if ($ruolomadre_fam =='deceduto'){echo ('selected');}?>>genitore deceduto</option>
                <?}?>
                <option value="tutore" <?if ($ruolomadre_fam =='tutore'){echo ('selected');}?>>tutore</option>
                <option value="affidatario" <?if ($ruolomadre_fam =='affidatario'){echo ('selected');}?>>affidatario</option>
                <option value="nondisp" <?if ($ruolomadre_fam =='nondisp'){echo ('selected');}?>>non disponibile</option>

            </select>
        </div>   
    </div>

    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
            <div class="RiquadroInfoLong">
                <h4>Foto & Note</h4>
                <div style="text-align: center; margin-top: 19px; ">
                    <button type="Button" class="btnBlu hideonlessthan1280 mb5" data-toggle="modal" id="launchModalCrop" onclick="openCroppie('madri');">Cerca Foto</button>
                </div>
                <div class="parent" style="text-align: center; ">
                    <!--<img id="imgSfondo" width="100" height="100" alt="" src="assets/photos/imgs/unknown.png" data-src="assets/photos/imgs/unknown.png" data-src-retina="assets/photos/imgs/unknown.png">-->
                    <img id="imgContainerxmadri" class="imgContainerx" width="100" height="100" alt="" src="assets/photos/imgsmadri/<? if ($imgmadre_fam != "") { echo (str_replace(' ', '', $imgmadre_fam).'?'.rand(100000,999999));} else {echo('unknown.png?'.rand(100000,999999));}?>">
                    
                    <!--
                         data-src="assets/photos/imgsmadri/<?//if ($imgmadre_fam != "") { echo (str_replace(' ', '', $imgmadre_fam).'?'.rand(100000,999999));} else {echo('unknown.png?'.rand(100000,999999));}?>" data-src-retina="assets/photos/imgsmadri/<?//=$imgmadre_fam.'?'.rand(100000,999999);?>"
                    -->
                </div>
                <!--imgName è una input dove viene scritto il nome del file caricato-->
                <input class="form-control imgName" id="imgNamemadri" name="imgNamemadri" maxlength="30" placeholder="immagine" value="<?=str_replace(' ', '', $imgmadre_fam)?>">
                <br>
                <div class="row mt5">
                    Note
                </div>
                <div  class="row mt5">
                    <textarea class="tablecell7 noteAlunno" type="text"  id="notemadre_det" name="notemadre_det"><?=$notemadre_fam?></textarea>
                </div>
                <input style="width:10%;" class="tablecell" type="checkbox"  id="rapprmadre_fam" name="rapprmadre_fam" value="RappresentanteMadre" <? if ($rapprmadre_fam == 1) { echo ('checked');} ?>> Rappresentante di classe
            </div>
        </div>
        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
            <div class="RiquadroInfoLong">
                <h4>Nata</h4>
                <div class="row mt30">
                    il
                </div>
                <div  class="row mt5">
                    <input style="text-align: center; width: 50%" class="tablecell7 dpd" type="text"  id="datanascitamadre_fam_det" name="datanascitamadre_fam_det" value = "<? echo(timestamp_to_ggmmaaaa($datanascitamadre_fam_det)) ?>">
                </div>
                <div  class="row mt5">
                    Comune
                </div>
                <div  class="row mt5">
                    <input class="tablecell7 search-comune" type="text"  id="comunenascitamadre_fam_det" name="comunenascitamadre_fam_det" value = "<?=$comunenascitamadre_fam_det?>">
                </div>
                    <div class="col-md-12 DropDownContainer">
                        <div class="showcomune" name="showComuneNascitaMadre_det" id="showComuneNascitaMadre_det" ></div>
                    </div>
                <div  class="row mt5">
                    Provincia
                </div>
                <div  class="row mt5">
                    <input style="width: 20%" class="tablecell7" type="text"  id="provnascitamadre_fam_det" name="provnascitamadre_fam_det" value = "<?=$provnascitamadre_fam_det?>">
                </div>
                <div  class="row mt5">
                    Paese
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="paesenascitamadre_fam_det" name="paesenascitamadre_fam_det" value = "<?=$paesenascitamadre_fam_det?>">
                </div>
                <div  class="row mt5">
                    Cittadinanza
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="cittadinanzamadre_fam_det" name="cittadinanzamadre_fam_det" value = "<?=$cittadinanzamadre_fam_det?>">
                </div>
                <div  class="row mt5">
                    <button class="btnBlu20" style=" width: 40%;" onclick="trovaCF('madre', event);">C.F.</button>
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="cfmadre_fam_det" name="cfmadre_fam_det" value = "<?=$cfmadre_fam_det?>">
                </div>
            </div>
        </div>
        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
            <div class="RiquadroInfoLong"> 
                <h4 class="mb5" >Residenza</h4>
                <button class="btnBlu20" style=" width: 45%; margin-bottom: 0px; margin-top: 0px;" onclick="CopiaResidenza('alu','madre');">= figlio</button>
                <button class="btnBlu20" style=" width: 45%; margin-bottom: 0px; margin-top: 0px;" onclick="CopiaResidenza('padre','madre');">= padre</button>
                <div class="row" style=" margin-top: 3px;">
                    Via
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="indirizzomadre_fam_det" name="indirizzomadre_fam_det" value = "<?=$indirizzomadre_fam_det?>">
                </div>
                <div  class="row mt5">
                    Comune
                </div>
                <div  class="row mt5">
                    <input class="tablecell7 search-comune" type="text"  id="comunemadre_fam_det" name="comunemadre_fam_det" value = "<?=$comunemadre_fam_det?>">
                </div>
                        <div class="col-md-12 DropDownContainer">
                            <div class="showcomune" name="showComuneResidenzaMadre_det" id="showComuneResidenzaMadre_det" ></div>
                        </div>
                <div  class="row mt5">
                    Provincia
                </div>
                <div  class="row mt5">
                    <input style="width: 20%" class="tablecell7" type="text"  id="provmadre_fam_det" name="provmadre_fam_det" value = "<?=$provmadre_fam_det?>">
                </div>
                <div  class="row mt5">
                    Paese
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="paesemadre_fam_det" name="paesemadre_fam_det" value = "<?=$paesemadre_fam_det?>">
                </div>
                <div  class="row mt5">
                    CAP
                </div>
                <div  class="row mt5">
                    <input style="width: 50%; text-align: center;" class="tablecell7" type="text"  id="CAPmadre_fam_det" name="CAPmadre_fam_det" value = "<?=$CAPmadre_fam_det?>">
                </div>
            </div>
        </div>
        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
            <div class="RiquadroInfoLong">
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
                        <input class="tablecell7" type="text"  id="telefonomadre_fam_det" name="telefonomadre_fam_det" value = "<?=$telefonomadre_fam_det?>">
                    </div>
                    <div  class="col-xs-6">
                        <input class="tablecell7" type="text"  id="altrotelmadre_fam_det" name="altrotelmadre_fam_det" value = "<?=$altrotelmadre_fam_det?>">
                    </div>
                </div>
                <div  class="row mt5">
                    e-mail
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="emailmadre_fam_det" name="emailmadre_fam_det" value = "<?=$emailmadre_fam_det?>">
                </div>
                <div  class="row mt5">
                    titolo
                </div>
                <div  class="row mt5">
                    <div class="row">
                        <select name="titolomadre_fam_det"  style="margin-left: 0px"  id="titolomadre_fam_det">
                            <option value="">-selez.titolo-</option>
                            <option value="nessuno" <?if ($titolomadre_fam_det =='nessuno'){echo ('selected');}?>>nessuno</option>
                            <option value="lic.elementare" <?if ($titolomadre_fam_det =='lic.elementare'){echo ('selected');}?>>lic.elementare</option>
                            <option value="lic.media" <?if ($titolomadre_fam_det =='lic.media'){echo ('selected');}?>>lic.media</option>
                            <option value="diploma" <?if ($titolomadre_fam_det =='diploma'){echo ('selected');}?>>diploma</option>
                            <option value="laurea" <?if ($titolomadre_fam_det =='laurea'){echo ('selected');}?>>laurea</option>
                            <option value="altro" <?if ($titolomadre_fam_det =='altro'){echo ('selected');}?>>altro</option>
                        </select>
                    </div>
                </div>
                <div  class="row mt5">
                    professione
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="profmadre_fam_det" name="profmadre_fam_det" value = "<?=$profmadre_fam_det?>">
                </div>
                <div  class="row mt5">
                    IBAN
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="ibanmadre_fam" name="ibanmadre_fam" value = "<?=$ibanmadre_fam?>">
                </div>
            </div>
        </div>
        <div class="col-md-12" style="text-align: center; font-size: 14px; ">
            <div class="row" style="font-size:16px; margin-top:5px; text-align: center;">
                <div class="col-sm-12">
                    <button class="btnBlu hideonlessthan1280 mb5" onclick="aggiornaAnagrafica('DatiMadre');">Salva Modifiche Anagrafica</button>
                </div>
            </div>
        </div>
    </div>
</div>