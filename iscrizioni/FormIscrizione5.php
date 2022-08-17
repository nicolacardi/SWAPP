<?
	include_once("../database/databaseBii.php");
	include_once("../assets/functions/functions.php");
	include_once("../assets/functions/ifloggedinIscrizioni.php");
?>

<!DOCTYPE html>
<html style="overflow-x: hidden; width: 100%;  height: 100%; ">
<head>
	<title>Modulo Contributi</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="../assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="../assets/img/faviconbook.png" type="image/icon">
	<script src="../assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="../assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="../assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
	
	<!-- <link rel="stylesheet" href="../assets/croppie/croppie.css" />
	<script src="../assets/croppie/croppie.js"></script> -->
	
	<link href="../assets/datetimepicker/datepicker.css" rel="stylesheet" type="text/css" />
	<script src="../assets/moment/moment.js" type="text/javascript"></script>
	
	<script src="../assets/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../assets/bootstrap-select/bootstrap-select.css">
	<script src="../assets/bootstrap-select/bootstrap-select.js"></script>

	<? $_SESSION['page'] = "Scheda Iscrizione - Contributi";?>




</head>
 
<body style="background-image: url('../assets/img/background4.jpg'); width: auto !important; background-size: cover; overflow-x: hidden !important;  padding-bottom: 100px;">

<!-- HIDDEN VALUES *********************************************************************** -->

	<? $ISC_mostra_combosceltarata = 	$_SESSION['ISC_mostra_combosceltarata'];?>
	<? $ISC_mostra_10rate = 			$_SESSION['ISC_mostra_10rate'];?>
	<? $ISC_mostra_12rate = 			$_SESSION['ISC_mostra_12rate'];?>
	<? $ISC_mostra_3rate = 				$_SESSION['ISC_mostra_3rate'];?>
	<? $ISC_mostra_13rate = 			$_SESSION['ISC_mostra_13rate'];?>
	<? $ISC_mostra_ratealtro = 			$_SESSION['ISC_mostra_ratealtro'];?>
	<? $ISC_mostra_pulizie = 			$_SESSION['ISC_mostra_pulizie'];?>
	<? $ISC_mostra_conguagliospesedid = $_SESSION['ISC_mostra_conguagliospesedid'];?>
	<? $ISC_mostra_contraggiuntivo = 	$_SESSION['ISC_mostra_contraggiuntivo'];?>
	<? $ISC_mostra_intestazionefatt = 	$_SESSION['ISC_mostra_intestazionefatt'];?>
	<? $ISC_mostra_tipopag = 			$_SESSION['ISC_mostra_tipopag'];?>		
	<? $ISC_mostra_tipopagamentiSDD = 			$_SESSION['ISC_mostra_tipopagamentiSDD'];?>		
	<? $ISC_mostra_tipopagamentiCONTANTI = 		$_SESSION['ISC_mostra_tipopagamentiCONTANTI'];?>		
	<? $ISC_mostra_tipopagamentiALTRO = 		$_SESSION['ISC_mostra_tipopagamentiALTRO'];?>			
	<? $ISC_mostra_richcolloquio = 			$_SESSION['ISC_mostra_richcolloquio'];?>
	<? $ISC_mostra_quotaiscrizione =		$_SESSION['ISC_mostra_quotaiscrizione'];?>
	<? $ISC_mostracinquepermille =			$_SESSION['ISC_mostracinquepermille'];?>



	
	<? include("../assets/functions/autologoff.php"); ?>


	<div id="main">
