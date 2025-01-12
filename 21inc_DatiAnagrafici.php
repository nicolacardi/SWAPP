<!-- ********************************************** TAB DATI ANAGRAFICI **********************************************-->

<? if ($ID_fam_soc!='' || $ID_mae_soc !='') {$disabilita = true;} else {$disabilita = false;}?>
<div class="tab-pane active" id="DatiAnagrafici">
    <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1 mt10" >

        <div class="col-sm-3 col-sm-offset-3 col-md-3 col-md-offset-3 itemSchedaAnagrafica">
            <div class="row">
                Nome
            </div>
            <div class="row">
                <input class="tablecell5" type="text"  id="nome_soc_det" name="nome_soc_det" value="<?=$nome_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
            </div>
        </div>
        <div class="col-sm-3 col-md-3 itemSchedaAnagrafica">
            <div class="row">
                Cognome
            </div>
            <div class="row">
                <input class="tablecell5" type="text"  id="cognome_soc_det" name="cognome_soc_det" value="<?=$cognome_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
            </div>
        </div>
        <div class="col-xs-2 col-xs-offset-5 col-sm-1 col-sm-offset-0 col-md-1 col-md-offset-0 itemSchedaAnagrafica">
            <div class="row">
                M/F
            </div>
            <div class="row">
                <input class="tablecell5" type="text"  id="mf_soc_det" name="mf_soc_det" maxlength="1" value="<?=$mf_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
            </div>
        </div>
        <div class="col-xs-2 col-xs-offset-5 col-sm-1 col-sm-offset-0 col-md-1 col-md-offset-0 itemSchedaAnagrafica">
            <div class="row">
            </div>
            <div class="row">
                <button class="btnBlu hideonlessthan1280" style=" width: 40%; margin-bottom: 10px;" onclick="trovaEAggiornaSocio();">
                <img title="Sincronizza" 
                            src="assets/img/Icone/sync-alt-solid.svg"
                            style=" width: 15px;" >
            </button>


            </div>

        </div>
    </div>


    

    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">	
        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 col-md-offset-0" style="z-index:100">
            <div class="RiquadroInfoLong">
                <h4>Foto & Note</h4>

                <div style="text-align: center; margin-top: 29px; ">
                    <button type="Button" class="btnBlu hideonlessthan1280 mb5" data-toggle="modal" id="launchModalCrop" data-target="#modalFormCroppie" <?if ($disabilita) {echo ("disabled");}?> >Cerca Foto</button>
                </div>
                <div class="parent">
                    <?
                    $folder ='';
                    if ($padremadre_soc == "padre") {$folder = "padri";}
                    if ($padremadre_soc == "madre") {$folder = "madri";}
                    ?>
                    <img id="imgContainerx" class="imgContainerx" width="100" height="100" alt="" 
                    src="assets/photos/imgs<?=$folder?>/<?if ($img_soc != "") {echo(str_replace(' ', '', $img_soc).'?'.rand(100000,999999));} else {echo('unknown.png?'.rand(100000,999999));}?>" >
                </div>
                <!--imgName è una input nascosta dove viene scritto il nome del file caricato e da cui viene estratto il nome in fase di salvataggio-->
                <input class="form-control imgName" id="imgName" name="imgName" maxlength="30" placeholder="immagine" value="<?=str_replace(' ', '', $img_soc)?>">
                <br>
                <div class="row" style="margin-top: 13px;">
                    Note
                </div>
                <div  class="row mt5">
                    <textarea style="height: 72px;" class="tablecell7" type="text"  id="note_soc_det" name="note_soc_det" <?if ($disabilita) {echo ("disabled");}?>><?=$note_soc_det?></textarea>
                </div>
                <div class="row" style="margin-top: 2px;">
                    <?if ($ID_fam_soc!='') {echo ("Il/la socio/a è un genitore<br>i dati anagrafici vanno modificati<br>nella scheda degli alunni figli.");}?>
                    <?if ($ID_mae_soc!='') {echo ("Il/la socio/a è un maestro<br>i dati anagrafici vanno modificati<br>nella scheda relativa.");}?>

                </div>
                <div>
                    <button title="Pdf scheda socio per registro soci" onclick="downloadSchedaSocio(<?=$ID_soc?>)"><img class="iconaStd" src='assets/img/Icone/pdf.svg'></button>
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
                    <input style="text-align: center; width: 50%" class="tablecell7 dpd" type="text"  id="datanascita_soc_det" name="datanascita_soc_det" value = "<? echo(timestamp_to_ggmmaaaa($datanascita_soc_det)) ?>" <?if ($disabilita) {echo ("disabled");}?>>
                </div>
                <div  class="row mt5">
                    Comune
                </div>
                <div  class="row mt5">
                    <input class="tablecell7 search-comune" type="text"  id="comunenascita_soc_det" name="comunenascita_soc_det" value = "<?=$comunenascita_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
                </div>
                    <div class="col-md-12 DropDownContainer">
                        <div class="showcomune" name="showComuneNascita_det" id="showComuneNascita_det" <?if ($disabilita) {echo ("disabled");}?>></div>
                    </div>
                <div  class="row mt5">
                    Provincia
                </div>
                <div  class="row mt5">
                    <input style="width: 20%" class="tablecell7" type="text"  id="provnascita_soc_det" name="provnascita_soc_det" value = "<?=$provnascita_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
                </div>
                <div  class="row mt5">
                    Paese
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="paesenascita_soc_det" name="paesenascita_soc_det" value = "<?=$paesenascita_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
                </div>
                <div  class="row mt5">
                    Cittadinanza
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="cittadinanza_soc_det" name="cittadinanza_soc_det" value = "<?=$cittadinanza_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
                </div>
                <div  class="row mt5">
                    <button class="btnBlu20" style=" width: 40%;" onclick="trovaCF('socio', event);" <?if ($disabilita) {echo ("disabled");}?>>C.F.</button>
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="cf_soc_det" name="cf_soc_det" value = "<?=$cf_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
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
                    <input class="tablecell7" type="text"  id="indirizzo_soc_det" name="indirizzo_soc_det" value = "<?=$indirizzo_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
                </div>
                <div  class="row mt5">
                    Comune
                </div>
                <div  class="row mt5">
                    <input class="tablecell7 search-comune" type="text"  id="comune_soc_det" name="comune_soc_det" value = "<?=$comune_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
                </div>
                    <div class="col-md-12 DropDownContainer">
                        <div class="showcomune" name="showComuneResidenza_det" id="showComuneResidenza_det" <?if ($disabilita) {echo ("disabled");}?>></div>
                    </div>
                <div  class="row mt5">
                    Provincia
                </div>
                <div  class="row mt5">
                    <input style="width: 20%" class="tablecell7" type="text"  id="prov_soc_det" name="prov_soc_det" value = "<?=$prov_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
                </div>
                <div  class="row mt5">
                    Paese
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="paese_soc_det" name="paese_soc_det" value = "<?=$paese_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
                </div>
                <div  class="row mt5">
                    CAP
                </div>
                <div  class="row mt5">
                    <input style="width: 50%; text-align: center; " class="tablecell7" type="text"  id="CAP_soc_det" name="CAP_soc_det" value = "<?=$CAP_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
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
                        <input class="tablecell7" type="text"  id="telefono_soc_det" name="telefono_soc_det" value = "<?=$telefono_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
                    </div>
                    <div  class="col-xs-6">
                        <input class="tablecell7" type="text"  id="altrotel_soc_det" name="altrotel_soc_det" value = "<?=$altrotel_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
                    </div>
                </div>
                <div  class="row mt5">
                    e-mail
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="email_soc_det" name="email_soc_det" value = "<?=$email_soc_det?>" <?if ($disabilita) {echo ("disabled");}?>>
                </div>

                <div  class="row mt5">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        Tipo di Socio
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        Quota
                    </div>

                </div>
                <div  class="row mt5">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                    <select name="selectTipoSoc "  id="selectTipoSoc">
                        <option value="0" <?if ($tipo_soc_det == 0) {echo ("selected");}?>>Fruitore</option>
                        <option value="1" <?if ($tipo_soc_det == 1) {echo ("selected");}?>>Lavoratore</option>
                        <option value="2" <?if ($tipo_soc_det == 2) {echo ("selected");}?>>Volontario</option>
                        <option value="3" <?if ($tipo_soc_det == 3) {echo ("selected");}?>>Altro</option>

                    </select>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <input style="text-align: center;" class="tablecell7" type="text"  id="quotapagata_soc_det" name="quotapagata_soc_det" value = "<?=$quotapagata_soc_det?>" >
                    </div>

                </div>

                <div  class="row mt5">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        Richiesta Iscrizione
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        Iscrizione
                    </div>
                </div>
                <div  class="row mt5">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <input style="text-align: center;" class="tablecell7 dpd" type="text"  id="datarichiestaiscrizione_soc_det" name="datarichiestaiscrizione_soc_det" value = "<? echo(timestamp_to_ggmmaaaa($datarichiestaiscrizione_soc_det)) ?>" >
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <input style="text-align: center;" class="tablecell7 dpd" type="text"  id="dataiscrizione_soc_det" name="dataiscrizione_soc_det" value = "<? echo(timestamp_to_ggmmaaaa($dataiscrizione_soc_det)) ?>" >
                    </div>
                </div>
                <div  class="row mt5">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        Disiscrizione
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        Rest. Quota
                    </div>
                </div>
                <div  class="row mt5">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <input style="text-align: center;" class="tablecell7 dpd" type="text"  id="datadisiscrizione_soc_det" name="datadisiscrizione_soc_det" value = "<? echo(timestamp_to_ggmmaaaa($datadisiscrizione_soc_det)) ?>" >
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <input style="text-align: center;" class="tablecell7 dpd" type="text"  id="datarestituzionequota_soc_det" name="datarestituzionequota_soc_det" value = "<? echo(timestamp_to_ggmmaaaa($datarestituzionequota_soc_det)) ?>" >
                    </div>
                </div>
                <div  class="row mt5">
                    <input style="width:10%;" class="tablecell" type="checkbox"  id="ckrinunciaquota_soc_det" name="ckrinunciaquota_soc_det" value="RinunciaQuota" <? if ($ckrinunciaquota_soc_det == 1) { echo ('checked');} ?>> Rinuncia Rest. Quota
                </div>
                <div  class="row mt5">
                    Motivo cessazione
                </div>
                <div  class="row mt5">
                    <input class="tablecell7" type="text"  id="motivocessazione_soc_det" name="motivocessazione_soc_det" value = "<?=$motivocessazione_soc_det?>" >
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


    <script>
    function downloadSchedaSocio(ID_soc) {
		url = "20downloadSchedaSocio.php";
		let form = $('<form action="' + url + '"method="post"></form>');
		
		let input_ID_soc = $("<input>")
		.attr("type", "text")
		.attr("name", "ID_soc")
		.val(ID_soc);
		$(form).append($(input_ID_soc));;
		
		form.appendTo( document.body );
		
		$(form).submit();
	}

    function trovaEAggiornaSocio() {
        //questa funzione va a cercare se esiste un socio che si chiama come quello attuale tra i genitori e tra i docenti e se sì ne copia tutti i dati e ne fa l'update
        let ID_soc = $("#ID_soc_det_hidden").val(); 
		postData = { ID_soc : ID_soc };
        console.log ("21inc_DatiAnagrafici.php - trovaEAggiornaSocio - postData a 21qry_updateAnagraficaSocioTrova.php ");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "21qry_updateAnagraficaSocioTrova.php",
			data: postData,
			dataType: 'json',
			success: function(data){
                console.log ("ID_soc", data.ID_soc);
                console.log ("nome cognome", data.nomecognome);
				console.log ("padre", data.padre);
                console.log ("madre", data.madre);
                console.log ("maestro", data.maestro);
                console.log ("ID_fam", data.ID_fam);
                console.log ("sql", data.sql);
                console.log ("strupd", data.strupd);
                requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '21inc_DatiAnagrafici ##trovaEAggiornaSocio##'");      
			}
		});
    }

    </script>