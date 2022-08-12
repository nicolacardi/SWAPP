<?
include_once("database/databaseii.php");
include_once("iscrizioni/diciture.php");
include_once("assets/functions/functions.php");

$ID_alu = $_POST['ID_alu'];
$annoscolastico_cla =  $_POST['annoscolastico_cla'];
$ID_mae = $_POST['ID_mae'];
$activeTab = $_POST['activeTab'];



//Estraggo dati anagrafici, classe, sezione ecc.
//Ed estraggo da tab_classialunni (quelli che non dipendono dalla materia, nè dal tipo di pagella) che sono generali per il quadrimestre
$sql = "SELECT DISTINCT ID_alu, nome_alu, cognome_alu, ID_fam_alu, aselme_cla, classe_cla, sezione_cla, ritirato_cla, dataritiro_cla, sottotiposcuolasucc_alu, ggassenza1_cla, ggassenza2_cla, datapagella1_cla, datapagella2_cla, hafreq_cla, ammesso_cla, giuquad1_cla, giuquad2_cla, votofinale_cla FROM tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla WHERE ID_alu = ? AND annoscolastico_cla = ?;";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "is", $ID_alu, $annoscolastico_cla);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_alu_det, $nome_alu_det, $cognome_alu_det, $ID_fam_alu, $aselme_cla, $classe_cla, $sezione_cla, $ritirato_cla, $dataritiro_cla, $sottotiposcuolasucc_alu, $ggassenza1_cla, $ggassenza2_cla, $datapagella1_cla, $datapagella2_cla, $hafreq_cla, $ammesso_cla, $giuquad1_cla, $giuquad2_cla, $votofinale_cla);
mysqli_stmt_store_result($stmt);
while (mysqli_stmt_fetch($stmt))
{}

//Estraggo da tab_classi il valore 1/0 che indica se il primo quadrimestre va compilato (e mostrato) oppure no
//in verità questo valore andrebbe inserito in tabparametrixanno e non in tab_classi
$sql1 = "SELECT pagprimotrim_cls FROM tab_classi WHERE classe_cls = ?";
$stmt1 = mysqli_prepare($mysqli, $sql1);
mysqli_stmt_bind_param($stmt1, "s", $classe_cla);
mysqli_stmt_execute($stmt1);
mysqli_stmt_bind_result($stmt1, $pagprimotrim_cls);
while (mysqli_stmt_fetch($stmt1))
{}

$asiliorario = $_SESSION['asiliorario'];

//estraggo il tipo di pagella da utilizzare (1 o 2 e il numero di campi che sono da compilare in quel tipo)
$sql4 = "SELECT val_paa, val2_paa, tipovoti_paa, nchar_paa FROM tab_parametrixanno WHERE annoscolastico_paa = ? AND parname_paa = 'tipopagella_" .$aselme_cla."';";
$stmt4 = mysqli_prepare($mysqli, $sql4);
mysqli_stmt_bind_param($stmt4, "s", $annoscolastico_cla);
mysqli_stmt_execute($stmt4);
mysqli_stmt_bind_result($stmt4, $tipopagella, $tipopagella2, $tipovoti, $nchar_paa);
mysqli_stmt_store_result($stmt4);
while (mysqli_stmt_fetch($stmt4)) 
{}

?>

<div class="nomeAlunnoDettaglio">
	<span><? echo($nome_alu_det." ".$cognome_alu_det) ?> </span> 
	<input id="hidden_ID_alu" 			value = "<?=$ID_alu?>" 					hidden>
	<input id="hidden_ID_fam" 			value = "<?=$ID_fam_alu?>" 				hidden>
	<input id="pagtoshow_hidden" 		value = "<?=$activeTab;?>" 				hidden>
	<input id="classe_cla_hidden" 		value = "<?=$classe_cla?>" 				hidden>
	<input id="aselme_cla_hidden" 		value = "<?=$aselme_cla?>" 				hidden>
	<input id="sezione_cla_hidden" 		value = "<?=$sezione_cla?>" 			hidden>
	<input id="ritirato_cla_hidden" 	value = "<?=$ritirato_cla?>" 			hidden>
	<input id="dataritiro_cla_hidden" 	value = "<?=$dataritiro_cla?>" 			hidden>
	<input id="sottotipo_hidden" 		value = "<?=$sottotiposcuolasucc_alu?>" hidden>
	<input id="tipopagella_hidden" 		value = "<?=$tipopagella?>" 			hidden>	<!--Tipo pagella del pulsante sx [al momento 1/6]-->
	<input id="tipopagella2_hidden" 	value = "<?=$tipopagella2?>" 			hidden>	<!--Tipo pagella del pulsante dx [al momento 1/6]-->
	<input id="pswOperazioni1" 			value=	"<?=$_SESSION['pswOperazioni1']?>" 	hidden>
	<input id="nchar" 					value=	"<?=$nchar_paa?>" 				hidden>

	<!--Il "component" colloqui ha bisogno di sapere in quale pagina si trov per usare requery oppure requeryDettaglio-->
	<input id="hidden_page" 			value="IMieiAlunni"						hidden>

</div>