<!-- HEADER e INCIPIT ******************************************************************** -->

		<?include_once("diciture.php");?>
		<? //include_once("../assets/functions/lowreswarningB.html"); ?>

		<div style="position: fixed; right: 10px; bottom: 15px; z-index: 100;">
			<button class="pull-right" style="width: 70px; height: 35px; text-align: center; font-size: 11px; border: 1px #3a66a5 solid; background-color: rgba(60,60,60,0.8); border-radius:15px; color: white" id="PBLogout" onclick="CheckBeforeLogout();" title="Esci">esci<img style="width: 20px; padding: 2px; " src="../assets/img/Icone/white/Logout2.svg" title="Esci"></button>
		</div>
		<div class="fixedheader" style="background-image: url('../assets/img/background4.jpg'); background-size: cover ; border-bottom: 1px solid grey; z-index: 100;   position:fixed;  width:100%;  top:0;  left:0;">
			<style>
								
				.buttonresponsive {
					width: 130px;
				}
				.buttonresponsivesm {
					width: 130px;
					
				}
				.responsive12345 {
					width: 175px;
				}
				@media screen and (max-width: 1024px) {
					  .buttonresponsive {width: 80px !important; font-size: 12px;}
					  .buttonresponsivesm {width: 80px !important; ; height: 31px !important; font-size: 8px;}
					  .responsive12345 {width: 115px !important; }
				}

			</style>
	
			<div class="col-md-6 col-sm-12 col-md-offset-3" style="z-index: 200;  margin-top: 3px; text-align: center;">
				<input value="< Dichiarazioni" class="btn btn-primary btn-cons buttonresponsivesm" id="btn_back" style="border-radius:15px; background: grey; " onclick="CheckBeforeForm4();" readonly></input>
				<img class="responsive12345" title="Status" style="text-align: center; cursor: pointer" src="../assets/img/12345/5.png">
				<input value="Salva >" class="btn btn-primary btn-cons buttonresponsive" id="btn_proceed" style="border-radius:15px; background: grey; " onclick="CheckBeforeForm6();" readonly></input>
			</div>

			<div class="col-md-8 col-sm-12 col-md-offset-2" style="text-align: center; font-size: 24px; margin-bottom: 20px; color: #3c3c3c;">
				
					 CONTRIBUTI SCOLASTICI <?=$_SESSION['annopreiscrizione_fam']?>
					 
			</div>
			<div class="row">
				<div class="col-md-12" style="text-align: center; font-size: 16px; margin-left: 40px;">
					<input id="ID_fam_hidden" 		name="ID_fam_hidden" 		value="<?=$_SESSION['ID_fam'];?>" 		hidden>
					<input id="n_fratelli_hidden" 	name="n_fratelli_hidden" 	value="<?=$_SESSION['num_fratelli'];?>" hidden>
					<input id="codscuola_hidden" 	name="cod_scuola_hidden" 	value="<?=$codscuola?>" 				hidden>
					<input id="ISC_mostra_combosceltarata" name="ISC_mostra_combosceltarata" value="<?=$ISC_mostra_combosceltarata?>" hidden>
					
				</div>
			</div>
		</div>
		<form id="formiscrizione" style="margin-top: 100px; ">
			<div class="row" style="text-align: justify; font-size: 14px; line-height: 2; margin-left: 2px; margin-right: 2px; ">
				<div class="col-md-6 col-md-offset-3">
					La <?=$nomescuola?> si finanzia, in massima parte, con contributi e donazioni delle famiglie, necessari alla copertura delle spese del personale (maestri, segreteria...) e al buon funzionamento dell'organizzazione: per questi motivi la puntualità nei pagamenti, la correttezza e la solidarietà rappresentano valori irrinunciabili.
				</div>
				<div class="col-md-6 col-md-offset-3" style="text-align: center;" >
					<h4>I GENITORI SI IMPEGNANO<br>IN SOLIDO:</h4>
				</div>
				<? if ($ISC_mostra_quotaiscrizione==1) {?>
					<div class="col-md-6 col-md-offset-3">
						-	a versare entro il <?=$scadiscrizione?><?= $_SESSION['anno1']?> la quota di iscrizione per l'a.s. <?=$_SESSION['annopreiscrizione_fam']?>, pari a € <?=$quotaiscrizione?> 
					</div>
				<?}?>
				<div class="col-md-6 col-md-offset-3">
					-	a versare, con regolarità e puntualità, per l'a.s. <?=$_SESSION['annopreiscrizione_fam']?>, una quota annua così definita (v. <a href="downloadAllegato.php?nomeallegato=D_<?=$codscuola?>"  target="_blank">Allegato D</a>):
				</div>
			</div>
			<div class="row" style="text-align: center; font-size: 12px; margin-top: 20px; ">
				<div class="col-md-6 col-md-offset-3">
					<table id="tabellaQuote" style="display: inline-block;">
						<thead>
							<tr>
								<?// if ($codscuola =='PD') { ?>
								<? if ($ISC_mostra_combosceltarata==0) {?>
									<th style="width: 10%">
									</th>
								<?}?>
								<th style="width: 20%">
									<input class="tablelabel0 w100" type="text" value = "Nome Cognome" disabled>
								</th>
								<th style="width: 20%">
									<input class="tablelabel0 w100" type="text" value = "# figlio" disabled>
								</th>
								<th style="width: 20%">
									<input class="tablelabel0 w100" type="text" value = "Iscr. alla classe" disabled>
								</th>
								
								<th style="width: 20%">
									<input class="tablelabel0 w100" type="text" value = "Quota Annua" disabled>
								</th>

								<th style="width: 20%">
									<?// if ($codscuola =='CI') { ?>
									<? if ($ISC_mostra_combosceltarata==1) {?>
										<input class="tablelabel0 w100" type="text" value = "Tipo Quota" disabled>
									<?}?>
								</th>

							</tr>
