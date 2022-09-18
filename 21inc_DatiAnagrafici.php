<!-- ********************************************** TAB DATI ANAGRAFICI **********************************************-->
<div class="tab-pane active" id="DatiAnagrafici">
    <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1 mt10" >

        <div class="col-sm-3 col-sm-offset-3 col-md-3 col-md-offset-3 itemSchedaAnagrafica">
            <div class="row">
                Nome
            </div>
            <div class="row">
                <input class="tablecell5" type="text"  id="nome_soc_det" name="nome_soc_det" value="<?=$nome_soc_det?>" >
            </div>
        </div>
        <div class="col-sm-3 col-md-3 itemSchedaAnagrafica">
            <div class="row">
                Cognome
            </div>
            <div class="row">
                <input class="tablecell5" type="text"  id="cognome_soc_det" name="cognome_soc_det" value="<?=$cognome_soc_det?>" >
            </div>
        </div>
        <div class="col-xs-2 col-xs-offset-5 col-sm-1 col-sm-offset-0 col-md-1 col-md-offset-0 itemSchedaAnagrafica">
            <div class="row">
                M/F
            </div>
            <div class="row">
                <input class="tablecell5" type="text"  id="mf_soc_det" name="mf_soc_det" maxlength="1" value="<?=$mf_soc_det?>" >
            </div>
        </div>
    </div>


    

    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">	
        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
            <div class="RiquadroInfoLong">
                <h4>Foto & Note</h4>
                <div style="text-align: center; margin-top: 29px; ">
                    <button type="Button" class="btnBlu hideonlessthan1280 mb5" data-toggle="modal" id="launchModalCrop" data-target="#modalFormCroppie" >Cerca Foto</button>
                </div>
                <div class="parent">
                    <!--<img id="imgSfondo" width="100" height="100" alt="" src="assets/photos/imgs/unknown.png" data-src="assets/photos/imgs/unknown.png" data-src-retina="assets/photos/imgs/unknown.png">-->
                    <img id="imgContainerx" class="imgContainerx" width="100" height="100" alt="" 
                    src="assets/photos/imgs/<?if ($img_soc != "") {echo(str_replace(' ', '', $img_soc).'?'.rand(100000,999999));} else {echo('unknown.png?'.rand(100000,999999));}?>" >
                    <!--
                        data-src="assets/photos/imgs/<?//if ($img_soc != "") {echo(str_replace(' ', '', $img_soc).'?'.rand(100000,999999));} else {echo('unknown.png?'.rand(100000,999999));}?>" data-src-retina="assets/photos/imgs/<?//=str_replace(' ', '', $img_soc).'?'.rand(100000,999999);?>"
                    -->
                </div>
                <!--imgName è una input dove viene scritto il nome del file caricato-->
                <input class="form-control imgName" id="imgName" name="imgName" maxlength="30" placeholder="immagine" value="<?=str_replace(' ', '', $img_soc)?>">
                <br>
                <div class="row" style="margin-top: 13px;">
                    Note
                </div>
                <div  class="row mt5">
                    <textarea style="height: 72px;" class="tablecell7" type="text"  id="note_soc_det" name="note_soc_det"><?=$note_soc_det?></textarea>
                </div>

            </div>
        </div>
        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
            <div class="RiquadroInfoLong">
                <h4>Nato/a</h4>
                <div class="row mt30">
                    il
                </div>
                <div  class="row mt5">

                    <input style="text-align: center; width: 50%" class="tablecell7 dpd" type="text"  id="datanascita_soc_det" name="datanascita_soc_det" value = "<? echo(timestamp_to_ggmmaaaa($datanascita_soc_det)) ?>">
                </div>
                <div  class="row mt5">
                    Comune
                </div>
                <div  class="row mt5">
                    <input class="tablecell7 search-comune" type="text"  id="comunenascita_soc_det" name="comunenascita_soc_det" value = "<?=$comunenascita_soc_det?>">
                </div>
                    <div class="col-md-12 DropDownContainer">
                        <div class="showcomune" name="showComuneNascita_det" id="showComuneNascita_det" ></div>
                    </div>
                <div  class="row mt5">
                    Provincia
                </div>
                <div  class="row mt5">
                    <input style="width: 20%" class="tablecell7" type="text"  id="provnascita_soc_det" name="provnascita_soc_det" value = "<?=$provnascita_soc_det?>">
                </div>
                <div  class="row mt5">
                    Paese
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="paesenascita_soc_det" name="paesenascita_soc_det" value = "<?=$paesenascita_soc_det?>">
                </div>
                <div  class="row mt5">
                    Cittadinanza
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="cittadinanza_soc_det" name="cittadinanza_soc_det" value = "<?=$cittadinanza_soc_det?>">
                </div>
                <div  class="row mt5">
                    <button class="btnBlu20" style=" width: 40%;" onclick="trovaCF('socio', event);">C.F.</button>
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="cf_soc_det" name="cf_soc_det" value = "<?=$cf_soc_det?>">
                </div>
            </div>
        </div>
        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">			
            <div class="RiquadroInfoLong">
                <h4>Residenza</h4>
                <div class="row mt30">
                    Via
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="indirizzo_soc_det" name="indirizzo_soc_det" value = "<?=$indirizzo_soc_det?>">
                </div>
                <div  class="row mt5">
                    Comune
                </div>
                <div  class="row mt5">
                    <input class="tablecell7 search-comune" type="text"  id="citta_soc_det" name="citta_soc_det" value = "<?=$citta_soc_det?>">
                </div>
                    <div class="col-md-12 DropDownContainer">
                        <div class="showcomune" name="showComuneResidenza_det" id="showComuneResidenza_det" ></div>
                    </div>
                <div  class="row mt5">
                    Provincia
                </div>
                <div  class="row mt5">
                    <input style="width: 20%" class="tablecell7" type="text"  id="prov_soc_det" name="prov_soc_det" value = "<?=$prov_soc_det?>">
                </div>
                <div  class="row mt5">
                    Paese
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="paese_soc_det" name="paese_soc_det" value = "<?=$paese_soc_det?>">
                </div>
                <div  class="row mt5">
                    CAP
                </div>
                <div  class="row mt5">
                    <input style="width: 50%; text-align: center; " class="tablecell7" type="text"  id="CAP_soc_det" name="CAP_soc_det" value = "<?=$CAP_soc_det?>">
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
                <div  class="row mt5">
                    
                    <div  class="col-xs-6">
                        <input class="tablecell7" type="text"  id="telefono_soc_det" name="telefono_soc_det" value = "<?=$telefono_soc_det?>">
                    </div>
                    <div  class="col-xs-6">
                        <input class="tablecell7" type="text"  id="altrotelefono_soc_det" name="altrotelefono_soc_det" value = "<?=$altrotelefono_soc_det?>">
                    </div>
                </div>
                <div  class="row mt5">
                    e-mail
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="email_soc_det" name="email_soc_det" value = "<?=$email_soc_det?>">
                </div>

                <div  class="row mt5">
                    Tipo Socio
                </div>
                <div  class="row mt5">
                    <select name="selectTipoSoc "  id="selectTipoSoc">
                        <option value="0" <?if ($tipo_soc_det == 0) {echo ("selected");}?>>Fruitore</option>
                        <option value="1" <?if ($tipo_soc_det == 1) {echo ("selected");}?>>Lavoratore</option>
                        <option value="2" <?if ($tipo_soc_det == 2) {echo ("selected");}?>>Volontario</option>
                        <option value="3" <?if ($tipo_soc_det == 3) {echo ("selected");}?>>Altro</option>

                    </select>
                </div>
                
            </div>
        </div>
        <div class="col-md-12" style="text-align: center; font-size: 14px; ">
            <div class="row" style="font-size:16px; margin-top:5px; text-align: center;">
                <div class="col-sm-12">
                    <button class="btnBlu hideonlessthan1280" style=" width: 40%; margin-bottom: 10px;" onclick="aggiornaAnagrafica('DatiAnagrafici');">Salva Modifiche Anagrafica</button>
                </div>
            </div>
        </div>
    </div>
</div>