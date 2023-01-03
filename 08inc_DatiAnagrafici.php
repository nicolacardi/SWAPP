<!-- ********************************************** TAB DATI ANAGRAFICI **********************************************-->
<div class="tab-pane active" id="DatiAnagrafici">
    <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1 mt10" >

        <div class="col-sm-3 col-sm-offset-3 col-md-3 col-md-offset-3 itemSchedaAnagrafica">
            <div class="row">
                Nome
            </div>
            <div class="row">
                <input class="tablecell5" type="text"  id="nome_mae_det" name="nome_mae_det" value="<?=$nome_mae_det?>" >
            </div>
        </div>
        <div class="col-sm-3 col-md-3 itemSchedaAnagrafica">
            <div class="row">
                Cognome
            </div>
            <div class="row">
                <input class="tablecell5" type="text"  id="cognome_mae_det" name="cognome_mae_det" value="<?=$cognome_mae_det?>" >
            </div>
        </div>
        <div class="col-xs-2 col-xs-offset-5 col-sm-1 col-sm-offset-0 col-md-1 col-md-offset-0 itemSchedaAnagrafica">
            <div class="row">
                M/F
            </div>
            <div class="row">
                <input class="tablecell5" type="text"  id="mf_mae_det" name="mf_mae_det" maxlength="1" value="<?=$mf_mae_det?>" >
            </div>
        </div>
        <div class="col-md-1 col-sm-1 itemSchedaAnagrafica">
            <div class="row">
            (in libro soci)
            </div>
            <div class="row">
                <input style="width:20%;" class="tablecell" type="checkbox"  id="socio_mae_det" name="socio_mae_det" value="socio" <? if ($socio_mae_det == 1) { echo ('checked');} ?> onclick="showModalAffiliazioneMaestro(<?=$ID_mae?>)">
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
                    src="assets/photos/imgs/<?if ($img_mae != "") {echo(str_replace(' ', '', $img_mae).'?'.rand(100000,999999));} else {echo('unknown.png?'.rand(100000,999999));}?>" >
                    <!--
                        data-src="assets/photos/imgs/<?//if ($img_mae != "") {echo(str_replace(' ', '', $img_mae).'?'.rand(100000,999999));} else {echo('unknown.png?'.rand(100000,999999));}?>" data-src-retina="assets/photos/imgs/<?//=str_replace(' ', '', $img_mae).'?'.rand(100000,999999);?>"
                    -->
                </div>
                <!--imgName è una input dove viene scritto il nome del file caricato-->
                <input class="form-control imgName" id="imgName" name="imgName" maxlength="30" placeholder="immagine" value="<?=str_replace(' ', '', $img_mae)?>">
                <br>
                <div class="row" style="margin-top: 13px;">
                    Note
                </div>
                <div  class="row mt5">
                    <textarea style="height: 72px;" class="tablecell7" type="text"  id="note_mae_det" name="note_mae_det"><?=$note_mae_det?></textarea>
                </div>
                <div  class="row mt5">
                    <input style="width: 20px;" class="tablecell7" type="checkbox"  id="in_organico_mae" name="in_organico_mae" <? if ($in_organico_mae_det == 1) {echo ("checked");}?>> in organico
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

                    <input style="text-align: center; width: 50%" class="tablecell7 dpd" type="text"  id="datanascita_mae_det" name="datanascita_mae_det" value = "<? echo(timestamp_to_ggmmaaaa($datanascita_mae_det)) ?>">
                </div>
                <div  class="row mt5">
                    Comune
                </div>
                <div  class="row mt5">
                    <input class="tablecell7 search-comune" type="text"  id="comunenascita_mae_det" name="comunenascita_mae_det" value = "<?=$comunenascita_mae_det?>">
                </div>
                    <div class="col-md-12 DropDownContainer">
                        <div class="showcomune" name="showComuneNascita_det" id="showComuneNascita_det" ></div>
                    </div>
                <div  class="row mt5">
                    Provincia
                </div>
                <div  class="row mt5">
                    <input style="width: 20%" class="tablecell7" type="text"  id="provnascita_mae_det" name="provnascita_mae_det" value = "<?=$provnascita_mae_det?>">
                </div>
                <div  class="row mt5">
                    Paese
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="paesenascita_mae_det" name="paesenascita_mae_det" value = "<?=$paesenascita_mae_det?>">
                </div>
                <div  class="row mt5">
                    Cittadinanza
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="cittadinanza_mae_det" name="cittadinanza_mae_det" value = "<?=$cittadinanza_mae_det?>">
                </div>
                <div  class="row mt5">
                    <button class="btnBlu20" style=" width: 40%;" onclick="trovaCF('maestro', event);">C.F.</button>
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="cf_mae_det" name="cf_mae_det" value = "<?=$cf_mae_det?>">
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
                    <input class="tablecell7" type="text"  id="indirizzo_mae_det" name="indirizzo_mae_det" value = "<?=$indirizzo_mae_det?>">
                </div>
                <div  class="row mt5">
                    Comune
                </div>
                <div  class="row mt5">
                    <input class="tablecell7 search-comune" type="text"  id="citta_mae_det" name="citta_mae_det" value = "<?=$citta_mae_det?>">
                </div>
                    <div class="col-md-12 DropDownContainer">
                        <div class="showcomune" name="showComuneResidenza_det" id="showComuneResidenza_det" ></div>
                    </div>
                <div  class="row mt5">
                    Provincia
                </div>
                <div  class="row mt5">
                    <input style="width: 20%" class="tablecell7" type="text"  id="prov_mae_det" name="prov_mae_det" value = "<?=$prov_mae_det?>">
                </div>
                <div  class="row mt5">
                    Paese
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="paese_mae_det" name="paese_mae_det" value = "<?=$paese_mae_det?>">
                </div>
                <div  class="row mt5">
                    CAP
                </div>
                <div  class="row mt5">
                    <input style="width: 50%; text-align: center; " class="tablecell7" type="text"  id="CAP_mae_det" name="CAP_mae_det" value = "<?=$CAP_mae_det?>">
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
                        <input class="tablecell7" type="text"  id="telefono_mae_det" name="telefono_mae_det" value = "<?=$telefono_mae_det?>">
                    </div>
                    <div  class="col-xs-6">
                        <input class="tablecell7" type="text"  id="altrotelefono_mae_det" name="altrotelefono_mae_det" value = "<?=$altrotelefono_mae_det?>">
                    </div>
                </div>
                <div  class="row mt5">
                    e-mail
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="email_mae_det" name="email_mae_det" value = "<?=$email_mae_det?>">
                </div>
                <div  class="row mt5">
                    Titolo
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="titolo_mae_det" name="titolo_mae_det" value = "<?=$titolo_mae_det?>">
                </div>
                <div  class="row mt5">
                    Tipo Personale
                </div>
                <div  class="row mt5">
                    <select name="selectTipoPer "  id="selectTipoPer">
                        <option value="0" <?if ($tipo_per_det == 0) {echo ("selected");}?>>Maestro</option>
                        <option value="1" <?if ($tipo_per_det == 1) {echo ("selected");}?>>Amministratore</option>
                        <option value="2" <?if ($tipo_per_det == 2) {echo ("selected");}?>>Altro personale</option>
                    </select>
                </div>
                <div  class="row mt5">
                    login SWAPP
                </div>
                <div  class="row mt5">
                    <input class="tablecell4" type="text"  id="ID_usr_mae_det_hidden" name="ID_usr_mae_det_hidden" value = "<?=$ID_usr_mae_det?>" hidden>	
                    <input class="tablecell7" type="text"  id="login_usr" name="login_usr" value = "<?=$login_usr?>">
                </div>
                <div  class="row mt5">
                    vede:
                    <input id="ckSueClassi1" value="1" type="radio" name="vede_mae" <?if($vede_mae == 1) {echo ('checked');}?> > le sue classi
                    <input id="ckSueClassi2" value="2" type="radio" name="vede_mae" <?if($vede_mae == 2) {echo ('checked');}?> > tutte le classi
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