<!-- ESTRAZIONE DATI ********************************************************************* -->
							
							<?
							$classi = array("ASILO"=>"MATERNA", "I"=>"I ELEMENTARE", "II"=>"II ELEMENTARE", "III"=>"III ELEMENTARE", "IV"=>"IV ELEMENTARE", "V"=>"V ELEMENTARE", "VI"=>"I MEDIA (VI)", "VII"=>"II MEDIA (VII)", "VIII"=>"III MEDIA (VIII)", "IX"=>"I Sup.", "X"=>"II Sup.", "XI"=>"III Sup.", "XII"=>"IV Sup.", "XIII"=>"V Sup.", "NIDO"=>"ASILO NIDO");
							
							$Nfiglio = array("1"=>"Prim", "2"=>"Second", "3"=>"Terz", "4"=>"Quart", "5"=>"Quint");
							
							$MF = array("M"=>"o figlio", "F"=>"a figlia");
							
							$mostra12rate = 0;
							$sql = "SELECT ID_alu, mf_alu, nome_alu, cognome_alu, classe_cla, quotapromessa_alu, quotaconcordata_alu, ratepromesse_alu, ratepromesse_fam, quotacontraggiuntivo_fam, ratecontraggiuntivo_fam, tipoquota_alu, modalitapag_fam, pulizie_fam, richcolloquio_fam, intestazionefatt_fam 
							FROM (`tab_anagraficaalunni` JOIN `tab_classialunni` ON ID_alu = ID_alu_cla) 
							JOIN tab_famiglie ON ID_fam_alu = ID_fam
							WHERE `ID_fam_alu`= ? AND noniscritto_alu = 0 ORDER BY datanascita_alu ASC";
							$stmt = mysqli_prepare($mysqli, $sql);
							mysqli_stmt_bind_param($stmt, "i", $_SESSION['ID_fam']);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_bind_result($stmt, $ID_alu, $mf_alu, $nome_alu, $cognome_alu, $classe_cla, $quotapromessa_alu, $quotaconcordata_alu, $ratepromesse_alu, $ratepromesse_fam, $quotacontraggiuntivo_fam, $ratecontraggiuntivo_fam, $tipoquota_alu, $modalitapag_fam, $pulizie_fam, $richcolloquio_fam, $intestazionefatt_fam);
							$n = 0;
							$totquotapromessa = 0;
							while (mysqli_stmt_fetch($stmt)) {


								if ($ratepromesse_alu ==12) {$mostra12rate = 1;} //ATTENZIONE. Se anche uno solo dei figli ha 12 rate concordate viene mostrata l'opzione per tutta la famiglia
								$totquotapromessa = $totquotapromessa + intval($quotapromessa_alu);
								$n++;?>
	
								<tr>
									<? // if ($codscuola =='PD') { ?>
									<? if ($ISC_mostra_combosceltarata==0) {?>
										<td style="width: 10%">
										</td>
									<?}?>
									<td>
										<input id="classe_cla_hidden<?=$n?>" name="classe_cla_hidden<?=$ID_alu?>" value="<?=$classe_cla;?>" hidden>
										
										<input class="tablecell6 disab" type="text" id="nomecognome_alu<?=$ID_alu?>" name="nomecognome_alu<?=$ID_alu?>" value = "<?=$nome_alu." ".$cognome_alu?>" style="font-size: 13px; color: rgb(150,150,150);" readonly>
									</td>
									<td>
										<input class="tablecell6 disab" type="text" id="n_alu<?=$n?>" name="n_alu" value = "<?=$Nfiglio[$n].$MF[$mf_alu]?>" style="font-size: 13px; color: rgb(150,150,150);" readonly>
									</td>
									<td>
										<input class="tablecell6 disab" type="text" id="classeiscrizione_alu<?=$n?>" name="classeiscrizione_alu" value = "<?=$classi[$classe_cla]?>" style="font-size: 13px; color: rgb(150,150,150);" readonly>
									</td>
									<td>
										<input style="font-size: 13px; " class="tablecell6 disab quote" type="text" id="quotapromessa_alu<?=$n?>" name="quotapromessa_alu<?=$ID_alu?>" maxlength="4" value = "<?=$quotapromessa_alu?>" onchange="aggiornaTotale(); AvvisoSoloSeConcordato();" readonly>
									</td>
									<td>
										<? // if ($codscuola =='CI') { ?>
										<? if ($ISC_mostra_combosceltarata==1) {?>
											<input id="classe_cla<?=$n?>" 	value="<?=$classe_cla;?>" hidden>
											<select name="selecttipoquota<?=$ID_alu?>"  style="margin-left: 0px; width: 100%"  id="selecttipoquota<?=$n?>" onchange="ricalcolaQuota('<?=$classe_cla;?>',<?=$n?>);">
													<option value="0" <?if ($tipoquota_alu ==0) {echo("selected");}?>>Completa</option>
													<option value="1" <?if ($tipoquota_alu ==1) {echo("selected");}?>>Ridotta</option>
													<option value="2" <?if ($tipoquota_alu ==2) {echo("selected");}?>>Minima</option>
											</select>
										<?}?>
									</td>
	
								</tr>
							
							<?}?>
							<tr>

								<? // if ($codscuola =='PD') { ?>
								<? if ($ISC_mostra_combosceltarata==0) {?>
									<td style="width: 10%">
									</td>
								<?}?>
								<td colspan=" 3" >
									<input style="font-size: 14px; color: rgb(150,150,150);" class="tablecell6 disab" type="text" value = "Totale Contributo Annuale" readonly>
								</td>
								<td>
									<input style="font-size: 14px; color: rgb(150,150,150);" class="tablecell6 disab" type="text" id="totquotapromessa" name="totquotapromessa" value = "<?=$totquotapromessa?>" readonly>
								</td>

							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="row" style="text-align: justify; font-size: 14px; line-height: 2; margin-left: 2px; margin-right: 2px; ">
				<!--<div class="col-md-6 col-md-offset-3" style=" font-size: 10px; <? //if ($quotaconcordata_alu == 0) {echo ('display: none;'); } ?>">
					(la quota espressa sarà soggetta ad approvazione da parte del Consiglio di Amministrazione e potrà quindi subire variazioni, da concordare con la famiglia)
				</div>-->