<div class="row" style= "margin-top: 0px;">
	<div id="TabsSchedaIMieiAlunni">
		<ul class="nav nav-tabs ml20 mr20" id="TabsSchedaIMieiAlunniLabels">
			<li class="pull-right" <?if ($classe_cla!='VIII') {echo ("style= 'display:none;'");}?>>
				<a href="#Altro" data-toggle="tab">Altro</a>
			</li>
			<li class="pull-right">
				<a href="#Colloqui" data-toggle="tab">Colloqui</a>
			</li>
			<li class="pull-right" id="liTabAssenze" 
			<?if($asiliorario == 0 && ($aselme_cla == "AS" || $aselme_cla == "NI")) {echo ("style= 'display:none;'");} //riabilitare per togliere di mezzo assenze  asili?>>
				<a href="#Assenze" data-toggle="tab">Assenze</a>
			</li>
			<li class="pull-right"
			<?if ($classe_cla!='VIII') {echo ("style= 'display:none;'");}?>>
				<a href="#ConsOrientativo" data-toggle="tab">C.Orientativo</a>
			</li>
			<li class="pull-right"
			<?if (($classe_cla != 'V') && ($classe_cla!='VIII')) {echo ("style= 'display:none;'");}?>>
				<a href="#CertCompetenze" data-toggle="tab">Cert.Competenze</a>
			</li>
			<li class="pull-right" id="tabQ2"
			<?if($aselme_cla == 'AS'  ) {echo ("style= 'display:none;'");}?>>
				<a href="#Quadrimestre2" data-toggle="tab">2^Quadrimestre</a>
			</li>
			<li class="pull-right" id="tabQ1"
			<?if($aselme_cla == 'AS' || $pagprimotrim_cls == "0") {echo ("style= 'display:none;'");}?>>
				<a href="#Quadrimestre1" data-toggle="tab">1^Quadrimestre</a>
			</li>
			<li class="pull-right">
				<a href="#DatiAnagrafici" id="liTabDatiAnagrafici" data-toggle="tab" class="active">Dati Anagrafici</a>
			</li>
		</ul>
		<div class="tab-content" id="TabsSchedaIMieiAlunniContent">

			
			<?//Tab Dati Anagrafici
			include_once ('02inc_DatiAnagrafici.php');?>

			<?//Tab Pagella di tipo 1: comprende i due pulsanti che rimandano a PagUff e a DocInt
			include_once ('02inc_Pagella.php');?>

			<?//Tab Consiglio Orientativo
			include_once ('02inc_ConsOrientativo.php');?>
			
			<?//Tab Certificazione delle Competenze
			include_once ('02inc_CertCompetenze.php');?>
			
			<?//Tab Assenze
			include_once ('02inc_Assenze.php');?>

			<?//Tab Colloqui
			include_once ('06inc_Colloqui.php');?>


			<!--******************************************* TAB ALTRO *********************************************************-->
			<div class="tab-pane" id="Altro">
				<div class="row"  style="margin: auto; width: 80%; margin-top:50px;border: 1px solid grey; border-radius: 4px;">
					<div class="col-sm-12" style="text-align: center;">
						<h4>Registrazione della Scuola intrapresa dopo l'uscita dalla classe VIII</h4>
					</div>
					<div class="col-sm-12" style="text-align: center; margin-top: 20px;">
						Tipo di Scuola Superiore scelto
					</div>
					<div class="col-sm-12" style="text-align: center;">
						<select  id ="selectTipo"  onchange="aggiornaSottotipi();">
							<option value="-">-</option>
							<option value="nessuna">nessuna</option>
							<? $sql4 = "SELECT DISTINCT tiposcuola_scu FROM tab_scuole";
							$stmt4 = mysqli_prepare($mysqli, $sql4);
							mysqli_stmt_execute($stmt4);
							mysqli_stmt_bind_result($stmt4, $tiposcuola_scu);
							while (mysqli_stmt_fetch($stmt4)) {
							?> <option value="<?=$tiposcuola_scu?>" <? if($tiposcuolasucc_alu==$tiposcuola_scu) {echo ('selected');}?> ><?=$tiposcuola_scu?></option><?
							}?>
						</select>
					</div>
					<div class="col-sm-12" style="text-align: center;">
						Sotto-Tipo
					</div>
					<div class="col-sm-12" style="text-align: center;">
						<div id="selectSottotipoContainer" class="col-sm-12" style="text-align: center;">
							<select id="selectSottoTipo"  style="margin-left: 0px" >
								<option value="0">-</option>
							</select>
						</div>
					</div>
					<div class="col-sm-12" style="text-align: center;">
						Nome della Scuola
					</div>
					<div class="col-sm-12" style="text-align: center;">
						<input class="tablecell3" style="width: 50%; text-align: center" id="nomeScuola" type="text" value ="<?=$nomescuolasucc_alu?>">
					</div>
					<div class="col-sm-12" style="text-align: center;">
						Voto Licenza Media Conseguito
					</div>
					<div class="col-sm-12" style="text-align: center;">
						<input class="tablecell3" style="width: 10%; text-align: center" id="votoLicenzaMedia" type="text" value ="<?=$votoesamiVIII_alu?>">
					</div>
					<div class="col-sm-12" style="text-align: center; margin-top: 20px; margin-bottom: 20px;">
						<button class="btnBlu w100px" onclick="salvaAltro();">Salva</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>






