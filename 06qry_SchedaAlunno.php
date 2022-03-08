<?	include_once("database/databaseii.php");
	include_once("iscrizioni/diciture.php");
	include_once("assets/functions/functions.php");

$ID_alu = $_POST['ID_alu'];?>

	<div id="TabsSchedaAlunno" style="display: none; margin-top:5px;">
<!-- LABELS DEI TAB GROUP *************************************************************************************-->

		<ul class="nav nav-tabs" id="TabsSchedaAlunnoLabels">
			<li style="margin-left: 60px;">
				<a href="#DatiAnagrafici" data-toggle="tab" class="active">Alunno</a>
			</li>
			<li>
				<a href="#DatiPadre" data-toggle="tab" class="active">Padre <span class="smalltext">(o Tutore 1)<span></a>
			</li>
			<li>
				<a href="#DatiMadre" data-toggle="tab" class="active">Madre <span class="smalltext">(o Tutore 2)<span></a>
			</li>
			<!-- <li>
				<a href="#ListaDAttesa" class="hideonlessthan1280" data-toggle="tab">Lista d'Attesa</a>
			</li> -->
			<li>
				<a href="#ListaDAttesaeInserimento" class="hideonlessthan1280" data-toggle="tab">Lista d'Attesa</a>
			</li>
			<li>
				<a href="#Colloqui" class="hideonlessthan1280" data-toggle="tab">Colloqui</a>
			</li>
			<li>
				<a href="#Classi" data-toggle="tab">Iscrizioni</a>
			</li>
		</ul>

<!-- ESTRAZIONE DATI ******************************************************************************************-->
		<?
		$sql2 = "SELECT DISTINCT ID_alu, nome_alu, cognome_alu, mf_alu, datanascita_alu, comunenascita_alu, provnascita_alu, paesenascita_alu, cittadinanza_alu, cf_alu, indirizzo_alu, citta_alu, prov_alu, paese_alu, CAP_alu, autfoto_alu, scuolaprimaprovenienza_alu, indirizzoscprimaproven_alu, scuolaprovenienza_alu, indirizzoscproven_alu, ckautfoto_alu, ckautmateriale_alu, ckautuscite_alu, ckautuscitaautonoma_alu, ckmensa_alu, ckreligione_alu, altreligione_alu, cktrasportopubblico_alu, ckdoposcuola_alu, ".//campi di tab_anagraficaalunni
		"nomemadre_fam, cognomemadre_fam, nomepadre_fam, cognomepadre_fam, telefonomadre_fam, altrotelmadre_fam, telefonopadre_fam, altrotelpadre_fam, emailmadre_fam, emailpadre_fam, sociomadre_fam, sociopadre_fam, note_alu, img_alu, disabilita_alu, dettaglidisabilita_alu, DSA_alu, ".//campi di tab_famiglie
		"datanascitapadre_fam, comunenascitapadre_fam, provnascitapadre_fam, paesenascitapadre_fam, cfpadre_fam, indirizzopadre_fam, comunepadre_fam, CAPpadre_fam, provpadre_fam, paesepadre_fam, profpadre_fam, titolopadre_fam, ".
		"datanascitamadre_fam, comunenascitamadre_fam, provnascitamadre_fam, paesenascitamadre_fam, cfmadre_fam, indirizzomadre_fam, comunemadre_fam, CAPmadre_fam, provmadre_fam, paesemadre_fam, profmadre_fam, titolomadre_fam, imgmadre_fam, imgpadre_fam, notemadre_fam, notepadre_fam, intestazionefatt_fam, ID_fam_alu, ibanpadre_fam, ibanmadre_fam, rapprpadre_fam, rapprmadre_fam ".
		"FROM tab_anagraficaalunni ".
		"LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam WHERE ID_alu = ?;";

		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "i", $ID_alu);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $ID_alu_det, $nome_alu_det, $cognome_alu_det, $mf_alu_det, $datanascita_alu_det, $comunenascita_alu_det, $provnascita_alu_det, $paesenascita_alu_det, $cittadinanza_alu_det, $cf_alu_det, $indirizzo_alu_det, $citta_alu_det, $prov_alu_det, $paese_alu_det, $CAP_alu_det, $autfoto_alu_det, $scuolaprimaprovenienza_alu_det, $indirizzoscprimaproven_alu_det, $scuolaprovenienza_alu_det, $indirizzoscproven_alu_det, $ckautfoto_alu_det, $ckautmateriale_alu_det, $ckautuscite_alu_det, $ckautuscitaautonoma_alu_det, $ckmensa_alu_det, $ckreligione_alu_det, $altreligione_alu_det, $cktrasportopubblico_alu_det, $ckdoposcuola_alu_det, $nomemadre_fam_det, $cognomemadre_fam_det, $nomepadre_fam_det, $cognomepadre_fam_det, $telefonomadre_fam_det, $altrotelmadre_fam_det, $telefonopadre_fam_det, $altrotelpadre_fam_det, $emailmadre_fam_det, $emailpadre_fam_det, $sociomadre_fam_det, $sociopadre_fam_det, $note_alu, $img_alu, $disabilita_alu_det, $dettaglidisabilita_alu_det, $DSA_alu_det, $datanascitapadre_fam_det, $comunenascitapadre_fam_det, $provnascitapadre_fam_det, $paesenascitapadre_fam_det, $cfpadre_fam_det, $indirizzopadre_fam_det, $comunepadre_fam_det, $CAPpadre_fam_det, $provpadre_fam_det, $paesepadre_fam_det, $profpadre_fam_det, $titolopadre_fam_det, $datanascitamadre_fam_det, $comunenascitamadre_fam_det, $provnascitamadre_fam_det, $paesenascitamadre_fam_det, $cfmadre_fam_det, $indirizzomadre_fam_det, $comunemadre_fam_det, $CAPmadre_fam_det, $provmadre_fam_det, $paesemadre_fam_det, $profmadre_fam_det, $titolomadre_fam_det, $imgmadre_fam, $imgpadre_fam, $notemadre_fam, $notepadre_fam, $intestazionefatt_fam, $ID_fam_alu, $ibanpadre_fam, $ibanmadre_fam, $rapprpadre_fam, $rapprmadre_fam);

		$i=0;
		while (mysqli_stmt_fetch($stmt2)) {
			$i++;
		}
		
		//conto quanti fratelli
		$sql4 = "SELECT ID_alu, nome_alu, cognome_alu FROM tab_anagraficaalunni ".
		" WHERE ID_fam_alu = ? ;";
		$stmt4 = mysqli_prepare($mysqli, $sql4);
		mysqli_stmt_bind_param($stmt4, "i", $ID_fam_alu);
		mysqli_stmt_execute($stmt4);
		mysqli_stmt_bind_result($stmt4, $ID_alu_fra, $nome_fra, $cognome_fra);
		
		$fratelli = 0;
		
		while (mysqli_stmt_fetch($stmt4)) {
			$fratelli++;
			$fratello_nome[$fratelli] = $nome_fra;
			$fratello_cognome[$fratelli] = $cognome_fra;
		}
		
		
		?>
<!-- INPUT HIDDEN E RICHIAMO 06inc_ VARI **********************************************************************-->

		<div class="tab-content" id="TabsSchedaAlunnoContent">
			<input id="hidden_open_who" 										hidden>
			<input id="hidden_nome_scuola" 		value="<?=$nomescuola?>" 		hidden>
			<input id="hidden_indirizzo_scuola" value="<?=$indirizzoscuola?>" 	hidden>
			<input id="hidden_ID_fam" 			value="<?=$ID_fam_alu?>"		hidden>
			<!--Il "component" colloqui ha bisogno di sapere in quale pagina si trova per usare requery oppure requeryDettaglio-->
			<input id="hidden_page" 			value="SchedaAlunno"			hidden>

			<?include_once ('06inc_DatiAnagrafici.php');?>
			
			<?include_once ('06inc_DatiPadre.php');?>
			
			<?include_once ('06inc_DatiMadre.php');?>
			
			<?include_once ('06inc_Iscrizioni.php');?>

			<?//include_once ('06inc_ListadAttesa.php');?>

			<?include_once ('06inc_ListadAttesaeInserimento.php');?>

			<?include_once ('06inc_Colloqui.php');?>

		</div>
	</div>


	<div style="text-align: center;">
		<div class="alert alert-success" id="alertModificaAnagrafica" style="display: none; width: 500px; text-align: center; margin-top:10px; position: absolute; margin-left: -250px; left: 50% ">
			<h4 style="text-align:center;"> Aggiornamento anagrafica completato con successo!</h4>
		</div>
	</div>