<!-- SELEZIONE RATE ********************************************************************** -->

				<div class="col-md-6 col-md-offset-3" id="lblckratepromesse_fam">
					-	a versare l’ammontare della quota annua in soluzione: (v. <a href="downloadAllegato.php?nomeallegato=D_<?=$codscuola?>"  target="_blank">Allegato D</a>)
					<div class="col-md-12 col-sm-12">
						<select name="selectnumerorate_fam"  style="margin-left: 0px; width: 100%"  id="selectnumerorate_fam">
							<option value="1" <?if ($ratepromesse_fam ==1) {echo("selected");}?>>UNICA entro il <?=$scadrataunica?> <?=$_SESSION['anno1']?></option>

							<? if ($ISC_mostra_3rate == 1) { ?>
								<option value="3" <?if ($ratepromesse_fam ==3) {echo("selected");}?>>DIVISA in 3 rate: <?=$scad3rate?></option>
							<?}?>
							
							<? if ($ISC_mostra_10rate == 1) { ?>
								<option value="10" <?if ($ratepromesse_fam ==10) {echo("selected");}?>>DILAZIONATA <?=$scadpagamenti?> in 10 mensilità (da settembre a giugno)</option>
							<?}?>

							<? if ($mostra12rate == 1 || $ISC_mostra_12rate == 1) {?>
								<!--A Padova ANCHE SE il parametro ISC_mostra12rate vale 0 ci sono casi in cui il CDA imposta la suddivisione in 12 rate-->
								<option value="12" <?if ($mostra12rate ==1 || $ratepromesse_fam ==12) {echo("selected");}?>>DILAZIONATA <?=$scadpagamenti?> in 12 mensilità (da settembre ad agosto)</option>
							<?}?>
							
							<? if ($ISC_mostra_ratealtro == 1) { ?>
								<option value="99" <?if ($ratepromesse_fam ==99) {echo("selected");}?>>ALTRO (da compilare manualmente nel modulo cartaceo) su accordo specifico con l'amministrazione </option>
							<?}?>

						</select>
					</div>					
				</div>
<!-- PULIZIE ***************************************************************************** -->

				<? if ($ISC_mostra_pulizie == 1 ) { ?>
					
					<div class="col-md-6 col-md-offset-3" id="lblckratepromesse_fam">
						<div class="col-md-12 col-sm-12">
							<input type="radio" class="pulizie_fam" name="pulizie_fam" value="0" <?if ($pulizie_fam == 0) {echo "checked";}?>>&nbsp;- a svolgere le pulizie
						</div>
						<div class="col-md-12 col-sm-12">
							<input type="radio" class="pulizie_fam" name="pulizie_fam" value="1" <?if ($pulizie_fam == 1) {echo "checked";}?>>&nbsp;- a versare la quota per le pulizie (180 euro per un figlio, 210 per 2 o più figli)
						</div>
						
					</div>
				<?}?>