<!--***************************************FORM MODALE SALVATAGGIO PAGELLA **************************************************-->
<div class="modal" id="modalSalvaPagella" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="font-size:14px; width: 40%">
		<div class="modal-content">
			<div class="modal-body white">           
				<form id="form_SalvaPagella" method="post">
					
					<div id="remove-contentSalvaPagella" style="text-align: center;"> <!-- START REMOVE CONTENT -->
					<input type="text" id ="modalQ" hidden>
						<!--Calcolo quanti giorni di assenza sono stati fatti nei due quadrimestri-->
						<?
						$sql5 = "SELECT ggassenza1_cla, ggassenza2_cla FROM tab_classialunni WHERE ID_alu_cla = ? AND annoscolastico_cla = ?";
						$stmt5 = mysqli_prepare($mysqli, $sql5);
						mysqli_stmt_bind_param($stmt5, "is", $ID_alu, $annoscolastico_cla);
						mysqli_stmt_execute($stmt5);
						mysqli_stmt_bind_result($stmt5, $ggassenza1_cla, $ggassenza2_cla);
						mysqli_stmt_store_result($stmt5);
						while (mysqli_stmt_fetch($stmt5)) {
						}

						//trovo le date di inizio e fine di ciascun quadrimestre
						$sql = "SELECT datainizio_asc, datafinequadrimestre1_asc, datafine_asc FROM tab_anniscolastici WHERE annoscolastico_asc = ?";
						$stmt = mysqli_prepare($mysqli, $sql);
						mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_bind_result($stmt, $datainizio_asc, $datafinequadrimestre1_asc, $datafine_asc);
						mysqli_stmt_store_result($stmt);
						while (mysqli_stmt_fetch($stmt)) {
						}
						
						//estraggo le date di assenza (DISTINCT) di ID_alu nel primo Quadrimestre
						$sql = "SELECT DISTINCT data_ass FROM tab_assenze WHERE tipo_ass = 0 AND ID_alu_ass = ? AND (data_ass >= ? AND data_ass <= ?) ORDER BY data_ass";
						$stmt = mysqli_prepare($mysqli, $sql);
						mysqli_stmt_bind_param($stmt, "iss", $ID_alu, $datainizio_asc, $datafinequadrimestre1_asc);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_bind_result($stmt, $data_ass);
						mysqli_stmt_store_result($stmt);
						$contagiornicompleti1 = 0;
						//data per data in cui ci sono state assenze verifico se è stato assente per tutto il giorno ed in quel caso sommo al numero di assenze
						while (mysqli_stmt_fetch($stmt)) {
							//conto le ore di lezione del giorno nella classe
							$sql2 = "SELECT COUNT(ID_ora) AS contaoredilezione FROM tab_orario WHERE classe_ora = ? AND data_ora = ? AND secondomaestro_ora <> 1";
							$stmt2 = mysqli_prepare($mysqli, $sql2);
							mysqli_stmt_bind_param($stmt2, "ss", $classe_cla, $data_ass);
							mysqli_stmt_execute($stmt2);
							mysqli_stmt_bind_result($stmt2, $contaoredilezione);
							while (mysqli_stmt_fetch($stmt2)) {
							}
							//conto le ore di assenza dell'alunno nella data
							$sql2 = "SELECT COUNT(ID_ass) AS contaoreassenzagiorno FROM tab_assenze WHERE tipo_ass = 0 AND ID_alu_ass = ? AND data_ass = ?";
							$stmt2 = mysqli_prepare($mysqli, $sql2);
							mysqli_stmt_bind_param($stmt2, "is", $ID_alu, $data_ass);
							mysqli_stmt_execute($stmt2);
							mysqli_stmt_bind_result($stmt2, $contaoreassenzagiorno);
							while (mysqli_stmt_fetch($stmt2)) {
							}
							if ($contaoreassenzagiorno >= $contaoredilezione) {
								$contagiornicompleti1++;
							}
						}
													
						//estraggo le date di assenza (DISTINCT) di ID_alu nel secondo Quadrimestre
						$sql1 = "SELECT DISTINCT data_ass FROM tab_assenze WHERE tipo_ass = 0 AND ID_alu_ass = ? AND (data_ass > ? AND data_ass < ?) ORDER BY data_ass";
						$stmt1 = mysqli_prepare($mysqli, $sql1);
						mysqli_stmt_bind_param($stmt1, "iss", $ID_alu, $datainizio_asc, $datafine_asc);
						mysqli_stmt_execute($stmt1);
						mysqli_stmt_bind_result($stmt1, $data_ass);
						mysqli_stmt_store_result($stmt1);
						$contagiornicompleti2 = 0;

						//data per data in cui ci sono state assenze verifico se è stato assente per tutto il giorno ed in quel caso sommo al numero di assenze
						while (mysqli_stmt_fetch($stmt1)) {
							//conto le ore di lezione del giorno nella classe
							$sql2 = "SELECT COUNT(ID_ora) AS contaoredilezione FROM tab_orario WHERE classe_ora = ? AND data_ora = ? AND secondomaestro_ora <> 1";
							$stmt2 = mysqli_prepare($mysqli, $sql2);
							mysqli_stmt_bind_param($stmt2, "ss", $classe_cla, $data_ass);
							mysqli_stmt_execute($stmt2);
							mysqli_stmt_bind_result($stmt2, $contaoredilezione);
							while (mysqli_stmt_fetch($stmt2)) {
							}
							$sql2 = "SELECT COUNT(ID_ass) AS contaoreassenzagiorno FROM tab_assenze WHERE tipo_ass = 0 AND ID_alu_ass = ? AND data_ass = ? ";
							$stmt2 = mysqli_prepare($mysqli, $sql2);
							mysqli_stmt_bind_param($stmt2, "is", $ID_alu, $data_ass);
							mysqli_stmt_execute($stmt2);
							mysqli_stmt_bind_result($stmt2, $contaoreassenzagiorno);
							while (mysqli_stmt_fetch($stmt2)) {
							}
							if ($contaoreassenzagiorno >= $contaoredilezione) {
								$contagiornicompleti2++;
							}
						}
						
						//contagiornicompleti 1 e 2 contengono ora il numero di date per le quali ci sono tante ore di assenza per ID_alu nel Quadrimestre quante le ore di lezione nel giorno : NB: le ore di lezione (ed anche le assenze) comprendono anche le ore con 'nom' in quanto stranamente quando metto le assenze registro una assenza ANCHE in quell'ora. Non è corretto a rigore: bisognerebbe segnare ore di assenza SOLO per le ore che non sono 'nom', ma le due SQL qui sopra sono comunque coerenti tra loro (entrambe includono le 'nom') quindi alla fine il calcolo delle assenze viene corretto.
						?>
						
						<div id="modalQ1">
						
							<span class="titoloModal">Salvataggio pagella intermedia</span>
							<div style="margin-top: 10px; margin-bottom: 10px;">
								<?="(".$nome_alu_det." ".$cognome_alu_det.")";?>
							</div>
							<div style="text-align: center;">
								data che comparirà sulla pagella
							</div>
							<div>
								<input class="datepicker tablecell6 dpd" id="dataPagella1" type="text" style="width: 85px;" value="<?
								if ( $datapagella1_cla == "1900-01-01" || $datapagella1_cla == "0000-00-00") {
									echo(Date("d/m/Y"));
								} else {
									echo (timestamp_to_ggmmaaaa($datapagella1_cla));
								} ?>" />
							</div>
							<div style="text-align: center; margin-top: 20px;">
								Giorni COMPLETI di assenza Primo Quadrimestre
							</div>
							<div class="row">
								<div class="col-md-3 col-md-offset-2">
									<div style="text-align: center; margin-top: 20px;">
										calcolati da SWAPP
									</div>
									<div>
										<input class="tablecell6" type="text" id ="gga1" style="text-align: center;width: 80px;"  value = "<? echo ($contagiornicompleti1); ?>" maxlength="2" readonly>
									</div>
								</div>
								<div class="col-md-2">
									<button class="btnBlu" style="text-align: center; margin-top: 30px;" onclick="copiaGGAssenza(event, 1);">
										> > >
									</button>
								</div>
								<div class="col-md-3">
									<div style="text-align: center; margin-top: 20px;">
										mostrati in Pagella
									</div>
									<div>
										<input class="tablecell6" type="text" id ="gga1x" style="text-align: center;width: 80px;"  value = "<?=$ggassenza1_cla?>" maxlength="2">
									</div>
								</div>
							</div>


						</div>
						<div id="modalQ2">

							<span class="titoloModal">Salvataggio pagella finale</span>
							<div style="margin-top: 10px; margin-bottom: 10px;">
								<?="(".$nome_alu_det." ".$cognome_alu_det.")";?>
							</div>
							<div>
								L'alunno ha frequentato più di 3/4 dei giorni di lezione 
								<input id="hafreq_cla" type="checkbox" <? if ($hafreq_cla ==  1) { echo ('checked'); }?> />
							</div>
							<div style="margin-top: 20px;">
								L'alunno è ammesso <input id="ammesso_cla" type="checkbox" <? if ($ammesso_cla ==  1) { echo ('checked'); }?> /><br>
								<span style="font-size: 11px;">'alla classe successiva'<br> o 'al successivo grado di istruzione' (cl. V)<br>o 'agli esami di stato' (cl. VIII)</span>
								
							</div>
							<div style="<? if ($classe_cla != "VIII") {	echo "display:none;";}?> text-align: center; margin-top: 20px; ">
								Voto di ammissione agli esami di Terza Media in decimi

								<?if ($_SESSION['stampa_voti_ammissione_VIII'] == 0) {echo("<br><span style='font-size:10px'>(La stampa del voto di ammissione è stata inibita)</span>");}?>
							</div>
							<div>
								<input class="tablecell6 votcell" type="text" id ="votofinale_cla" style="<? if ($classe_cla != "VIII") {	echo "display:none;";}?> text-align: center;width: 80px;"  value = "<? echo ($votofinale_cla); ?>" maxlength="2">
							</div>
							
							<div style="text-align: center; margin-top: 20px; ">
								data che comparirà sulla pagella
							</div>
							<div>
								<input class="datepicker tablecell6 dpd" id="dataPagella2" type="text" style="width: 85px;" value="<?
							if ( $datapagella2_cla == "1900-01-01" || $datapagella2_cla == "0000-00-00") {
									echo(Date("d/m/Y"));
								} else {
									echo (timestamp_to_ggmmaaaa($datapagella2_cla));
								} ?>" />
							</div>
							<div style="text-align: center; margin-top: 20px;">
								Giorni COMPLETI di assenza da inizio anno
							</div>
							<div class="row">
								<div class="col-md-3 col-md-offset-2">
									<div style="text-align: center; margin-top: 20px;">
										calcolati da SWAPP
									</div>
									<div>
										<input class="tablecell6" type="text" id ="gga2" style="text-align: center;width: 80px;"  value = "<? echo ($contagiornicompleti2); ?>" maxlength="2" readonly>
									</div>
								</div>
								<div class="col-md-2">
									<button class="btnBlu" style="text-align: center; margin-top: 30px;" onclick="copiaGGAssenza(event, 2);">
										> > >
									</button>
								</div>
								<div class="col-md-3">
									<div style="text-align: center; margin-top: 20px;">
										mostrati in Pagella
									</div>
									<div>
										<input class="tablecell6" type="text" id ="gga2x" style="text-align: center;width: 80px;"  value = "<?=$ggassenza2_cla?>" maxlength="2">
									</div>
								</div>
							</div>
						</div>
					</div> <!-- END REMOVE CONTENT -->
					<div class="alert alert-success" id="alertaggiungiSalvaPagella" style="display:none; margin-top:10px;">
						<h4 id="alertmsgSalvaPagella" style="text-align:center;"> 
							Salvataggio Pagella effettuato con successo!
						</h4>
					</div>
					<div class="modal-footer" >
						<button type="button" id="btn_cancelSalvaPagella" class="btnBlu pull-left" style="width:25%;" data-dismiss="modal" >Annulla</button>
						<button type="button" id="btn_OKSalvaPagella" class="btnBlu pull-right" style="width:25%;" >Procedi</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!--*************************************** FINE FORM MODALE SALVATAGGIO PAGELLA  **************************************************-->