<!-- FORM MODALE FRATELLI E MODIFICA FAMIGLIA *****************************************************************-->

	<div class="modal" id="modalFratelli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_fratelli" method="post">
						<span class="titoloModal">FRATELLI DI</span>
						<br>
						<span style="width:50%; font-size: 20px; "><?=$nome_alu_det?> <?=$cognome_alu_det?></span>
						<br>
						<div id="remove-contentFRATELLI" style="text-align: center;"> <!-- START REMOVE CONTENT -->
							<br>
							In anagrafica SWAPP la famiglia di <?=$nome_alu_det?> <?=$cognome_alu_det?>
							<? if ($fratelli != 1) {
								echo("comprende : <br><br>");
								for ($i = 1; $i <= $fratelli; $i++) {
									echo($fratello_nome[$i]." ".$fratello_cognome[$i]."<br>");
								}
							} else {
								echo("<br>non comprende fratelli");
							}
							?>
							<hr>
							<span class="testoModal">da questa maschera è possibile associare l'alunno/a</span>
							<span class="testoModal">ad una famiglia diversa</span>
							<div class="row">
								<div class="col-md-12" style="text-align: center; margin-top: 30px; ">
									<select id="selectFamigliaF" name="selectFamiglia"  onchange="aggiornaDatiFamigliaModalF();">
										<? $sql = "SELECT ID_fam, cognomepadre_fam, cognomemadre_fam FROM tab_famiglie ORDER BY cognomepadre_fam";
											$stmt = mysqli_prepare($mysqli, $sql);
											mysqli_stmt_execute($stmt);
											mysqli_stmt_bind_result($stmt, $ID_fam, $cognomepadre_fam, $cognomemadre_fam);
											?> <option value="none" selected>-NUOVA FAMIGLIA-</option> <?
											while (mysqli_stmt_fetch($stmt)) {
											?> <option value="<?=$ID_fam?>" ><?=$cognomepadre_fam." - ".$cognomemadre_fam?></option><?
											}?>
									</select>
								</div>
								<div class="col-md-12" style= "margin-top: 0px; font-size: 12px;">
										(Selezionare dalla casella a discesa se si tratta di un fratello/sorella di altro alunno già in anagrafica)
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 subtitleModal">
									Mamma
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
								</div>
								<div class="col-md-4">
									nome
								</div>
								<div class="col-md-4">
									cognome
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
									
								</div>
								<div class="col-md-4 center">
									<input type="text"  class="tablecell5"  id="nomemadre_fam_newF"  maxlength="50" name="nomemadre_fam_new">
								</div>
								<div class="col-md-4 center">
									<input type="text"  class="tablecell5"  id="cognomemadre_fam_newF"  maxlength="50" name="cognomemadre_fam_new">
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12 subtitleModal">
									Papà
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
									
								</div>
								<div class="col-md-4">
									nome
								</div>
								<div class="col-md-4">
									cognome
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
									
								</div>
								<div class="col-md-4 center">
									<input type="text"  class="tablecell5"  id="nomepadre_fam_newF"  maxlength="50" name="nomepadre_fam_new">
								</div>
								<div class="col-md-4 center">
									<input type="text"  class="tablecell5"  id="cognomepadre_fam_newF"  maxlength="50" name="cognomepadre_fam_new">
								</div>
							</div>
							<br>
						</div> <!-- END REMOVE CONTENT -->
						<div class="alert alert-success" id="alertFRATELLI" style="display:none; margin-top:10px;">
							<h4 style="text-align:center;"> 
							  Uscita in corso d'anno impostata!</h4>
						</div>
						<div class="modal-footer">
							<button type="button" id="btn_cancelFRATELLI" class="btnBlu pull-left" style="width:40%;" data-dismiss="modal" onclick="requery();">Annulla</button>
							<button type="button" id="btn_OKFRATELLI" class="btnBlu pull-right" style="width:40%;" onclick="aggiornaFamigliaPerAlu(<?echo($ID_alu.','.$ID_fam_alu.','.$fratelli);?>);">Procedi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!-- FINE FORM MODALE FRATELLI E MODIFICA FAMIGLIA ************************************************************-->

<!-- FORM MODALE ISCRIZIONE/AGGIUNTA ANNO SCOLASTICO **********************************************************-->
	<div class="modal" id="modalAggiungiAnnoScolastico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_iscrizione" method="post">
						<span class="titoloModal">Iscrizione di</span>
						<br>
						<span class="titoloModal"><?=$nome_alu_det?> <?=$cognome_alu_det?></span>
						<br>
						<input id="ListaDAttesaCk" type="checkbox" hidden></input>
						<span id="ListaDAttesa" style="width:50%; font-size: 20px; color:red; display: none;">- alla lista d'attesa -</span>
						<div id="remove-contentAggiungiAnnoScolastico" style="text-align: center;"> <!-- START REMOVE CONTENT -->
							<br>
							Selezionare l'anno scolastico al quale si desidera iscrivere l'alunno/a.
							<br>
							<select name="selectannoscolastico_modal"  style="margin-top: 20px; "  id="selectannoscolastico_modal">
								<? $sql3 = "SELECT annoscolastico_asc FROM tab_anniscolastici";
									$stmt3 = mysqli_prepare($mysqli, $sql3);
									mysqli_stmt_execute($stmt3);
									mysqli_stmt_bind_result($stmt3, $annoscolastico_asc);
									while (mysqli_stmt_fetch($stmt3)) {
									?> <option value="<?=$annoscolastico_asc?>" <?if ($annoscolastico_asc == $_SESSION['anno_corrente']) {echo "selected";}?>><?=$annoscolastico_asc?></option><?
									}?>
							</select>
							<br>
							<br>
							Selezionare la classe alla quale si desidera iscrivere l'alunno/a.
							<br>
							
							<select name="selectclasse_modal"  style="margin-top: 20px; "  id="selectclasse_modal">
								<? $sql3 = "SELECT classe_cls FROM tab_classi";
									$stmt3 = mysqli_prepare($mysqli, $sql3);
									mysqli_stmt_execute($stmt3);
									mysqli_stmt_bind_result($stmt3, $classe_cls);
									while (mysqli_stmt_fetch($stmt3)) {
									?> <option value="<?=$classe_cls?>"><?=$classe_cls?></option><?
									}?>
							</select>
							<br>
							Alunno frequentante l'anno precedente presso questa scuola e bocciato
							<input type="checkbox" name="bocciato" id="bocciato"><br>
							<br>
							<?if ($_SESSION['scalino'] == 1) {?>	
								SCALINO
								<input type="checkbox" name="scalino" id="scalino" class="mt10" >
								<br>
							<?}?>
							<br>
							Selezionare la sezione alla quale si desidera iscrivere l'alunno/a.
							<br>
							<select name="selectsezione_modal"  style="margin-top: 20px; "  id="selectsezione_modal">
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
							</select>
							<br>

						</div> <!-- END REMOVE CONTENT -->
						<div class="alert alert-success" id="alertaggiungiAS" style="display:none; margin-top:10px;">
							<h4 style="text-align:center;" id="alertaggiungimsg"> 
							  Iscrizione completata con successo!</h4>
						</div>
						<div class="modal-footer">
							<button type="button" id="btn_cancelIscrizione" class="btnBlu" style="width:40%;" data-dismiss="modal" onclick="requery();">Annulla</button>
							<button type="button" id="btn_OKIscrizione" class="btnBlu pull-right" style="width:40%;" onclick="aggiungiAnnoScolastico();">Procedi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!-- FINE FORM MODALE ISCRIZIONE/AGGIUNTA ANNO SCOLASTICO *****************************************************-->

<!-- FORM MODALE USCITA IN CORSO D'ANNO ***********************************************************************-->
	<div class="modal" id="modalAggiungiUscitaInCorso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_uscitaincorso" method="post">
						<span class="titoloModal">Uscita in corso d'anno</span>
						<br>
						<span style="width:50%; font-size: 20px; "><?=$nome_alu_det?> <?=$cognome_alu_det?></span>
						<br>
						<div id="remove-content1" style="text-align: center;"> <!-- START REMOVE CONTENT -->
							<br>
							Utilizzare questa funzione solo per le uscite DURANTE l'anno scolastico.
							<br>
							L'alunno/a verrà mantenuto/a nelle liste della classe, così come nelle liste dei pagamenti.
							<br>
							<br>
							Indicare la data di uscita ufficiale per l'anno
							<br>
							<input type="text" style="border:none; text-align:center;" name="annoscolasticoUscita" id="annoscolasticoUscita">
							<br>
							<input class="tablecell3 dpd" style="text-align: center;" type="text" name="dataUscita" id="dataUscita" onkeydown="return false;">
							<br>
						</div> <!-- END REMOVE CONTENT -->
						<div class="alert alert-success" id="alertUSCITA" style="display:none; margin-top:10px;">
							<h4 style="text-align:center;"> 
							  Uscita in corso d'anno impostata!</h4>
						</div>
						<div class="modal-footer">
							<button type="button" id="btn_cancelUscita" class="btnBlu" style="width:40%;" data-dismiss="modal" onclick="requery();">Annulla</button>
							<button type="button" id="btn_OKUscita" class="btnBlu pull-right" style="width:40%;" onclick="aggiungiUscitaInCorso();">Procedi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!-- FINE FORM MODALE USCITA IN CORSO D'ANNO ******************************************************************-->

<!-- FORM MODALE CAMBIO SEZIONE ***********************************************************************-->
	<div class="modal" id="modalCambioSezione" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_CambioSezione" method="post">
						<span class="titoloModal">Cambio Sezione per l'alunno</span>
						<br>
						<span style="width:50%; font-size: 20px; "><?=$nome_alu_det?> <?=$cognome_alu_det?></span>
						<br>
						<div id="annoScolasticoCambioSezione"></div>
						<div id="remove-contentCambioSezione" style="text-align: center;"> <!-- START REMOVE CONTENT -->
							<br>
							ATTENZIONE
							<br>
							E' raccomandabile utilizzare questa funzionalità SOLAMENTE
							<br>
							per le nuove iscrizioni e non per alunni che abbiamo già frequentato l'anno
							<br>
							Tipicamente per assegnare ad un asilo invece che all'altro gli alunni in fase di inserimento
						<div class="mt10" id="selectSezioneContainer">

						</div>

						</div> <!-- END REMOVE CONTENT -->
						<div class="alert alert-success" id="alertCambioSezione" style="display:none; margin-top:10px;">
							<h4 style="text-align:center;"> 
							  Cambio Sezione Eseguito !</h4>
						</div>
						<div class="modal-footer">
							<button type="button" id="btn_cancelCambioSezione" class="btnBlu" style="width:40%;" data-dismiss="modal" onclick="requery();">Annulla</button>
							<button type="button" id="btn_OKCambioSezione" class="btnBlu pull-right" style="width:40%;" onclick="cambioSezione();">Procedi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!-- FINE FORM MODALE USCITA IN CORSO D'ANNO ******************************************************************-->