<!-- SPESE DIDATTICHE ******************************************************************** -->

				<? if ($ISC_mostra_conguagliospesedid == 1) { ?>
					<div class="col-md-6 col-md-offset-3">
						-	a versare a consuntivo entro il 15/06/<?=$_SESSION['anno2']?> l’eventuale conguaglio per le spese didattiche anticipate dalla Scuola
					</div>
				<?}?>
				</div>
				<div class="row" style="text-align: justify; font-size: 14px; line-height: 2; margin-left: 2px; margin-right: 2px; border-top: 1px grey solid;">

<!-- CONTRIBUTO AGGIUNTIVO *************************************************************** -->

				<? if ($ISC_mostra_contraggiuntivo ==1) { ?>
				<div class="col-md-6 col-md-offset-3" style="display: inline;">
					I sottoscritti intendono inoltre versare un CONTRIBUTO AGGIUNTIVO di euro 
					<input class="tablecell5 quote" type="text" id="quotacontraggiuntivo_fam" name="quotacontraggiuntivo_fam" maxlength="6" style="padding: 0px;margin-left: 10px; margin-right: 10px; width: 80px; height: 25px; " value = "<?=$quotacontraggiuntivo_fam?>">
					 in un numero di rate mensili pari a:
					<input type="text" class="tablecell5 quote rate" id="ratecontraggiuntivo_fam" name="ratecontraggiuntivo_fam" maxlength="2" value="<?=$ratecontraggiuntivo_fam?>" style=" padding: 0px;width: 40px; height: 25px;">
				</div>
				<?}?>

<!-- RICHIESTA COLLOQUIO ***************************************************************** -->

				<? if ($ISC_mostra_richcolloquio ==1) { ?>
					
					<div class="col-md-6 col-md-offset-3" style="">
						<input type="checkbox"  id="richcolloquio_fam" name="richcolloquio_fam" <? if ($richcolloquio_fam == 1) { echo ('checked');} ?> >
						<label for="richcolloquio_fam" style="margin-bottom: 0px;" >I sottoscritti richiedono un colloquio per "Fondo solidarietà per le Famiglie"</label>
					</div>
				<?}?>

				<div class="col-md-6 col-md-offset-3" id="intestazione_pagamenti_fam" >