<!--***************************************FORM MODALE SALVATAGGIO CONS ORIENTATIVO **************************************************-->
	<div class="modal" id="modalSalvaConOri" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 40%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_ConOri" method="post">
						<div id="remove-contentSalvaConOri" style="text-align: center;"> <!-- START REMOVE CONTENT -->
							<span class="titoloModal">Salvataggio Consiglio Orientativo</span>
							<div style="margin-top: 10px; margin-bottom: 10px;">
								<?="(".$nome_alu_det." ".$cognome_alu_det.")";?>
							</div>
							<div style="text-align: center;">
								data che comparirà sul documento
							</div>
							<div>
								<input class="datepicker tablecell6 dpd" id="data_cor" type="text" style="width: 85px;" value="<?
								if ( $data_cor == "1900-01-01" || $data_cor == "0000-00-00" || $data_cor == "1970-01-01" || $data_cor == "") {
									echo(Date("d/m/Y"));
								} else {
									echo (timestamp_to_ggmmaaaa($data_cor));
								} ?>" />
							</div>
							
						</div> <!-- END REMOVE CONTENT -->
						<div class="alert alert-success" id="alertaggiungiSalvaConOri" style="display:none; margin-top:10px;">
							<h4 id="alertmsgConOri" style="text-align:center;"> 
								Salvataggio Pagella effettuato con successo!
							</h4>
						</div>
						<div class="modal-footer" >
							<button type="button" id="btn_cancelSalvaConOri" class="btnBlu pull-left" style="width:25%;" data-dismiss="modal" >Annulla</button>
							<button type="button" id="btn_OKSalvaConOri" class="btnBlu pull-right" style="width:25%;" data-dismiss="modal">Procedi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!--*************************************** FINE FORM MODALE SALVATAGGIO CONS ORIENTATIVO  **************************************************-->


<!--***************************************FORM MODALE COSTRUZIONE GIUDIZIO **************************************************-->
<div class="modal" id="modalEditGiudizio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="font-size:14px; width: 40%">
		<div class="modal-content">
			<div class="modal-body white">           
				<form id="form_CostruzioneGiudizio" method="post">
					<div style="margin: 10px 0px 20px; font-size: 20px;">
						Costruzione Guidata del Giudizio
					</div>
					<input type="text" id="inputchiamante" hidden>
					<div id="remove-contentEG" style="text-align: center;"> <!-- START REMOVE CONTENT -->
						
					</div> <!-- END REMOVE CONTENT -->
					<!-- <div class="alert alert-success" id="alertaggiungiEG" style="display:none; margin-top:10px;">
						<h4 id="alertmsg" style="text-align:center;"> 
							Costruzione Giudizio
						</h4>
					</div> -->
					<div class="modal-footer" >
						<button type="button" id="btn_cancelEditGiudizio" class="btnBlu pull-left" style="width:25%;" data-dismiss="modal">Annulla</button>
						<button type="button" id="btn_OKEditGiudizio" class="btnBlu pull-right" style="width:25%;" onclick="portaGiudizioAlDoc();">Applica</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!--*************************************** FINE FORM MODALE EDIT GIUDIZIO **************************************************-->