<!-- CROPPIE **************************************************************************************************-->
	<div class="modal" id="modalFormCroppie" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="width:450px;">
			<div class="modal-content">
				<div class="modal-header" style="text-align: center; border-bottom: 0px;">
					<span class="titoloModal" >
							Selezione e ritaglio Immagine
							<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> -->
					</span>
				</div>
				<div class="modal-body" style="padding-bottom:500px;">
					<div class="col-md-12">
						<!--uploadCrop è la zona di overview dentro Croppie-->
						<div class= "uploadCrop" id="uploadCrop">
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-12">
								
								<!-- la input dove viene scritto il nome del file estratto dal db nel modale-->
								<!--<input class="form-control" id="filenametosave" style="  border-radius: 10px; text-align:center; height:34px; padding:6px 12px;" name="filenametosave" value = "<?//=$img_alu;?>" disabled> -->
								
								<!-- di seguito la label carina usata per il bottone di caricamento upload-->
								<label class="btnBlu" for="imgSelezioneInModale" style="width:100%;">Cerca Immagine nel Computer</label>
								<input type="file" id="imgSelezioneInModale" accept="image/*" style="display: none;">
								<!-- la input dove viene scritto il nome del file nel form modale-->
								<input id="imgNameModal" name="imgNameModal" maxlength="30" placeholder="immagine" style="display: none;"> 
								<br/>
								<button class="btnBlu" data-dismiss="modal" id="imgProcediconCrop" style="width:100%;">Ritaglia Immagine</button>	
						</div>
					</div>
	<!----------------------------------------FUNZIONI DI CROPPIE----------------------------------------------------------------->			
					<script>
						
						//setta le caratteristiche del plugin per la visualizzazione di Croppie agendo su uploadCrop
						$uploadCrop = $('#uploadCrop').croppie({
							enableExif: true,
							viewport: {
								width: 200,
								height: 200,
								type: 'square'
							},
							boundary: {
								width: 350,
								height: 350
							}
						});
						



						//Viene lanciata in fase di caricamento di "ALTRA" immagine rispetto a quella eventualmente già in database
						//viene lanciata in fase di change dell'input file #upload
						$('#imgSelezioneInModale').on('change', function () {
							fileName = $('#imgSelezioneInModale')[0].files[0].name;
							$(".cr-image").css("display", "block");
							fileName = fileName.replace(/[\|&;\$%@"<>\(\)\+,]/g, "");
							fileName = fileName.replace ("-", "");
							$("#imgNameModal").val(fileName);
							let reader = new FileReader();
							reader.onload = function (e) {
								$uploadCrop.croppie('bind', {
									url: e.target.result
								}).then(function(){
									// console.log('jQuery bind complete');
								});
							};
							reader.readAsDataURL(this.files[0]);
						});
						

						//da qui avviene il crop ed il conseguente caricamento/upload ecc
			
						$('#imgProcediconCrop').on('click', function () {
							let who = $("#hidden_open_who").val();
							switch(who) {
							case 'padri':
								nome = $('#nomepadre_fam_det').val();
								cognome = $('#cognomepadre_fam_det').val();
								break;
							case 'madri':
								nome = $('#nomemadre_fam_det').val();
								cognome = $('#cognomemadre_fam_det').val();
								break;
							default:
								nome = $('#nome_alu').val();
								cognome = $('#cognome_alu').val();
							}


							// nome = $('#nome_alu').val();
							// cognome = $('#cognome_alu').val();
							fileName = nome + cognome;
							fileName = fileName.replace(/[\|&;\$%@"<>\(\)\+,]/g, "");
							fileName = fileName.replace ("'", "");
							fileName = fileName.replace (" ", "");
							fileName = fileName.replace ("-", "");
							fileName = fileName.replace ("`", "");
							//prepara l'immagine croppata in forma base64 e la mette nella variabile resp
							console.log ("++"+fileName);
							$uploadCrop.croppie('result', {
								type: 'base64',
								size: 'viewport'
							}).then(function (resp) {
								//la ajax che segue manda a croppieupload che EFFETTUA l'UPLOAD dell'immagine passata in base 64 con il nome fileName nella cartella assets/photos/imgs
								$.ajax({
									url: "croppieupload.php",
									type: "POST",
									data: {"image":resp, "filenametosave": fileName, "foldertoupload": 'assets/photos/imgs'+who},
									success: function () {
										let imgtoupdate = document.getElementById('imgContainerx'+who);
										let num = Math.random(); 								//serve per caricare immagine indipendentemente dal fatto che sia già in cache
										imgtoupdate.src = "assets/photos/imgs"+who+"/"+fileName+".png?"+num;  		//riapplica estensione
										let imgNameElement = document.getElementById('imgName'+who);
										imgNameElement.value = fileName+".png?"+num;
									},
									error: function(){
									alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno ##fname##'");      
									}
								});
							});
							//ora devo anche salvare in database il valore
						});
						/*function removeExtension(filename){
							let lastDotPosition = filename.lastIndexOf(".");
							if (lastDotPosition === -1) return filename;
							else return filename.substr(0, lastDotPosition);
						}*/
					</script>
				</div>
			</div>
		</div>
	</div>
<!-- FINE CROPPIE *********************************************************************************************-->

</body>
</html>
<? include("CodiceFiscale.php")?>
<script>
	
	$(document).ready(function(){
		moment.locale('en', {
			week: { dow: 1 }
		});
		
		$('.dpd').datetimepicker({
			pickTime: false, 
			format: "DD/MM/YYYY",
			weekStart: 1
		});



		
		let ID_alu = $("#ID_alu_det_hidden").val();
		if (ID_alu != "") { 
			$("#TabsSchedaAlunno").css('display','block');
			let pagtoshow = $("#pagtoshow_hidden").val();
			$('#TabsSchedaAlunnoLabels a[href="#'+pagtoshow+'"]').tab('show');
		}
		
		PopolaPersonalePresente (1, $("#hidden_incontrocon1").val());
		PopolaPersonalePresente (2, $("#hidden_incontrocon2").val());
		PopolaPersonalePresente (3, $("#hidden_incontrocon3").val());
		var viewportWidth = $(window).width();
		if (viewportWidth < 1280) { $('.hideonlessthan1280').hide();} else { $('.hideonlessthan1280').show();}
		if (viewportWidth < 1280) { $('.showonlessthan1280').show();} else { $('.showonlessthan1280').hide();}
	});
	
	function PopolaPersonalePresente(step, idpersonale_ver) {
		postData = { step: step, idpersonale_ver: idpersonale_ver};
		$.ajax({
			type: 'POST',
			url: "06qry_getPersonale.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#PersonalePresenteContainer"+step).html(html);
				//requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno ##fname##'");      
			}
			
		});
	}
	
	$("#mf_alu_det").keypress(function(e){
		let inputValue = event.which;
		// F = 70, M = 77
		if((inputValue != 70) && (inputValue != 77)){ 
			e.preventDefault(); 
		}
	});
	
	// function controllaDataNascita (data, annomin, annomax) {
	// 	if ((data != "") && (data != null)) {
	// 		let datam = moment(data, "DD-MM-YYYY" );
	// 		let annom = moment(datam).year();
	// 		console.log (data);
	// 		if ((datam.isValid()) && (annom > annomin) && (annom < annomax) ) { return true; } else { return false;}
	// 	} else {
	// 		return true;
	// 	}
	// }
	
	function aggiornaAnagrafica (pagina) {
		let img_alu = $('#imgName').val();

		//estraggo tutti i valori da salvare
		let ID_alu = $('#ID_alu_det_hidden').val();
		let nome_alu = $('#nome_alu_det').val();
		let cognome_alu = $('#cognome_alu_det').val();
		let mf_alu = $('#mf_alu_det').val();
		if (img_alu != "") {
			fileName = nome_alu + cognome_alu;
			fileName = fileName.replace(/[\|&;\$%@"<>\(\)\+,]/g, "");
			fileName = fileName.replace ("'", "");
			fileName = fileName.replace (" ", "");
			fileName = fileName.replace ("-", "");
			img_alu = fileName+".png";
		}

		let indirizzo_alu = $('#indirizzo_alu_det').val();
		let citta_alu = $('#citta_alu_det').val();
		let CAP_alu = $('#CAP_alu_det').val();
		let prov_alu = $('#prov_alu_det').val();
		let paese_alu = $('#paese_alu_det').val();
		let cf_alu = $('#cf_alu_det').val();
		let datanascita_alu = $('#datanascita_alu_det').val();
		if (controllaDataNascita(datanascita_alu, 2000, 2050)){
		} else {
			$('#titolo01Msg_OK').html('AGGIORNAMENTO ANAGRAFICA');
			$('#msg01Msg_OK').html("Verificare la data di nascita");
			$('#modal01Msg_OK').modal('show');
			return;
		}
		
		let comunenascita_alu = $('#comunenascita_alu_det').val();
		let provnascita_alu = $('#provnascita_alu_det').val();
		let paesenascita_alu = $('#paesenascita_alu_det').val();
		let cittadinanza_alu = $('#cittadinanza_alu_det').val();
		let note_alu = $('#note_alu_det').val();
		let autfoto_alu = $("#autfoto_alu_det").is(":checked");
		if (autfoto_alu == false) {autfoto_alu = 0;} else {autfoto_alu =1;}
		
		let DSA_alu = $("#DSA_alu_det").is(":checked");
		if (DSA_alu == false) {DSA_alu = 0;} else {DSA_alu =1;}

		let disabilita_alu = $("#disabilita_alu_det").is(":checked");
		if (disabilita_alu == false) {disabilita_alu = 0;} else {disabilita_alu =1;}

		let dettaglidisabilita_alu = $('#dettaglidisabilita_alu_det').val();
		let intestazionefatt_fam =  $('#selectintestazionefatt_fam option:selected').val();


		let nomemadre_fam = $('#nomemadre_fam_det').val();
		let cognomemadre_fam = $('#cognomemadre_fam_det').val();
		let telefonomadre_fam = $('#telefonomadre_fam_det').val();
		let altrotelmadre_fam = $('#altrotelmadre_fam_det').val();
		let emailmadre_fam = $('#emailmadre_fam_det').val();
		let sociomadre = $("#sociomadre_det").is(":checked");
		if (sociomadre == false) {sociomadre = 0;} else {sociomadre =1;}
		
		let nomepadre_fam = $('#nomepadre_fam_det').val();
		let cognomepadre_fam = $('#cognomepadre_fam_det').val();
		let telefonopadre_fam = $('#telefonopadre_fam_det').val();
		let altrotelpadre_fam = $('#altrotelpadre_fam_det').val();
		let emailpadre_fam = $('#emailpadre_fam_det').val();
		let sociopadre = $("#sociopadre_det").is(":checked");
		if (sociopadre == false) {sociopadre = 0;} else {sociopadre =1;}
		let scuolaprimaprovenienza_alu = $("#scuolaprimaprovenienza_alu_det").val();
		let indirizzoscprimaproven_alu = $("#indirizzoscprimaproven_alu_det").val();
		let scuolaprovenienza_alu = $("#scuolaprovenienza_alu_det").val();
		let indirizzoscproven_alu = $("#indirizzoscproven_alu_det").val();
		
		let ckautfoto_alu = $("#ckautfoto_alu_det").is(":checked");
		if (ckautfoto_alu == false) {ckautfoto_alu = 0;} else {ckautfoto_alu =1;}
		let ckautmateriale_alu = $("#ckautmateriale_alu_det").is(":checked");
		if (ckautmateriale_alu == false) {ckautmateriale_alu = 0;} else {ckautmateriale_alu =1;}		
		let ckautuscite_alu = $("#ckautuscite_alu_det").is(":checked");
		if (ckautuscite_alu == false) {ckautuscite_alu = 0;} else {ckautuscite_alu =1;}
		let ckautuscitaautonoma_alu = $("#ckautuscitaautonoma_alu_det").is(":checked");
		if (ckautuscitaautonoma_alu == false) {ckautuscitaautonoma_alu = 0;} else {ckautuscitaautonoma_alu =1;}
		let ckdoposcuola_alu = $("#ckdoposcuola_alu_det").is(":checked");
		if (ckdoposcuola_alu == false) {ckdoposcuola_alu = 0;} else {ckdoposcuola_alu =1;}
		let cktrasportopubblico_alu = $("#cktrasportopubblico_alu_det").is(":checked");
		if (cktrasportopubblico_alu == false) {cktrasportopubblico_alu = 0;} else {cktrasportopubblico_alu =1;}
		let ckmensa_alu = $("#ckmensa_alu_det").is(":checked");
		if (ckmensa_alu == false) {ckmensa_alu = 0;} else {ckmensa_alu =1;}
		let ckreligione_alu = $("#ckreligione_alu_det").is(":checked");
		if (ckreligione_alu == false) {ckreligione_alu = 0;} else {ckreligione_alu =1;}

		let altreligione_alu =  $('#selectaltreligione_alu option:selected').val();

		let datanascitapadre_fam = $('#datanascitapadre_fam_det').val();
		let comunenascitapadre_fam = $('#comunenascitapadre_fam_det').val();
		let provnascitapadre_fam = $('#provnascitapadre_fam_det').val();	
		let paesenascitapadre_fam = $('#paesenascitapadre_fam_det').val();
		let cfpadre_fam = $('#cfpadre_fam_det').val();
		let indirizzopadre_fam = $('#indirizzopadre_fam_det').val();
		let comunepadre_fam = $('#comunepadre_fam_det').val();
		let provpadre_fam = $('#provpadre_fam_det').val();
		let paesepadre_fam = $('#paesepadre_fam_det').val();
		let CAPpadre_fam = $('#CAPpadre_fam_det').val();
		let titolopadre_fam =  $('#titolopadre_fam_det option:selected').val();
		let profpadre_fam = $('#profpadre_fam_det').val();


		let datanascitamadre_fam = $('#datanascitamadre_fam_det').val();
		let comunenascitamadre_fam = $('#comunenascitamadre_fam_det').val();
		let provnascitamadre_fam = $('#provnascitamadre_fam_det').val();	
		let paesenascitamadre_fam = $('#paesenascitamadre_fam_det').val();
		let cfmadre_fam = $('#cfmadre_fam_det').val();
		let indirizzomadre_fam = $('#indirizzomadre_fam_det').val();
		let comunemadre_fam = $('#comunemadre_fam_det').val();
		let provmadre_fam = $('#provmadre_fam_det').val();
		let paesemadre_fam = $('#paesemadre_fam_det').val();
		let CAPmadre_fam = $('#CAPmadre_fam_det').val();
		let titolomadre_fam =  $('#titolomadre_fam_det option:selected').val();
		let profmadre_fam = $('#profmadre_fam_det').val();
		
		let imgpadre_fam = $('#imgNamepadri').val();
		let imgmadre_fam = $('#imgNamemadri').val();

		let notemadre_fam = $('#notemadre_det').val();
		let notepadre_fam = $('#notepadre_det').val();

		let ibanmadre_fam = $('#ibanmadre_fam').val();
		let ibanpadre_fam = $('#ibanpadre_fam').val();

		let rapprmadre_fam = $("#rapprmadre_fam").is(":checked");
		if (rapprmadre_fam == false) {rapprmadre_fam = 0;} else {rapprmadre_fam =1;}
		let rapprpadre_fam = $("#rapprpadre_fam").is(":checked");
		if (rapprpadre_fam == false) {rapprpadre_fam = 0;} else {rapprpadre_fam =1;}
		

		if (imgpadre_fam != "") {
			fileName = nomepadre_fam + cognomepadre_fam;
			fileName = fileName.replace(/[\|&;\$%@"<>\(\)\+,]/g, "");
			fileName = fileName.replace ("'", "");
			fileName = fileName.replace (" ", "");
			fileName = fileName.replace ("-", "");
			imgpadre_fam = fileName+".png";
		}
		if (imgmadre_fam != "") {
			fileName = nomemadre_fam + cognomemadre_fam;
			fileName = fileName.replace(/[\|&;\$%@"<>\(\)\+,]/g, "");
			fileName = fileName.replace ("'", "");
			fileName = fileName.replace (" ", "");
			fileName = fileName.replace ("-", "");
			imgmadre_fam = fileName+".png";
		}


		postData = { ID_alu: ID_alu, nome_alu: nome_alu, cognome_alu: cognome_alu, mf_alu: mf_alu, indirizzo_alu: indirizzo_alu, citta_alu: citta_alu, CAP_alu: CAP_alu, prov_alu: prov_alu, paese_alu: paese_alu, cf_alu: cf_alu, datanascita_alu: datanascita_alu, comunenascita_alu: comunenascita_alu, provnascita_alu: provnascita_alu, paesenascita_alu: paesenascita_alu, cittadinanza_alu: cittadinanza_alu, nomemadre_fam: nomemadre_fam, cognomemadre_fam: cognomemadre_fam, telefonomadre_fam: telefonomadre_fam, altrotelmadre_fam: altrotelmadre_fam, emailmadre_fam: emailmadre_fam, sociomadre: sociomadre, nomepadre_fam: nomepadre_fam, cognomepadre_fam: cognomepadre_fam, telefonopadre_fam: telefonopadre_fam, altrotelpadre_fam: altrotelpadre_fam, emailpadre_fam: emailpadre_fam, sociopadre: sociopadre, note_alu: note_alu, img_alu: img_alu, autfoto_alu: autfoto_alu, disabilita_alu: disabilita_alu, dettaglidisabilita_alu: dettaglidisabilita_alu, DSA_alu: DSA_alu, scuolaprimaprovenienza_alu: scuolaprimaprovenienza_alu, indirizzoscprimaproven_alu: indirizzoscprimaproven_alu, scuolaprovenienza_alu: scuolaprovenienza_alu, indirizzoscproven_alu: indirizzoscproven_alu, ckautfoto_alu: ckautfoto_alu, ckautmateriale_alu: ckautmateriale_alu, ckautuscite_alu: ckautuscite_alu, ckautuscitaautonoma_alu: ckautuscitaautonoma_alu, ckdoposcuola_alu: ckdoposcuola_alu, cktrasportopubblico_alu: cktrasportopubblico_alu, ckmensa_alu: ckmensa_alu, ckreligione_alu: ckreligione_alu, altreligione_alu: altreligione_alu, datanascitapadre_fam: datanascitapadre_fam , comunenascitapadre_fam : comunenascitapadre_fam, provnascitapadre_fam: provnascitapadre_fam, paesenascitapadre_fam: paesenascitapadre_fam, cfpadre_fam:cfpadre_fam, indirizzopadre_fam:indirizzopadre_fam, comunepadre_fam:comunepadre_fam, provpadre_fam:provpadre_fam, paesepadre_fam:paesepadre_fam, CAPpadre_fam:CAPpadre_fam, titolopadre_fam:titolopadre_fam, profpadre_fam:profpadre_fam, datanascitamadre_fam: datanascitamadre_fam , comunenascitamadre_fam : comunenascitamadre_fam, provnascitamadre_fam: provnascitamadre_fam, paesenascitamadre_fam: paesenascitamadre_fam, cfmadre_fam:cfmadre_fam, indirizzomadre_fam:indirizzomadre_fam, comunemadre_fam:comunemadre_fam, provmadre_fam:provmadre_fam, paesemadre_fam:paesemadre_fam, CAPmadre_fam:CAPmadre_fam, titolomadre_fam:titolomadre_fam, profmadre_fam:profmadre_fam, imgpadre_fam: imgpadre_fam, imgmadre_fam: imgmadre_fam, notemadre_fam: notemadre_fam, notepadre_fam: notepadre_fam, intestazionefatt_fam: intestazionefatt_fam, ibanmadre_fam: ibanmadre_fam, ibanpadre_fam: ibanpadre_fam, rapprmadre_fam: rapprmadre_fam, rapprpadre_fam: rapprpadre_fam};
		console.log("06qry_SchedaAlunno.php - AggiornaAnagrafica - postData a 06qry_updateAnagrafica");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "06qry_updateAnagrafica.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				//console.log (data.test);
				$('#alertModificaAnagrafica').html(data.msg);
				$("#alertModificaAnagrafica").show();
				$("#pagtoshow_hidden").val(pagina);
				setTimeout(function(){requery(); }, 1000);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno aggiornaAnagrafica'");      
			}
		});
	}
	
	function MostraModalIscrizione (cosa){
		//ListaDattesaCk non è mai true in quanto era un modo previsto inizialmente di iscrivere in listadattesa: compariva il form di iscrizione con un checkbox ListadattesaCk selezionato. Questa modalità è stata abbandonata tanto che la riga di codice che settava a true questa checkbox è stata commentata.
		//In defintiiva si entra in questa funzione sempre con cosa = "normale" e quindi in uscita da qui ListaDattesaCk = false
		if (cosa=='listaattesa'){ $('#ListaDAttesa').show(); $( "#ListaDAttesaCk" ).prop( "checked", true ); } else {$('#ListaDAttesa').hide(); $( "#ListaDAttesaCk" ).prop( "checked", false );}
		$('#btn_cancelIscrizione').html('Annulla');
		$('#btn_cancelIscrizione').addClass('pull-left');
		$('#btn_OKIscrizione').show();
		$("#pagtoshow_hidden").val("Classi");
		$('#modalAggiungiAnnoScolastico').modal('show');
	}
	
	function showModalCambioSezione (sezione_cla, ID_cla, annoscolastico_cla){
		//ListaDattesaCk non è mai true in quanto era un modo previsto inizialmente di iscrivere in listadattesa: compariva il form di iscrizione con un checkbox ListadattesaCk selezionato. Questa modalità è stata abbandonata tanto che la riga di codice che settava a true questa checkbox è stata commentata.
		//In defintiiva si entra in questa funzione sempre con cosa = "normale" e quindi in uscita da qui ListaDattesaCk = false
		

		select = "<select name='selectCambioSezione'  style='margin-left: 0px'  id='selectCambioSezione'>";
		select = select + "<option value='A' ";
		if (sezione_cla == 'A') {select = select + " selected "}
		select = select + ">A</option>";
		select = select + "<option value='B' ";
		if (sezione_cla == 'B') {select = select + " selected "}
		select = select + ">B</option>";
		select = select + "<option value='C' ";
		if (sezione_cla == 'C') {select = select + " selected "}
		select = select + ">C</option>";
		select = select + "</select>";
		$('#selectSezioneContainer').html(select);

		$('#annoScolasticoCambioSezione').html("per l'a.s. "+annoscolastico_cla)

		$("#btn_OKCambioSezione").attr("onclick","cambioSezione("+ID_cla+", '"+annoscolastico_cla+"');");
		$("#alertCambioSezione").hide();

		$('#btn_cancelCambioSezione').html('Annulla');
		$('#btn_cancelCambioSezione').addClass('pull-left');
		$('#btn_OKCambioSezione').show();
		$("#pagtoshow_hidden").val("Classi");
		$('#modalCambioSezione').modal('show');
	}

	function MostraModalUscita (annoscolastico){
		$('#btn_cancelUscita').html('Annulla');
		$('#btn_cancelUscita').addClass('pull-left');
		$('#btn_OKUscitae').show();
		$("#annoscolasticoUscita").val(annoscolastico);
		$('#modalAggiungiUscitaInCorso').modal('show');
	}

	function MostraModalFratelli (cosa){

		$('#btn_cancelFratelli').html('Annulla');
		$('#btn_cancelFratelli').addClass('pull-left');
		$('#btn_OKFratelli').show();
		$('#modalFratelli').modal('show');
	}
	
	function cambioSezione(ID_cla, annoscolastico_cla) {
		sezione = $('#selectCambioSezione').val();
		let ID_alu = $('#ID_alu_det_hidden').val();
		postData = { ID_cla: ID_cla, sezione: sezione, annoscolastico_cla: annoscolastico_cla, ID_alu: ID_alu} ;
		console.log ("06qry_SchedaAlunno/ funzione cambioSezione - Dati di post a: 06qry_setSezione.php");
		console.log ("postData", postData);
		$.ajax({
			type: 'POST',
			url: "06qry_setSezione.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log (data);
				$("#alertCambioSezione").removeClass('alert-danger');
				$("#alertCambioSezione").addClass('alert-success');
				$("#alertCambioSezione").show();
				$("#remove-contentCambioSezione").slideUp();
				$('#btn_OKCambioSezione').hide();
				$('#btn_cancelCambioSezione').html('Chiudi');
				$('#btn_cancelCambioSezione').removeClass('pull-left');
				//requery();
				$("#pagtoshow_hidden").val("Classi");


			}
		});
	}
	function aggiungiAnnoScolastico() {
		let ListaDAttesa = 			$("#ListaDAttesaCk").is(":checked");
		let ID_alu_cla = 			$('#ID_alu_det_hidden').val();
		let annoscolastico_asc =  	$("#selectannoscolastico_modal").val();
		let classe_cla =  			$("#selectclasse_modal").val();
		let sezione_cla =  			$("#selectsezione_modal").val();
		let bocciato =				$("#bocciato").is(":checked");
		let scalino = 				$("#scalino").is(":checked");


		postData = { ID_alu_cla: ID_alu_cla, annoscolastico_asc: annoscolastico_asc, classe_cla: classe_cla, sezione_cla: sezione_cla, bocciato: bocciato, ListaDAttesa: ListaDAttesa, scalino: scalino};
		console.log ("06qry_SchedaAlunno/ funzione aggiungiAnnoscolastico - Dati di post a: 06_qry_insertAnnoscolastico.php")
		console.log ("postData", postData);
		
		$.ajax({
			type: 'POST',
			url: "06qry_insertAnnoScolastico.php",
			data: postData,
			dataType: 'json',
			success: function(data){
					console.log(data.test);
					$("#alertaggiungiAS").removeClass('alert-success');
					$("#alertaggiungiAS").addClass('alert-danger');
					$('#alertaggiungimsg').html(data.msg);
					// console.log ("06qry_SchedaAlunno/ funzione aggiungiAnnoscolastico: di ritorno da 06_qry_insertAnnoscolastico.php")
					// console.log ("data.test:" + data.msg);
					$("#modalAggiungiAnnoScolastico .alert").show();
				if (data.result == 'OK') {
					$("#alertaggiungiAS").removeClass('alert-danger');
					$("#alertaggiungiAS").addClass('alert-success');
					$("#remove-contentAggiungiAnnoScolastico").slideUp();
					$('#btn_OKIscrizione').hide();
					$('#btn_cancelIscrizione').html('Chiudi');
					$('#btn_cancelIscrizione').removeClass('pull-left');
					//requery();
					$("#pagtoshow_hidden").val("Classi");
				}
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno ##fname##'");      
			}
		});

	}
	
	function aggiornaFamigliaPerAlu(ID_alu, ID_fam_alu, fratelli){
		let cognome = $('#cognome_alu_det').val();
		let nomemadre_fam_new = $('#nomemadre_fam_newF').val();
		let cognomemadre_fam_new = $('#cognomemadre_fam_newF').val();
		let nomepadre_fam_new = $('#nomepadre_fam_newF').val();
		let cognomepadre_fam_new = $('#cognomepadre_fam_newF').val();
		let selectfamigliaTMP = document.getElementById("selectFamigliaF");
		let selectFamiglia = selectfamigliaTMP.options[selectfamigliaTMP.selectedIndex].value;
		postData = { ID_alu : ID_alu, ID_fam_alu: ID_fam_alu, fratelli: fratelli, nomemadre_fam_new: nomemadre_fam_new, cognomemadre_fam_new: cognomemadre_fam_new, nomepadre_fam_new: nomepadre_fam_new, cognomepadre_fam_new: cognomepadre_fam_new, selectFamiglia: selectFamiglia }
		console.log (postData);

		if (cognomepadre_fam_new == '') {
			$("#alertFRATELLI").removeClass('alert-success');
			$("#alertFRATELLI").addClass('alert-danger');
			$("#alertFRATELLI").html('Inserire il cognome del padre - eventualmente selezionando una famiglia esistente');
			$("#alertFRATELLI").show();
			return;
		}

		if (cognomemadre_fam_new == '') {
			$("#alertFRATELLI").removeClass('alert-success');
			$("#alertFRATELLI").addClass('alert-danger');
			$("#alertFRATELLI").html('Inserire il cognome della madre - se non noto inserire xxx');
			$("#alertFRATELLI").show();
			return;
		}

		if (cognomepadre_fam_new != cognome) {
			if ($('#cognome_alunno_padre_uguali').val() != "no") {
				//nel caso di Cittadella non si pone alcun vincolo in questo, invece nel caso di Padova l'impostazione cognome_alunni_padre_uguali = si blocca la procedura a questo livello
				$testo= ("Il cognome del padre non corrisponde a quello dell'alunno.<br>Sebbene questa situazione sia possibile <br> non è raccomandabile per praticità nella consultazione.<br>E' preferibile correggere, ad esempio con un doppio cognome per entrambi,<br>anche se formalmente non esatto.");
				$("#alertFRATELLI").removeClass('alert-success');
				$("#alertFRATELLI").addClass('alert-danger');
				$("#alertFRATELLI").html($testo);
				$("#alertFRATELLI").show();
				return;
			}
		}


		if ($('#cognomepadre_fam_new').val() != cognome) {
			
		}



		


		$.ajax({
			type: 'POST',
			url: "06qry_editFamiglia.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				//mancano spostamenti campi cancel/OK
				$("#alertFRATELLI").removeClass('alert-danger');
				$("#alertFRATELLI").addClass('alert-success');
				$('#alertFRATELLI').html(data.msg);
				$("#alertFRATELLI").show();
				$("#btn_cancelFRATELLI").html('Chiudi');
				$("#btn_cancelFRATELLI").removeClass('pull-left');
				$("#btn_OKFRATELLI").hide();
				$("#remove-contentFRATELLI").slideUp();
				$("#pagtoshow_hidden").val(pagina);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno ##fname##'");      
			}
			
		});

	}
	
	function aggiungiUscitaInCorso() {
		let ID_alu_cla = $('#ID_alu_det_hidden').val();
		let annoscolastico_cla =  $("#annoscolasticoUscita").val();
		let dataUscita_cla =  $("#dataUscita").val();
		postData = { ID_alu_cla: ID_alu_cla, annoscolastico_cla: annoscolastico_cla, dataUscita_cla: dataUscita_cla};
			$.ajax({
			type: 'POST',
			url: "06qry_insertUscitaInCorso.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				document.getElementById('alertUSCITA').innerHTML = data.msg;
				$("#modalAggiungiUscitaInCorso .alert").show();
				if (data.result == 'OK') {$('#btn_OKUscita').hide();
				$('#btn_cancelUscita').html('Chiudi');
				$('#btn_cancelUscita').removeClass('pull-left');}
				$('#modalAggiungiUscitaInCorso').modal('hide');
				$("#pagtoshow_hidden").val("Classi");
				requery();

			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno ##fname##'");     
			}
		});

	}
	
	function showModalDeleteIscrizione(annoscolastico_cla) {
		$('#msg03Msg_OKCancelPsw').html("Siete sicuri di voler cancellare l'iscrizione all'a.s. "+annoscolastico_cla+"?<br>Insieme ad essa verranno eliminate eventuali quote versate, voti ecc.");
		$("#btn_OK03Msg_OKCancelPsw").attr("onclick","deleteAnnoscolastico('"+annoscolastico_cla+"');");
		$("#btn_OK03Msg_OKCancelPsw").show();
		$("#titolo03Msg_OKCancelPsw").html('ELIMINAZIONE ISCRIZIONE ANNO SCOLASTICO');
		$("#btn_cancel03Msg_OKCancelPsw").html('Annulla');
		$("#remove-content03Msg_OKCancelPsw").show();
		$("#alertCont03Msg_OKCancelPsw").removeClass('alert-success');
		$("#alertCont03Msg_OKCancelPsw").addClass('alert-danger');
		$("#alertCont03Msg_OKCancelPsw").hide();
		$("#passwordDelete").val("");
		$('#modal03Msg_OKCancelPsw').modal('show');
	}

	function deleteAnnoscolastico(annoscolastico_cla) {
		let psw = $("#passwordDelete").val();
		let pswOperazioni1 = $("#pswOperazioni1").val();
		if (psw == null || psw == "" || psw !=pswOperazioni1 ) {
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		}	else  {
			let ID_alu_cla = $('#ID_alu_det_hidden').val();
			postData = { ID_alu_cla: ID_alu_cla, annoscolastico_cla: annoscolastico_cla};
			//console.log(postData);
			$.ajax({
			type: 'POST',
			url: "06qry_deleteAnnoScolastico.php",
			data: postData,
			dataType: 'json',
			success: function(){
				$("#remove-content03Msg_OKCancelPsw").slideUp();
				$("#alertMsg03Msg_OKCancelPsw").html('Iscrizione eliminata!');
				$("#alertCont03Msg_OKCancelPsw").removeClass('alert-danger');
				$("#alertCont03Msg_OKCancelPsw").addClass('alert-success');
				$("#alertCont03Msg_OKCancelPsw").show();
				$("#btn_cancel03Msg_OKCancelPsw").html('Chiudi');
				$("#btn_OK03Msg_OKCancelPsw").hide();
				$("#pagtoshow_hidden").val("Classi");
				requery();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno ##fname##'");      
				}
			});
		}
	}
	
	// function controllaData (data) {
	// 	if ((data != "") && (data != null)) {
	// 	let datam = moment(data, "DD-MM-YYYY" );
	// 	let annom = moment(datam).year();
	// 	//console.log ("Funzione controllaData: verifica della data " + data)
	// 	if ((datam.isValid()) && (annom > 2010) && (annom < 2050) ) { return true; } else { return false;}
	// 	} else { return true;}
	// }
	
	function convertForArray (data){
		if (data == "" || data == null) {
			let dateObject1 = new Date("3000", "12", "31");
			return (dateObject1);
		} else {
			let dateParts = data.split("/");
			// month is 0-based, that's why we need dataParts[1] - 1
			let dateObject = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
			return (dateObject);
		}
	
	}
	
	function getFormattedDate(date) {
		let year = date.getFullYear();
		let month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		let day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return day + '/' + month + '/' + year;
	}

	function salvaIterEInserimento(){
		let ID_alu_lda = $('#ID_alu_det_hidden').val();
		let annoscolastico_lda =  $('#selectannoscolastico_lda option:selected').val();
		let classe_lda = $('#selectclasse_lda option:selected').val();
		let sezione_lda = $('#selectsezione_lda option:selected').val();
		let dataStep0 = $('#dataStep00').val();
		let modalita0_lda = $('#selectModalita0_lda option:selected').val();
		let noteFinali = $('#Notefinali').val();
		let accolto = $("input[name='accolto']:checked").val();

		//faccio una serie di verifiche sulle date
		//anzitutto verifico che almeno una sia compilata e corretta
		if (dataStep0 == 0 || !controllaData(dataStep0)) {
			$('#titolo01Msg_OK').html('ITER DI INSERIMENTO');
			$('#msg01Msg_OK').html("Inserire una data valida");
			$('#modal01Msg_OK').modal('show');
			return;
		}

	
		//prima di tutto verifico se è già iscritto per l'anno scolastico per il quale si sta inserendo
		//verifico contestualmente se per caso non sia nella situazione: iscritto in lista d'attesa
		//N.B.: la funzione 06qry_getSituazioneIscrizione.php va a verificare solo in tab_alunniclassi e non in tab_listadattesa
		postDataVer = { ID_alu_lda: ID_alu_lda, annoscolastico_lda: annoscolastico_lda };
		// console.log ("Funzione SalvaIter: Verifica che l'alunno non sia già iscritto");
		// console.log (postDataVer);
		$.ajax({
			type: 'POST',
			url: "06qry_getSituazioneIscrizione.php",
			data: postDataVer,
			dataType: 'json',
			success: function(data){
				//show save successful
				//console.log("06qry_SchedaAlunno - SalvaIter - verifiche varie:")
				// console.log ("giaiscritto : " + data.giaiscritto);
				// console.log ("listaattesa : " + data.listaattesa);
				// console.log ("giaiscrittoaltrianni: " + data.giaiscrittoaltrianni);
				// console.log ("giainaltralistaattesa: " + data.giainaltralistaattesa);
				// console.log ("test: " + data.test);
				if (data.giaiscrittoaltrianni == true) {
					$('#titolo01Msg_OK').html('ITER DI INSERIMENTO');
					$('#msg01Msg_OK').html("Alunno già iscritto in altri anni scolastici!<br>non è possibile inserire informazioni di primo inserimento");
					$('#modal01Msg_OK').modal('show');
					return;
				}
				if (data.giainaltralistaattesa == true) {
					$('#titolo01Msg_OK').html('ITER DI INSERIMENTO');
					$('#msg01Msg_OK').html("Alunno già in lista d'attesa per altri anni scolastici!<br>non è possibile inserire liste d'attesa per più anni");
					$('#modal01Msg_OK').modal('show');
					return;
				}
				if ((data.giaiscritto == true) && (data.listaattesa == false)) {
					//CANCELLO E RIFACCIO MA PREAVVISO
						if (confirm("L'alunno è già iscritto per l'anno selezionato e non si trova in lista d'attesa. Modificare i dati in questa pagina comporta potenzialmente la perdita di altri dati, tipici degli alunni già iscritti (ad esempio quote pagate). Si conferma?")) {
						//DELETE + INSERT
					} else {
						return;
					}
				}
				if ((data.giaiscritto == true) && (data.listaattesa == true)) {
					//DELETE + INSERT
				}
				if ((data.giaiscritto == false)) {
					//INSERT + INSERT
				}
				//se l'alunno è già iscritto tolgo di mezzo l'iscrizione precedente (ho avvisato)
				//devo attendere che l'operazione abbia luogo quindi sarà async:false
				if (data.giaiscritto == true) {
					postData = { ID_alu_cla: ID_alu_lda, annoscolastico_cla: annoscolastico_lda};
						//console.log ("SalvaIter: caso di alunno gia' iscritto: procedo a eliminare l'iscrizione precedente in maniera sincrona: " )
						//console.log (postData);
						$.ajax({
						async:false,
						type: 'POST',
						url: "06qry_deleteAnnoScolastico.php",
						data: postData,
						dataType: 'json',
						success: function(){
							//console.log ("cancellato record da iscrizione in quanto era già iscritto ma in lista d'attesa");
						},
						error: function(){
							alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno 06qry_deleteAnnoScolastico'");      
						}
					});
				}
				//ora SE accolto o in lista d'attesa (quindi non respinto cioè accolto != 2)  vado ad inserire in iscrizione, nel primo caso senza, nel secondo con flag listadattesa_cla
				//userò la 06qryinsertAnnoScolastico in entrambi i casi

				//1=accolto
				//2=non accolto
				//3=in lista d'attesa
				//4=solo in anagrafica
				//se è accolto oppure se è da mettere in lista d'attesa faccio la insert anno scolastico
				if (accolto != 2 && accolto!=4) { 
					if (accolto == 1) { ListaDAttesa = "false"; } else { ListaDAttesa = "true"; }
					let bocciato="false";
					postData = { ID_alu_cla: ID_alu_lda, annoscolastico_asc: annoscolastico_lda, classe_cla: classe_lda, sezione_cla: sezione_lda, bocciato: bocciato, ListaDAttesa: ListaDAttesa};
					$.ajax({
						async:false,
						type: 'POST',
						url: "06qry_insertAnnoScolastico.php",
						data: postData,
						dataType: 'json',
						success: function(data){
							$('#titolo01Msg_OK').html('ITER DI INSERIMENTO');
							$('#msg01Msg_OK').html(data.msg);
							$('#modal01Msg_OK').modal('show');	
						},
						error: function(){
							alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno 06qry_insertAnnoScolastico'");      
						}
					});
				}
			
				//infine mi occupo di tab_listadattesa: 
				//i dati dell'iter (colloqui, date, presenti al colloquio, note  ecc...) vengono infatti salvati in questa tabella
				postData = { ID_alu_lda: ID_alu_lda, annoscolastico_lda: annoscolastico_lda, classe_lda: classe_lda, sezione_lda: sezione_lda, dataStep0: dataStep0, modalita0_lda :modalita0_lda, noteFinali: noteFinali, accolto: accolto};
				// console.log ("06qry_SchedaAlunno.php - SalvaIter: postData a 06qry_insertIter.php");
				// console.log (postData);
				$.ajax({
					async:false,
					type: 'POST',
					url: "06qry_insertIterListaDattesa.php",
					data: postData,
					dataType: 'json',
					success: function(data){
						// console.log ("06qry_SchedaAlunno.php - SalvaIter: ritorno da 06qry_insertIter.php");
						// // console.log ("SalvaIter: query usate in 06_insertIter.php (update o insert a seconda che l'iscrizione ci sia già o meno)");
						//  console.log("query di verifica se c'è gia:" + data.sql);
						//  console.log("ID_lda id record già trovato/se già trovato: " + data.test);
						//  console.log("query di insert o update" + data.sql1);
						//  console.log("incontrocon" + data.test2);
						$("#pagtoshow_hidden").val("ListaDAttesaeInserimento");
						requery();
					},
					error: function(){
						alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno 06qry_insertIter'");      
					}
				});
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno 06qry_getSituazioneIscrizione'");     
			}
		});
	}

	function salvaIter(){
		let ID_alu_lda = $('#ID_alu_det_hidden').val();
		let annoscolastico_lda =  $('#selectannoscolastico_lda option:selected').val();
		let classe_lda = $('#selectclasse_lda option:selected').val();
		let sezione_lda = $('#selectsezione_lda option:selected').val();
		let dataStep0 = $('#dataStep0').val();
		let modalita0_lda = $('#selectModalita0_lda option:selected').val();
		let dataStep1 = $('#dataStep1').val();
		let dataStep2 = $('#dataStep2').val();
		let dataStep3 = $('#dataStep3').val();
		let noteStep1 = $('#NoteStep1').val();
		let noteStep2 = $('#NoteStep2').val();
		let noteStep3 = $('#NoteStep3').val();
		let noteFinali = $('#Notefinali').val();
		let accolto = $("input[name='accolto']:checked").val();
		let incontrocon1 = $('#selectPersonale1').val();
		let incontrocon2 = $('#selectPersonale2').val();
		let incontrocon3 = $('#selectPersonale3').val();

		//faccio una serie di verifiche sulle date
		//anzitutto verifico che almeno una sia compilata
		if (dataStep0 + dataStep1 + dataStep2 + dataStep3 == 0) {
			$('#titolo01Msg_OK').html('ITER DI INSERIMENTO');
			$('#msg01Msg_OK').html("Compilare almeno una delle date");
			$('#modal01Msg_OK').modal('show');
			return;
		}
		//poi verifico che non siano oltre i range prestabiliti nella funzione controlla data
		if ((controllaData(dataStep0)) && (controllaData(dataStep1)) && (controllaData(dataStep2)) && (controllaData(dataStep3))) {
			//nel caso in cui la prima data sia stata omessa e una delle altre compilata vado a scrivere la minore delle altre nella prima data
			if (((dataStep0 == "") || (dataStep0 == null)) && (dataStep1+dataStep2+dataStep3 != 0)) {
				let datesA=[];
				datesA.push(convertForArray (dataStep1));
				datesA.push(convertForArray (dataStep2));
				datesA.push(convertForArray (dataStep3));
				//let maxDate=new Date(Math.max.apply(null,dates));
				let minDate=new Date(Math.min.apply(null,datesA));
				ddmmyyyyDate = getFormattedDate (minDate);
				$('#dataStep0').val(ddmmyyyyDate);
				dataStep0 = ddmmyyyyDate;
			}
		} else {
			$('#titolo01Msg_OK').html('ITER DI INSERIMENTO');
			$('#msg01Msg_OK').html("Verificare le date inserite");
			$('#modal01Msg_OK').modal('show');
			return;
		}
	
		//prima di tutto verifico se è già iscritto per l'anno scolastico per il quale si sta inserendo
		//verifico contestualmente se per caso non sia nella situazione: iscritto in lista d'attesa
		//N.B.: la funzione 06qry_getSituazioneIscrizione.php va a verificare solo in tab_alunniclassi e non in tab_listadattesa
		postDataVer = { ID_alu_lda: ID_alu_lda, annoscolastico_lda: annoscolastico_lda };
		// console.log ("Funzione SalvaIter: Verifica che l'alunno non sia già iscritto");
		// console.log (postDataVer);
		$.ajax({
			type: 'POST',
			url: "06qry_getSituazioneIscrizione.php",
			data: postDataVer,
			dataType: 'json',
			success: function(data){
				//show save successful
				//console.log("06qry_SchedaAlunno - SalvaIter - verifiche varie:")
				// console.log ("giaiscritto : " + data.giaiscritto);
				// console.log ("listaattesa : " + data.listaattesa);
				// console.log ("giaiscrittoaltrianni: " + data.giaiscrittoaltrianni);
				// console.log ("giainaltralistaattesa: " + data.giainaltralistaattesa);
				// console.log ("test: " + data.test);
				if (data.giaiscrittoaltrianni == true) {
					$('#titolo01Msg_OK').html('ITER DI INSERIMENTO');
					$('#msg01Msg_OK').html("Alunno già iscritto in altri anni scolastici!<br>non è possibile inserire informazioni di primo inserimento");
					$('#modal01Msg_OK').modal('show');
					return;
				}
				if (data.giainaltralistaattesa == true) {
					$('#titolo01Msg_OK').html('ITER DI INSERIMENTO');
					$('#msg01Msg_OK').html("Alunno già in lista d'attesa per altri anni scolastici!<br>non è possibile inserire liste d'attesa per più anni");
					$('#modal01Msg_OK').modal('show');
					return;
				}
				if ((data.giaiscritto == true) && (data.listaattesa == false)) {
					//CANCELLO E RIFACCIO MA PREAVVISO
						if (confirm("L'alunno è già iscritto per l'anno selezionato e non si trova in lista d'attesa. Modificare i dati in questa pagina comporta potenzialmente la perdita di altri dati, tipici degli alunni già iscritti (ad esempio quote pagate). Si conferma?")) {
						//DELETE + INSERT
					} else {
						return;
					}
				}
				if ((data.giaiscritto == true) && (data.listaattesa == true)) {
					//DELETE + INSERT
				}
				if ((data.giaiscritto == false)) {
					//INSERT + INSERT
				}
				//se l'alunno è già iscritto tolgo di mezzo l'iscrizione precedente (ho avvisato)
				//devo attendere che l'operazione abbia luogo quindi sarà async:false
				if (data.giaiscritto == true) {
					postData = { ID_alu_cla: ID_alu_lda, annoscolastico_cla: annoscolastico_lda};
						//console.log ("SalvaIter: caso di alunno gia' iscritto: procedo a eliminare l'iscrizione precedente in maniera sincrona: " )
						//console.log (postData);
						$.ajax({
						async:false,
						type: 'POST',
						url: "06qry_deleteAnnoScolastico.php",
						data: postData,
						dataType: 'json',
						success: function(){
							//console.log ("cancellato record da iscrizione in quanto era già iscritto ma in lista d'attesa");
						},
						error: function(){
							alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno 06qry_deleteAnnoScolastico'");      
						}
					});
				}
				//ora SE accolto o in lista d'attesa (quindi non respinto cioè accolto != 2)  vado ad inserire in iscrizione, nel primo caso senza, nel secondo con flag listadattesa_cla
				//userò la 06qryinsertAnnoScolastico in entrambi i casi

				//1=accolto
				//2=non accolto
				//3=in lista d'attesa
				//4=solo in anagrafica
				//se è accolto oppure se è da mettere in lista d'attesa faccio la insert anno scolastico
				if (accolto != 2 && accolto!=4) { 
					if (accolto == 1) { ListaDAttesa = "false"; } else { ListaDAttesa = "true"; }
					let bocciato="false";
					postData = { ID_alu_cla: ID_alu_lda, annoscolastico_asc: annoscolastico_lda, classe_cla: classe_lda, sezione_cla: sezione_lda, bocciato: bocciato, ListaDAttesa: ListaDAttesa};
					$.ajax({
						async:false,
						type: 'POST',
						url: "06qry_insertAnnoScolastico.php",
						data: postData,
						dataType: 'json',
						success: function(data){
							$('#titolo01Msg_OK').html('ITER DI INSERIMENTO');
							$('#msg01Msg_OK').html(data.msg);
							$('#modal01Msg_OK').modal('show');	
						},
						error: function(){
							alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno 06qry_insertAnnoScolastico'");      
						}
					});
				}
			
				//infine mi occupo di tab_listadattesa: 
				//i dati dell'iter (colloqui, date, presenti al colloquio, note  ecc...) vengono infatti salvati in questa tabella
				postData = { ID_alu_lda: ID_alu_lda, annoscolastico_lda: annoscolastico_lda, classe_lda: classe_lda, sezione_lda: sezione_lda, dataStep0: dataStep0, modalita0_lda :modalita0_lda, dataStep1: dataStep1, dataStep2: dataStep2, dataStep3: dataStep3, noteStep1: noteStep1, noteStep2: noteStep2, noteStep3: noteStep3, incontrocon1: incontrocon1, incontrocon2: incontrocon2, incontrocon3: incontrocon3, noteFinali: noteFinali, accolto: accolto};
				// console.log ("06qry_SchedaAlunno.php - SalvaIter: postData a 06qry_insertIter.php");
				// console.log (postData);
				$.ajax({
					async:false,
					type: 'POST',
					url: "06qry_insertIter.php",
					data: postData,
					dataType: 'json',
					success: function(data){
						// console.log ("06qry_SchedaAlunno.php - SalvaIter: ritorno da 06qry_insertIter.php");
						// // console.log ("SalvaIter: query usate in 06_insertIter.php (update o insert a seconda che l'iscrizione ci sia già o meno)");
						//  console.log("query di verifica se c'è gia:" + data.sql);
						//  console.log("ID_lda id record già trovato/se già trovato: " + data.test);
						//  console.log("query di insert o update" + data.sql1);
						//  console.log("incontrocon" + data.test2);
						$("#pagtoshow_hidden").val("ListaDAttesaeInserimento");
						requery();
					},
					error: function(){
						alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno 06qry_insertIter'");      
					}
				});
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno 06qry_getSituazioneIscrizione'");     
			}
		});
	}
	
	function mostraPrimoInserimento () {
		$("#pagtoshow_hidden").val("ListaDAttesaeInserimento");
		requery();
	}
	

	function showModalDeleteIter() {
		$('#titolo02Msg_OKCancel').html('ELIMINA ITER ISCRIZIONE');
		$('#msg02Msg_OKCancel').html("Sei sicuro di voler cancellare questi dati di primo inserimento<br>compresa l'eventuale iscrizione?<br><br>(Operazione irreversibile)");
		$("#btn_OK02Msg_OKCancel").html("Cancella");
		$("#btn_OK02Msg_OKCancel").attr("onclick","deleteIterPrimoInserimento();");
		$('#modal02Msg_OKCancel').modal('show');
	}

	function deleteIterPrimoInserimento () {
		let ID_alu_lda = $('#ID_alu_det_hidden').val();
		let annoscolastico_lda =  $('#selectannoscolastico_lda option:selected').val();
		postData = { ID_alu_cla: ID_alu_lda, annoscolastico_cla: annoscolastico_lda};
			$.ajax({
			type: 'POST',
			url: "06qry_deleteAnnoScolastico.php",
			data: postData,
			dataType: 'json',
			success: function(){
				//console.log ("cancellato record primo inserimento");
				postData1 = { ID_alu_lda: ID_alu_lda};
				$.ajax({
					type: 'POST',
					url: "06qry_deleteListaDAttesa.php",
					data: postData1,
					dataType: 'json',
					success: function(){
						//console.log ("cancellata lista d'attesa");
						$("#pagtoshow_hidden").val("ListaDAttesaeInserimento");
						requery();
					},
					error: function(){
						alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno ##fname##'");      
					}
					
				});
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno ##fname##'");      
			}
		});
	}

	
	$('.search-comune').on("keyup input", function(){
		campo = $(this).attr("name");
		// Get input value on change
		let inputVal = $(this).val();
		switch (campo) {
			case "comunenascita_alu_new":
				resultDropdown = $("#showComuneNascita_new");
			break;
			case "citta_alu_new":
				resultDropdown = $("#showComuneResidenza_new");
			break;
			case "comunenascita_alu_det":
				resultDropdown = $("#showComuneNascita_det");
			break;
			case "citta_alu_det":
				resultDropdown = $("#showComuneResidenza_det");
			break;
			case "comunenascitapadre_fam_det":
				resultDropdown = $("#showComuneNascitaPadre_det");
			break;
			case "comunenascitamadre_fam_det":
				resultDropdown = $("#showComuneNascitaMadre_det");
			break;
			case "comunepadre_fam_det":
				resultDropdown = $("#showComuneResidenzaPadre_det");
			break;
			case "comunemadre_fam_det":
				resultDropdown = $("#showComuneResidenzaMadre_det");
			break;
		
		}
		
		if(inputVal.length>2){
				$.get("06qry_DropDownComune.php", {inputVal: inputVal}).done(function(data){
				// Display the returned data in browser
				resultDropdown.html(data);
				resultDropdown.show();
				});
		} else {
			resultDropdown.empty();
		}
	});
	
	function CopiaResidenza(da,a) {
		if (da == "alu") {
			indirizzoda = $('#indirizzo_alu_det');
			comuneda = $('#citta_alu_det');
			provda = $('#prov_alu_det');
			CAPda = $('#CAP_alu_det');
			paeseda = $('#paese_alu_det');
		}
		if (da == "padre") {
			indirizzoda = $('#indirizzopadre_fam_det');
			comuneda = $('#comunepadre_fam_det');
			provda = $('#provpadre_fam_det');
			CAPda = $('#CAPpadre_fam_det');
			paeseda = $('#paesepadre_fam_det');
		}
		if (da == "madre") {
			indirizzoda = $('#indirizzomadre_fam_det');
			comuneda = $('#comunemadre_fam_det');
			provda = $('#provmadre_fam_det');
			CAPda = $('#CAPmadre_fam_det');
			paeseda = $('#paesemadre_fam_det');
		}
		
		if (a == "alu") {
			indirizzoa = $('#indirizzo_alu_det');
			comunea = $('#citta_alu_det');
			prova = $('#prov_alu_det');
			CAPa = $('#CAP_alu_det');
			paesea = $('#paese_alu_det');
		}
		if (a == "padre") {
			indirizzoa = $('#indirizzopadre_fam_det');
			comunea = $('#comunepadre_fam_det');
			prova = $('#provpadre_fam_det');
			CAPa = $('#CAPpadre_fam_det');
			paesea = $('#paesepadre_fam_det');
		}
		if (a == "madre") {
			indirizzoa = $('#indirizzomadre_fam_det');
			comunea = $('#comunemadre_fam_det');
			prova = $('#provmadre_fam_det');
			CAPa = $('#CAPmadre_fam_det');
			paesea = $('#paesemadre_fam_det');
		}
		
		indirizzoa.val(indirizzoda.val());
		comunea.val(comuneda.val());
		prova.val(provda.val());
		CAPa.val(CAPda.val());
		paesea.val(paeseda.val());
	}
	
	
	function setName(){
		$('#scuolaprovenienza_alu_det').val($('#hidden_nome_scuola').val());
		$('#indirizzoscproven_alu_det').val($('#hidden_indirizzo_scuola').val());
	}
	
	//Viene lanciata al primo caricamento di croppie, o
	//al lancio del form modale
	//serve a caricare nel form modale l'immagine che si trova in database
	function openCroppie(who) {
		$('#hidden_open_who').val(who);
		//ho scritto in questo campo nascosto 'hidden_open_who' se sto gestendo un'immagine di alunno (campo vuoto), di un padre ('padri') o di una madre ('madri')
		imgName = document.getElementById('imgName'+who).value;
		//console.log ('imgName'+imgName);
		$("#imgNameModal").val(imgName);
		if (imgName) {
			let num = Math.random();
			$uploadCrop.croppie('bind', {
			url: 'assets/photos/imgs'+who+'/'+imgName+"?"+num,
			});
		} else {
			$(".cr-image").css("display", "none"); //altrimenti si vede "preview" L'importante è poi rimostrarla quando si fa il caricamento di una nuova immagine
		}
		$('#modalFormCroppie').modal('show');
	}



	// function MostraDettagliDisabilita() {
	// 	// if ($('#disabilita_alu_det').is(':checked')) {
	// 	// 	$('#dettaglidisabilita_alu_det').show();
	// 	// 	$('#titleDettaglidisabilita_alu_det').show();

	// 	// } else {
	// 	// 	$('#dettaglidisabilita_alu_det').hide();
	// 	// 	$('#titleDettaglidisabilita_alu_det').hide();

	// 	// }
	// }

	function checkScalino(ID_cla) {
		let scalino_bool = $("#ckScalino"+ID_cla).is(":checked");
		if (scalino_bool) {scalino_cla = 1;} else {scalino_cla = 0;}
		postData = { ID_cla: ID_cla, scalino_cla: scalino_cla};

		console.log ("06qry_SchedaAlunno.php - checkScalino: postData a 06qry_updateCheckScalino.php");
		console.log (postData);
		$.ajax({
		type: 'POST',
		url: "06qry_updateCheckScalino.php",
		data: postData,
		dataType: 'json',
		success: function(data){
				console.log (data.test);
			}
		});


	}
</script>