<!-- MODALITA PAGAMENTO ****************************************************************** -->

					<? if ($ISC_mostra_tipopag == 1) { ?>
						
						<div class="col-md-12 col-sm-12">	
						I sottoscritti scelgono di pagare:
						</div>
						<div class="col-md-12 col-sm-12">
							<select name="selectmodalitapag_fam"  style="margin-left: 0px; width: 100%"  id="selectmodalitapag_fam">
								<?if($ISC_mostra_tipopagamentiSDD == 1) {?>
									<option value='0' <?if ($modalitapag_fam ==0) {echo("selected");}?>><?=$modalitaPagSDD?></option>
								<?}?>
									<option value='1' <?if ($modalitapag_fam ==1) {echo("selected");}?>><?=$modalitaPagBonifico?></option>
								<?if($ISC_mostra_tipopagamentiCONTANTI == 1) {?>
									<option value='2' <?if ($modalitapag_fam ==2) {echo("selected");}?>>in contanti</option>
								<?}?>
								<?if($ISC_mostra_tipopagamentiALTRO == 1) {?>
									<option value='3' <?if ($modalitapag_fam ==3) {echo("selected");}?>>ALTRO (previo specifico accordo con l'amministrazione)</option>
								<?}?>
							</select>
						</div>
						<div class="col-md-12 col-sm-12">
							NB: Si ricorda che la normativa prevede la detraibilità delle spese scolastiche solo se tracciate (ad es. bonifico, carta di credito, o POS)
						</div>
					<?}?>

<!-- INTESTAZIONE FATTURA **************************************************************** -->

					<? if ($ISC_mostra_intestazionefatt == 1) { ?>
						<div class="col-md-12 col-sm-12">
							Chiedono di intestare le fatture a:
						</div>
						<div class="col-md-12 col-sm-12">
							<select name="selectintestazionefatt_fam"  style="margin-left: 0px; width: 100%"  id="selectintestazionefatt_fam">
								<option value='padre' <?if ($intestazionefatt_fam =="padre") {echo("selected");}?>>padre</option>
								<option value='madre' <?if ($intestazionefatt_fam =="madre") {echo("selected");}?>>madre</option>
								<option value='altro' <?if ($intestazionefatt_fam =="altro") {echo("selected");}?>>altro</option>
							</select>
						</div>
					<?}?>
					<? if ($ISC_mostracinquepermille == 1) { ?>
						<div class="col-md-12 col-sm-12 mt10 bordered-red center" >
							<h4>CINQUE PER MILLE</h4>
							Nell'occasione invitiamo le famiglie ed i loro congiunti ad indicare la scuola in dichiarazione dei redditi quale <br><span style="text-decoration: underline">destinatario del 5xmille</span> tramite il Codice fiscale: <?=$cfscuola?>.
						</div>
					<?}?>
				</div>


			</div>
		</form>
		<!--<div class="row">
			<div  class="col-md-4 col-sm-12 col-md-offset-4">
				<div class="col-md-6 col-sm-6" style="text-align: center; font-size: 14px;">
					<input value="< Dichiarazioni" class="btn btn-primary btn-cons" id="btn_proceed" style="width: 100%; margin-top: 20px; border-radius:15px; background: grey; " onclick="CheckBeforeForm4();" readonly></input>
				</div>
				<div class="col-md-6 col-sm-6" style="text-align: center; font-size: 14px;">
					<input value="Salva e Procedi >" class="btn btn-primary btn-cons" id="btn_proceed" style="width: 100%; margin-top: 20px; border-radius:15px; background: grey; " onclick="CheckBeforeForm6();" readonly></input>
				</div>
			</div>
		</div>-->


	</div>
	
	
	<div class="modal" id="modalCheckBeforeForm4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">ATTENZIONE!</span>
					<div id="remove-content1" style="text-align: center;"> <!-- START REMOVE CONTENT -->
						<br>
						Tornare allo step precedente
						<br>(Dichiarazioni)
						<br>implica che le modifiche correnti
						<br>ai dati compilati in questo modulo
						<br>non verranno salvate.
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer">
						<div class="col-md-6 col-sm-12">
							<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="height: 35px; margin-top: 5px; width: 90%; border-radius:15px;" data-dismiss="modal" onclick="GoBack();">< Dichiarazioni</button>
						</div>
						<div class="col-md-6 col-sm-12">
							<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="margin-top: 5px; width: 90%; border-radius:15px;" data-dismiss="modal" onclick="">Annulla</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

		
	<div class="modal" id="modalAvviso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">ATTENZIONE!</span>
					<div id="remove-contentAvviso" style="text-align: center;"> <!-- START REMOVE CONTENT -->
						<br>
						Modificare le quote solamente in caso di previo accordo <br>
						con il Consiglio di Amministrazione della scuola.
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer">
						<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="width:40%; border-radius:15px;" data-dismiss="modal" onclick="">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>
		
	<div class="modal" id="modalCheckBeforeLogout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">LOGOUT</span>
					<div id="remove-content1" style="text-align: center;"> <!-- START REMOVE CONTENT -->
						<br>
						Siete sicuri di voler uscire?
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer">
						<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="width:40%; border-radius:15px;" data-dismiss="modal" >Annulla</button>
						<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="width:40%; border-radius:15px;" data-dismiss="modal" onclick="Logout();">Sì</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	

</body>
</html>	
<script>
	
	$(document).ready(function(){
		//setting del datepicker
		moment.locale('en', {
          week: { dow: 1 }
        });
		$('.datepicker').datetimepicker({
			pickTime: false, 
			format: "DD/MM/YYYY",
            weekStart: 1
		});

		codscuola = $('#codscuola_hidden').val();
		//if (codscuola =='CI') {
		if ($('#ISC_mostra_combosceltarata').val() == 1){
			// //console.log("sto per lanciare il ricalcolo quote");
			// n_fratelli = $('#n_fratelli_hidden').val();
			// //console.log(n_fratelli);
			// for (n = 1; n <= n_fratelli; n++){
			// 	console.log ("FormIscrizione5.php - document ready - lancio ricalcolaQuota, " +n+": classe "+$('#classe_cla_hidden'+n).val());
			// 	ricalcolaQuota($('#classe_cla_hidden'+n).val(), n);  //NON FUNZIONA!!!************************************************
			// 	// console.log("FormIscrizione5.php - Document.ready - lancio il ricalcolo della quota per il fratello n."+n)
			// 	// console.log ("Calcolo la quota per la classe:" + $('#classe_cla_hidden'+n).val())
			// }


			ricalcolaQuote();
		}
	});

	
	function CheckBeforeForm4(){
		$('#modalCheckBeforeForm4').modal('show');
	}
	
	function GoBack(){
		window.location.href = "FormIscrizione4.php";	
	}
	
	function CheckBeforeForm6 (){
		//console.log("FormIscrizione5.php - CheckBeforeForm6")
		let missingfields = 0;
		// if ($('.ckratepromesse_fam').is(':checked') == false){
		// 	$('#lblckratepromesse_fam').css("border", "1px solid red");
		// 	missingfields++;
		// } else {
		// 	$('#lblckratepromesse_fam').css("border", "0px");
		// }
		
		//console.log ("quotacontr"+$('#quotacontraggiuntivo_fam').val());
		//console.log ("ratecontr"+$('#ratecontraggiuntivo_fam').val());
		
		if (($('#quotacontraggiuntivo_fam').val()*$('#ratecontraggiuntivo_fam').val() == 0 ) && ( parseInt($('#quotacontraggiuntivo_fam').val()) + parseInt($('#ratecontraggiuntivo_fam').val()) != 0 ) ){
				$('#remove-contentAvviso').html("<br>Si prega di verificare quota e numero rate contributo aggiuntivo.<br>Devono essere entrambi uguali a zero oppure entrambi diversi da zero.");
				$('#modalAvviso').modal('show');
		} else {

			if (missingfields == 0) {
				//console.log("FormIscrizione5.php - CheckBeforeForm6 - missingfields == 0 - SaveAndGoNext")
				SaveAndGoNext();
			} else {
				//console.log("FormIscrizione5.php - CheckBeforeForm6 - missingfields != 0")
				$('#remove-contentAvviso').html("<br>I campi evidenziati in rosso sono mancanti<br>o compilati in maniera non corretta.<br>Per procedere è necessario correggere.");
				$('#modalAvviso').modal('show');
				
			}
		}
		
		


		
		//3.pagina finale da predisporre da zero: ringraziamenti
		//4.pulsante di download 
		//5.raccomandazione di stampare per rendere valida l'iscrizione
		//1gg
		//1.logout
		//2.logout su tutte le pagine
		//3.test multipli
		//1gg
		//download pdf GROSSO LAVORO speriamo bene: 1gg
		//acquisizione dati da swapp che tira da swappB (piccolo casino combinato su contraggiuntivo...o su quote..metà su tab_alu e metà su tab_fam) GROSSO LAVORO 1 gg
		//copia online di tutto/
	}
	


	function SaveAndGoNext (){

			let postData = $("#formiscrizione").serializeArray();
			 console.log("FormIscrizione5.php - SaveAndGoNext - postData a qry_updateContributi.php");
			 console.log (postData);
			
			$.ajax({
				url : "qry_updateContributi.php",
				type: "POST",
				data : postData,
				dataType: "json",
				success:function(data){
					//  console.log("FormIscrizione5.php - SaveAndGoNext - ritorno da qry_updateContributi.php");
					//  console.log (data.sql);
					//  console.log (data.test);
					 
					updateStatusFamiglia (100, "FormIscrizione6.php");
				}
			});
	}
	
	
	function updateStatusFamiglia(percentage, pagina){
		postData = {status: percentage};
		// console.log("FormIscrizione5.php - updateStatusFamiglia - postData a qry_updateStatusFam");
		// console.log (postData);
		
		$.ajax({
			url : "qry_updateStatusFam.php",
			type: "POST",
			data : postData,
			dataType: "json",
			success:function(data){
				// console.log("FormIscrizione5.php - updateStatusFamiglia - ritorno da qry_updateStatusFam");
				// console.log (data.sql);
				window.location.href = pagina;
			}
		});
	}
	
	
	
	$('.quote').keypress(function(e) {
		let a = [];
		let k = e.which;
		//console.log (k);
		for (i = 48; i < 58; i++){
			a.push(i);
		}
		//a.push(45); //aggiungo all'array dei codici anche il codice che corrisponde a '-' per consentire di indicare un "non voto"
		if ((a.indexOf(k)) == -1) {
			e.preventDefault();
		}
	});
	
	$('.rate').keyup(function () {
		let $this = $(this);
		if (($this.val() < 0 || $this.val() > 12) && $this.val().length != 0) {
			if ($this.val() < 1) {
				$this.val(1);
			}
			if ($this.val() > 12) {
				$this.val(12);
			}
		}
	});
	
	function aggiornaTotale(){
		n_fratelli = $('#n_fratelli_hidden').val();
		//console.log (n_fratelli);
		let totquotapromessa = 0;
		for (n_fratello = 1; n_fratello <= n_fratelli; n_fratello++){
			totquotapromessa = totquotapromessa + parseInt($('#quotapromessa_alu'+n_fratello).val());
		}
		$('#totquotapromessa').val(totquotapromessa);
	}
	
	
	function CheckBeforeLogout(){
		$('#modalCheckBeforeLogout').modal('show');
	}
	function Logout() {
		window.location.href = "Logout.php";
	}
	function AvvisoSoloSeConcordato() {
		console.log("avviso");
		$('#remove-contentAvviso').html("<br>Si prega di modificare le quote solamente previo esplicito accordo<br>con il Consiglio di Amministrazione della scuola.");
		$('#modalAvviso').modal('show');	
	}

	function ricalcolaQuote () {
		//trovo quanti fratelli
		n_fratelli = $('#n_fratelli_hidden').val();

		for (n = 1; n <= n_fratelli; n++){
			classe_cla = $('#classe_cla'+n).val();
			console.log (classe_cla, n);
			ricalcolaQuota (classe_cla, n);
		}
		
		//per ciascuno
	}
	function ricalcolaQuota(classe_cls, n) {

		n_fratelli = $('#n_fratelli_hidden').val();
		tipoquota = $( "#selecttipoquota"+n+" option:selected" ).val();
		//questa funzione vale solo per Cittadella, non verrà nemmeno usata per le altre scuole
		//se dovesse esserlo allora va ripensata per pescare in una tabella di quote apposita
		quoteAS = [4790, 4315, 3835, 3765]; 	//retta completa, ridotta, minima, minima con più figli
		quoteEL = [5320, 4790, 4255, 4185];
		quoteME = [5680, 5110, 4540, 4470];
		quoteSU = [5680, 5110, 4540, 4470];
		//dell'array giusto devo selezionare il "tipoquotesimo", 0 se uno ha selezionato 0, 1 se uno ha selezionato 1, 2 se uno ha selezionato 2 nella combobox
		//il caso 3 è riservato a quando viene selezionato il 2 E i fratelli sono più di 1
		quotaDaAggiornare = $('#quotapromessa_alu'+n);
		
		postData = {classe_cls: classe_cls};
		//console.log ("Formiscrizione5.php - post a 12qry_getaselme.php");
		$.ajax({
			type: 'POST',
			url: "../12qry_getaselme.php",
			async: false,
			data: postData,
			dataType: 'json',
			success: function(data){
				// console.log ("Formiscrizione5.php - ricalcolaQuota - ritorno da 12qry_getaselme.php ");
				// console.log ("n:"+n+" data.aselme_cls:"+data.aselme_cls+" n_fratelli:"+n_fratelli+" selezione effettuata:"+tipoquota+" ");
				//console.log ("valore attuale:"+quotaDaAggiornare.val());
				
				if (data.aselme_cls == "AS") {
					//console.log("imposto dove era "+quotaDaAggiornare.val()+ " a "+quoteAS[tipoquota]);
					quotaDaAggiornare.val(quoteAS[tipoquota]); 
				
				}
				if (data.aselme_cls == "EL") {
					//console.log("imposto dove era "+quotaDaAggiornare.val()+ " a "+quoteEL[tipoquota]);
					quotaDaAggiornare.val(quoteEL[tipoquota]); 
				
				}
				if (data.aselme_cls == "ME") {
					//console.log("imposto dove era "+quotaDaAggiornare.val()+ " a "+quoteME[tipoquota]);
					quotaDaAggiornare.val(quoteME[tipoquota]); 

				}
				if (data.aselme_cls == "SU") {
					//console.log("imposto dove era "+quotaDaAggiornare.val()+ " a "+quoteSU[tipoquota]);
					quotaDaAggiornare.val(quoteSU[tipoquota]); 

				}


				//nel caso in cui la selezione sia la seconda (tipoquota ==2) e i fratelli più di 1 devo però pescare l'ultimo valore dell'array
				if (data.aselme_cls == "AS" && n_fratelli != 1 && tipoquota == 2) {
					//console.log("imposto dove era "+quotaDaAggiornare.val()+ " a "+quoteAS[3]);
					quotaDaAggiornare.val(quoteAS[3]); 

				}
				if (data.aselme_cls == "EL" && n_fratelli != 1 && tipoquota == 2) {
					//console.log("imposto dove era "+quotaDaAggiornare.val()+ " a "+quoteEL[3]);
					quotaDaAggiornare.val(quoteEL[3]);

				}
				if (data.aselme_cls == "ME" && n_fratelli != 1 && tipoquota == 2) {
					//console.log("imposto dove era "+quotaDaAggiornare.val()+ " a "+quoteAS[3]);
					quotaDaAggiornare.val(quoteME[3]);

				}
				if (data.aselme_cls == "SU" && n_fratelli != 1 && tipoquota == 2) {
					//console.log("imposto dove era "+quotaDaAggiornare.val()+ " a "+quoteAS[3]);
					quotaDaAggiornare.val(quoteSU[3]);

				}
				aggiornaTotale();
				//$('#aselme_cla_hidden').val(data.aselme_cls);
			}
		});
	}
</script>