<script>
	
	$('.votcell').keyup(function () {
		let $this = $(this);
		if (($this.val() < 0 || $this.val() > 10) && $this.val().length != 0) {
			if ($this.val() < 1) {
				$this.val(1);
			}
			if ($this.val() > 10) {
				$this.val(10);
			}
		}
	});
	
	
	$('.votcell').keypress(function(e) {
		let a = [];
		let k = e.which;
		for (i = 48; i < 58; i++){
			a.push(i);
		}
		a.push(45); //aggiungo all'array dei codici anche il codice che corrisponde a '-' per consentire di indicare un "non voto"
		if ((a.indexOf(k)) == -1) {
			e.preventDefault();
		}
	});
	

    $(".votcellgiu").keypress(function(e){
        let inputValue = event.which;
        // 71 = G, 73 = I, 83 = S, 66 = B, 68 = D, 79 = O
		if((inputValue != 71) && (inputValue != 73) && (inputValue != 83) && (inputValue != 66) && (inputValue != 68) && (inputValue != 79)){ 
            e.preventDefault(); 
        }
    });


	//let mySessionVar ='<%=Session["name"]%>' Per estrarre una variabile di sessione
	$(document).ready(function(){
		//Funzione per "generare" il datetimepicker
		$('.dpd').datetimepicker({
			pickTime: false, 
			format: "DD/MM/YYYY"
		});
		let pagtoshow = $("#pagtoshow_hidden").val();
		if (pagtoshow == "") {pagtoshow = "#DatiAnagrafici";}
		$("#TabsSchedaIMieiAlunni a[href='"+pagtoshow+"']").tab('show');
		//*******Per Tab Assenze****
		moment.locale('en', {
		  week: { dow: 1 } // Monday is the first day of the week
		});
	  //Initialize the datePicker(I have taken format as mm-dd-yyyy, you can     //have your owh)
		$("#weeklyDatePicker").datetimepicker({
			
			  pickTime: false, 
			  format: 'YYYY-MM-DD'
		});
		let todayDate = new Date().toISOString().slice(0,10);
		$("#weeklyDatePicker").val(todayDate);
	   //Get the value of Start and End of Week
		setdates();
		//*******Fine per Tab Assenze****
		aggiornaSottotipi();
	});
	
	function setdates () {
		let value = $("#weeklyDatePicker").val();
		let firstDate = moment(value, "YYYY-MM-DD").day(1).format("YYYY-MM-DD");
		let firstDateShow = moment(value, "YYYY-MM-DD").day(1).format("DD/MM/YYYY");
		$("#data1").val(firstDate);
		$("#data1Show").val(firstDateShow);
		let date = new Date(firstDate);
		for (i = 2; i < 6; i++) {
			date.setDate(date.getDate() + 1);
			datePublish = date.toISOString().slice(0,10);
			datePublishShow = moment(datePublish).format("DD/MM/YYYY");
			$("#data"+i).val(datePublish);
			$("#data"+i+"Show").val(datePublishShow);
		}
		let m = moment(firstDate, 'YYYY-MM-DD');
		let settimana = m.format('W');
		$("#weeklyDatePicker").val("settimana: "+settimana);
		//console.log (lastDate);
		requeryAssenze();
	}
	
	$('#weeklyDatePicker').on('dp.change', function () {
		setdates();
	});
	
	function requeryAssenze(){
		let ID_mae_ora = $("#hidden_ID_mae").val();
		let ID_alu_ora = $("#hidden_ID_alu").val();
		let datalunedi = $( "#data1" ).val();
		//serve anche dare in input la classe!!! cio' che non serviva in 11IlMioRegistro
		let classe_ora = $( "#classe_cla_hidden" ).val();
		let sezione_ora = $( "#sezione_cla_hidden" ).val();
		let ritirato_cla = $( "#ritirato_cla_hidden" ).val();
		let dataritiro_cla = $( "#dataritiro_cla_hidden" ).val();
		postData = { datalunedi: datalunedi, ID_mae_ora: ID_mae_ora, ID_alu_ora: ID_alu_ora, classe_ora: classe_ora, sezione_ora: sezione_ora, ritirato_cla: ritirato_cla, dataritiro_cla: dataritiro_cla};
		$.ajax({
			type: 'POST',
			url: "02qry_AssenzeRegistro.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintableAssenze").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02det_IMieiAlunni ##fname##'");      
			}
		});
	}
	
	function showModalSalvaPagella(quadrimestre, tipopagella) {
		$("#remove-contentSalvaPagella").show();
		$("#alertaggiungiSalvaPagella").hide();
		$("#btn_cancelSalvaPagella").html('Annulla');
		$("#btn_OKSalvaPagella").show();
		$('#btn_cancelSalvaPagella').addClass("pull-left");
		$("#btn_cancelSalvaPagella").attr("onclick","");
		$('#modalQ').val(quadrimestre);
		if (quadrimestre == "1") {
			$('#modalQ1').show();
			$('#modalQ2').hide();
		} else {
			$('#modalQ1').hide();
			$('#modalQ2').show();	
		}
		$("#btn_OKSalvaPagella").attr("onclick","salvaVoti("+quadrimestre+", "+tipopagella+")");
		$('#modalSalvaPagella').modal({show: 'true'});
	}
	
	function showModalSalvaConOri(event) {

		event.preventDefault();

		$("#remove-contentSalvaConOri").show();
		$("#alertaggiungiSalvaConOri").hide();
		$("#btn_cancelSalvaConOri").html('Annulla');
		$("#btn_OKSalvaConOri").show();
		$('#btn_cancelSalvaConOri').addClass("pull-left");
		$("#btn_cancelSalvaConOri").attr("onclick","");
		$("#btn_OKSalvaConOri").attr("onclick","salvaConOri()");
		$('#modalSalvaConOri').modal({show: 'true'});

	}

	function ricarica() {
		let ID_alu_cla = $('#hidden_ID_alu').val();
		requeryDettaglio(ID_alu_cla);
		coloraRighe(ID_alu_cla);
	}
	
	function salvaVoti(quadrimestre, tipopagella) {
		//ogni volta che viene salvata la pagella viene resettata la variabile che impedisce la chiusura accidentale valorizzandola a true
		consentiRunAway = true;

		//questa funzione viene attribuita al pulsante btn_OKSalvaPagella del form modale che compare cliccando sul pulsante Salva Voti 1^ o 2^ Quadr.
		//gli vengono passati due parametri, uno è il quadrimestre, l'altro il tipo di pagella
		let ID_alu_cla = $('#hidden_ID_alu').val();
		let classe_cla = $('#classe_cla_hidden').val();
		let sezione_cla = $('#sezione_cla_hidden').val();
		let aselme_cla = $('#aselme_cla_hidden').val();
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		let ggassenza_cla = $('#gga'+quadrimestre+'x').val();
		let datapagella_cla = $('#dataPagella'+quadrimestre).val();
		let giuquad_cla = $('#giuquad'+quadrimestre+'_cla_'+tipopagella).val(); //il suffisso tipopagella dice se pescare nella tab del tipo 1 o del tipo 2
		giuquad_cla = JSON.stringify(String(giuquad_cla));
		giuquad_cla = giuquad_cla.substring(1, giuquad_cla.length-1);
		if ($('#hafreq_cla').prop('checked')) { hafreq_cla = 1; } else {hafreq_cla = 0; }
		if ($('#ammesso_cla').prop('checked')) { ammesso_cla = 1; } else {ammesso_cla = 0; }
		let votofinale_cla = $('#votofinale_cla').val();
		
		let nmaterie = $('#numeromaterie_hidden_'+tipopagella).val(); //il suffisso tipopagella dice se pescare nella tab del tipo 1 o del tipo 2
		
		// console.log ('01AnagraficaPerAnno.php - salvaVoti')
		// console.log("numero materie: "+nmaterie);
		//Se asilo, elementari, medie, cambia il numero di materie
		for (materia = 0; materia < (nmaterie); materia++) {
			//viene fatto UN POST PER OGNI VOTO!
			let codmat_cla = $('#mat_'+materia+"_"+tipopagella).val(); //questo è il nome della materia
			let vot_cla = $('#vot'+quadrimestre+'_'+materia+'_'+tipopagella).val();
			let giu_cla = $('#giu'+quadrimestre+'_'+materia+'_'+tipopagella).val();
			giu_cla = JSON.stringify(String(giu_cla));
			giu_cla = giu_cla.substring(1, giu_cla.length-1);
			let commento_cla = $('#com'+quadrimestre+'_'+materia+'_'+tipopagella).val();
			postData = { quadrimestre: quadrimestre, ID_alu_cla: ID_alu_cla, annoscolastico_cla: annoscolastico_cla, codmat_cla: codmat_cla, vot_cla: vot_cla, giu_cla: giu_cla, commento_cla: commento_cla, ggassenza_cla: ggassenza_cla, datapagella_cla: datapagella_cla, hafreq_cla: hafreq_cla, votofinale_cla: votofinale_cla, ammesso_cla: ammesso_cla, giuquad_cla: giuquad_cla, classe_cla: classe_cla, sezione_cla: sezione_cla, aselme_cla: aselme_cla};
			//console.log ("02det_IMieiAlunni.php - SalvaVoti - postData a 02qry_updateVoti.php ");
			//console.log(postData);

			$.ajax({
				type: 'POST',
				url: "02qry_updateVoti.php",
				data: postData,
				async: false,
				dataType: 'json',
				success: function(data){
					$("#remove-contentSalvaPagella").slideUp();
					$('#btn_cancelSalvaPagella').removeClass("pull-left");
					$("#alertmsgSalvaPagella").html('Salvataggio pagella completato con successo!');
					$("#alertaggiungiSalvaPagella").show();
					$("#btn_cancelSalvaPagella").html('Chiudi');
					$("#btn_OKSalvaPagella").hide();
					$("#btn_cancelSalvaPagella").attr("onclick","ricarica()");
					

					// console.log ("02det_IMieiAlunni.php - SalvaVoti - ritorno da 02qry_updateVoti.php ");
					// console.log(data.test);

					if (materia == nmaterie -1) {
						//requeryDettaglio(ID_alu_cla);
						requery();
						//$('#button_'+ID_alu_cla).trigger('click');
						//console.log('#button_'+ID_alu_cla);
					};
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '02det_IMieiAlunni ##fname##'");      
				}
			});
		}
		//requeryDettaglio(ID_alu_cla);
	}
	
	function salvaCert(ID_alu_cer, annoscolastico_cer, classe, sezione) {
		//let ID_alu_cer = $('#hidden_ID_alu').val();
		//let annoscolastico_cer = $( "#selectannoscolastico option:selected" ).val();
		Compilati = 0;
		for (certN = 1; certN <= 11; certN++) {
			let codmat_cer = $('#selectVotoCert'+certN).attr("name");
			let certVal = $('#selectVotoCert'+certN).val();
			if (certVal != 0) {Compilati++}
			//console.log (certVal);
			postData = { ID_alu_cer: ID_alu_cer, annoscolastico_cer: annoscolastico_cer, classe: classe, sezione: sezione, codmat_cer: codmat_cer, certVal: certVal};
			//console.log ("02det_IMieiAlunni.php - salvaCert - postData a 02qry_updateCert.php")
			//console.log (postData);
			$.ajax({
				async: false,
				type: 'POST',
				url: "02qry_updateCert.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					//console.log ("02det_IMieiAlunni.php - salvaCert - ritorno da 02qry_updateCert.php")
					//console.log (data.test);
					//console.log (Compilati);
					if (certN == 11) {
						//console.log ("ultimo");
						//console.log (Compilati);
						if (Compilati != 11) {
							$('#titolo01Msg_OK').html('CERTIFICAZIONE DELLE COMPETENZE');
							$('#msg01Msg_OK').html("Manca qualche informazione<br>tutte le valutazioni devono essere specificate<br><br>Il documento verrà salvato comunque ma risulta incompleto.");
							$('#modal01Msg_OK').modal('show');
						} else {
							$('#titolo01Msg_OK').html('CERTIFICAZIONE DELLE COMPETENZE');
							$('#msg01Msg_OK').html("Documento Completo<br><br>Salvataggio Effettuato");
							$('#modal01Msg_OK').modal('show');
						}
					}
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '02det_IMieiAlunni ##fname##'");      
				}
			});
		}
	}
	




	function salvaConOri() {
		$('#modalSalvaConOri').modal({show: 'false'});
		let ID_alu = $('#hidden_ID_alu').val();
		let annoscolastico = $( "#selectannoscolastico option:selected" ).val();
		let data_cor = $('#data_cor').val();

		let postData = $("#form_ConsOrientativo").serializeArray();

		postData.push( {name: "ID_alu_cor", value: ID_alu});
		postData.push( {name: "annoscolastico_cor", value: annoscolastico});
		postData.push( {name: "data_cor", value: data_cor});

		console.log ("02det_IMieiAlunni.php - salvaConOri - postData a 02qry_updateCons.php")
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "02qry_updateCons.php",
			data: postData,
			dataType: 'json',
			success: function(data){

				console.log ("02det_IMieiAlunni.php - salvaConOri - ritorno da 02qry_updateCons.php")
				console.log (data.sql);

				if (data.stopgo == "STOP") {
					$('#titolo01Msg_OK').html('CONSIGLIO ORIENTATIVO');
					$('#msg01Msg_OK').html(data.result_alert);
					$('#modal01Msg_OK').modal('show');
				} else {
					$('#titolo01Msg_OK').html('CONSIGLIO ORIENTATIVO');
					$('#msg01Msg_OK').html("Documento Completo<br><br>Salvataggio Effettuato");
					$('#modal01Msg_OK').modal('show');
				}

			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02det_IMieiAlunni ##fname##'");      
			}
		});
		return false; //return false (insieme a return nella chiamata onclick)
		//è necessario per non far partire il form
	}
	
	function salvaCommento() {
		let ID_alu_cla = $('#hidden_ID_alu').val();
		let commento_alux =  document.getElementById("commento_alu").value;	
		let commento_alu = commento_alux.replace("'", "\'");
		postData = { ID_alu_cla: ID_alu_cla, commento_alu: commento_alu};
		//console.log ("02det_IMieiAlunni.php - salvaCommmento - postData a 02qry_updateCommento.php");
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "02qry_updateCommento.php",
			data: postData,
			dataType: 'json',
			success: function(){
				$("#alertModificaCommento").show();
				setTimeout(function(){ $("#alertModificaCommento").hide();; }, 1000);
				//console.log (data.sql);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02det_IMieiAlunni ##fname##'");      
			}
		});
	}
	
	//function scaricaPagellaGET (ID_alu_det, annoscolastico_cla_det, aselme_cla, quadrimestre, pag_doc_cer){
	//	datapagella = $('#dataPagella'+quadrimestre).val();
	//	
	//	console.log('02downloadPagellaExcel.php?ID_alu_cla='+ID_alu_det+'&annoscolastico_cla='+annoscolastico_cla_det+'&aselme_cla='+aselme_cla+'&quadrimestre='+quadrimestre+'&datapagella='+datapagella+'&pag_doc_cer='+pag_doc_cer);
	//	window.location.href='02downloadPagellaExcel.php?ID_alu_cla='+ID_alu_det+'&annoscolastico_cla='+annoscolastico_cla_det+'&aselme_cla='+aselme_cla+'&quadrimestre='+quadrimestre+'&datapagella='+datapagella+'&pag_doc_cer='+pag_doc_cer;
	//}
	
	function scaricaPagellaPOST (e, ID_alu_cla, annoscolastico_cla, classe_cla, sezione_cla, quadrimestre, Doc) {
		e.preventDefault();
		//Doc può valere "ConOri", "CerCom", oppure può essere uno dei numeri che caratterizzano i vari template della pagella
		//in ogni caso si tratta di un varchar
		aselme_cla = $('#aselme_cla_hidden').val();
		postData = { annoscolastico : annoscolastico_cla };

		//DA QUI IN GIU' QUESTA FUNZIONE E' ESATTAMENTE UGUALE A scaricaPagellaPOST che si trova in 12EmissioneDocumenti.php
		//E TALE VA MANTENUTA

		exit = false;
		if ((Doc =="ConOri")&& (classe_cla != 'VIII')) {
			$('#titolo01Msg_OK').html('CONSIGLIO ORIENTATIVO');
			$('#msg01Msg_OK').html("L'alunno non frequenta la classe VIII");
			$('#modal01Msg_OK').modal('show');
			exit = true;
		}

		if ((Doc =="ConOri")&& (classe_cla == 'VIII')) {				
			//verifico se ci sono tutti i dati necessari
			postData = { annoscolastico: annoscolastico_cla, ID_alu: ID_alu_cla, ottava: 1 };
			$.ajax({
				async: false,
				type: 'POST',
				url: "12qry_checkConsOrientativo.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					if (data.stopgo == "STOP") {
						$('#titolo01Msg_OK').html('CONSIGLIO ORIENTATIVO');
						$('#msg01Msg_OK').html(data.result_alert);
						$('#modal01Msg_OK').modal('show');
						exit =  true;
						
					}
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '02det_IMieiAlunni ##fname##'");      
				}
			});
		}

		if (exit == true) { return;}




		
		//verifico se il documento in questione è stato compilato a dovere per dare un warning quando non lo è
		procedi = 'OK';
		postData = { ID_alu : ID_alu_cla, annoscolastico_cla: annoscolastico_cla, quadrimestre: quadrimestre, Doc: Doc};
		// console.log ("02det_IMieiAlunni.php - scaricaPagellaPOST - postData to 12qry_checkDocumentiCompilati.php");
		// console.log (postData);

		//ROUTINE TUTTA DA VERIFICARE! Doc adesso è un numero e non più PagUff o DocInt in quei due casi
		$.ajax({
			type: 'POST',
			url: "12qry_checkDocumentiCompilati.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				// console.log ("CkPagUff1="+data.CkPagUff1);
				// console.log ("CkPagUff2="+data.CkPagUff2);
				// console.log ("CkDocInt1="+data.CkDocInt1);
				// console.log ("CkDocInt2="+data.CkDocInt2);
				// console.log ("CkCerCom="+data.CkCerCom);
				// console.log (data.Ck);
				if (data.Ck == 'NO') {
					if (! confirm('Sembra che il documento richiesto non sia ancora completo procedere comunque?')) {
						procedi = 'NO';
					}
				}
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02det_IMieiAlunni ##fname##'");     
			}
		});
		if (procedi != 'OK') {return;}
		// console.log ("02det_IMieiAlunni.php - scaricaPagellaPOST - ritorno da 12qry_checkDocumentiCompilati.php NB: async!!! sistemare");
		// console.log (procedi);
		//in più rispetto a downloadPagellE c'è anche la possibilità di scaricare 
		//la Certificazione delle Competenze e del Consiglio orientativo
		//PagUff, DocInt e CerCom funzionano resta da vedere se ConOri funziona
		url ="12downloadPDF.php";

		let form = $('<form target="_blank" action="' + url + '"method="post"></form>');

		//rispetto al downloadPagelle downloadPagella posta anche l'ID_alu_cla
		let input_ID_alu_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "ID_alu_cla")
		.val(ID_alu_cla);
		$(form).append($(input_ID_alu_cla));

		let input_classe_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "classe_cla")
		.val(classe_cla);
		$(form).append($(input_classe_cla));

		let input_sezione_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "sezione_cla")
		.val(sezione_cla);
		$(form).append($(input_sezione_cla));

		let input_annoscolastico_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "annoscolastico_cla")
		.val(annoscolastico_cla);
		$(form).append($(input_annoscolastico_cla));

		let input_aselme_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "aselme_cla")
		.val(aselme_cla);
		$(form).append($(input_aselme_cla));

		let input_quadrimestre = $("<input>")
		.attr("type", "text")
		.attr("name", "quadrimestre")
		.val(quadrimestre);
		$(form).append($(input_quadrimestre));

		let input_datapagella = $("<input>")
		.attr("type", "text")
		.attr("name", "datapagella")
		.val('1900-01-01');
		$(form).append($(input_datapagella));

		let input_Doc = $("<input>")
		.attr("type", "text")
		.attr("name", "Doc")
		.val(Doc);
		$(form).append($(input_Doc));

		form.appendTo( document.body );

		$(form).submit();
		$(form).remove();

	}


	function modificaincorso(ID) {
		//questa routine modifica il colore del background della casella a discesa
	//	console.log (ID);

		setRunawayFalse();
		if (document.getElementById(ID).value == "") { document.getElementById(ID).style.backgroundColor = "#f4f4f4";} else {document.getElementById(ID).style.backgroundColor = "white"; }		
	}
	
	function showEditGiudizio(inputchiamante, classe, materia, quadrimestre) {
		//scrivo nella hidden inputchiamante qual è la textarea da cui sono partito: serve per quando andrò a copiarci il risultato della concatenazione delle select
		$("#inputchiamante").val(inputchiamante);
		//qui devo passare classe, materia e quadrimestre
		postData = {
			classe: classe,
			materia: materia,
			quadrimestre: quadrimestre
		};
		//console.log ("02det_IMieiAlunni.php - showEditGiudizio - postData a 02qry_getCombosEditGiudizio.php");
		//console.log(postData);
		$.ajax({
			type: 'POST',
			url: "02qry_getCombosEditGiudizio.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$('#remove-contentEG').html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02det_IMieiAlunni ##fname##'");      
			}
		});
		$("#remove-contentEG").show();
		$("#alertaggiungiEG").hide();
		$("#btn_cancelEditGiudizio").html('Annulla');
		$("#btn_OKEditGiudizio").show();
		$('#btn_cancelEditGiudizio').addClass("pull-left");
		$('#modalEditGiudizio').modal({
			show: 'true'
		});
	}

	function portaGiudizioAlDoc () {
		nomeinputchiamante = $("#inputchiamante").val();
		$("#"+nomeinputchiamante).html($("#giudizio").html());
		$('#modalEditGiudizio').modal('hide');
	}

	function aggiornaSottotipi () {
		tipo = $( "#selectTipo").val();
		sottotipo = $( "#sottotipo_hidden").val();
		postData = { tipo: tipo, sottotipo: sottotipo};
		// console.log( "02det_IMieiAlunni.php - aggiornaSottotipi - postData a 02qry_getComboSottotipiScuola.php")
		// console.log (postData);
		$.ajax({
			type: 'POST',
			url: "02qry_getComboSottotipiScuola.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log (html);
				$("#selectSottotipoContainer").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02det_IMieiAlunni ##fname##'");      
			}
		});
	}


	function salvaAltro (){
		ID_alu = $( "#hidden_ID_alu").val();
		tipo = $( "#selectTipo").val();
		sottotipo = $( "#selectSottoTipo").val();
		nomescuola = $( "#nomeScuola").val();
		votoLicenzaMedia = $( "#votoLicenzaMedia").val();
		postData = { ID_alu: ID_alu, tipo: tipo, sottotipo: sottotipo, nomescuola: nomescuola, votoLicenzaMedia: votoLicenzaMedia};
		console.log( "02det_IMieiAlunni.php - salvaAltro - postData a 02qry_updateAltro.php")
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "02qry_updateAltro.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log( "02det_IMieiAlunni.php - salvaAltro - data.test da 02qry_updateAltro.php")
				console.log (data.test);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02det_IMieiAlunni ##fname##'");     
			}
			
		});
	}


	// function scaricaConsOrientativo (){
	// 	//QUESTA FUNZIONE E' STATA SOPPIANTATA DALLA PIU' GENERICA scaricapagellaPOSt;
	// 	let ID_alu = $('#hidden_ID_alu').val();
	// 	let sezione_cor = 'A';
	// 	let ottava = 1;
	// 	//serve classe, sezione e data
	// 	let annoscolastico_cor = $( "#selectannoscolastico option:selected" ).val();
	// 	//verifico se ci sono tutti i dati necessari
	// 	postData = { annoscolastico: annoscolastico_cor, ID_alu: ID_alu, ottava: ottava };
		
	// 	$.ajax({
	// 		type: 'POST',
	// 		url: "12qry_checkConsOrientativo.php",
	// 		data: postData,
	// 		dataType: 'json',
	// 		success: function(data){
	// 			if (data.stopgo == "STOP") {
	// 				alert (data.result_alert);
	// 			} else {
					
	// 				let url = "12downloadConsOrientativo.php";
	// 				let form = $('<form action="' + url + '"method="post"></form>');
		
	// 				let input_ID_alu_cor = $("<input>")
	// 				.attr("type", "text")
	// 				.attr("name", "ID_alu_cor")
	// 				.val(ID_alu);
	// 				$(form).append($(input_ID_alu_cor));
					
	// 				let input_sezione_cor = $("<input>")
	// 				.attr("type", "text")
	// 				.attr("name", "sezione_cor")
	// 				.val(sezione_cor);
	// 				$(form).append($(input_sezione_cor));
					
	// 				let input_annoscolastico_cor = $("<input>")
	// 				.attr("type", "text")
	// 				.attr("name", "annoscolastico_cor")
	// 				.val(annoscolastico_cor);
	// 				$(form).append($(input_annoscolastico_cor));
					
	// 				form.appendTo( document.body );
	// 				$(form).submit();
					
	// 				//window.location.href='12downloadConsOrientativo.php?ID_alu_cor='+ID_alu+'&annoscolastico_cor='+annoscolastico+'&sezione=A';
	// 			}
	// 		}
	// 		,
	// 		error: function(){
	// 			alert("Errore: contattare l'amministratore fornendo il codice di errore '02det_IMieiAlunni-scaricaConsOrientativo'");      
	// 		}
	// 	});
	// 	return false;
		
	// 	//console.log('12downloadConsOrientativo.php?ID_alu_cor='+ID_alu+'&annoscolastico_cor='+annoscolastico+'&sezione=A');
	// }

	function copiaGGAssenza(e, quad) {

		$('#gga'+quad+'x').val( $('#gga'+quad).val() );
		e.preventDefault();

	}
</script>
