<?
	include_once("../database/databaseBii.php");
	include_once("../assets/functions/functions.php");
	include_once("../assets/functions/ifloggedinIscrizioni.php");
	include_once("diciture.php");
?>

<!DOCTYPE html>
<html style="overflow-x: hidden; width: 100%;  height: 100%; ">
<head>
	<title>Dichiarazioni</title>
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

	<? $_SESSION['page'] = "Scheda Iscrizione - Dichiarazioni";?>
</head>
 
<body style="background-image: url('../assets/img/background4.jpg'); width: auto !important; background-size: cover; overflow-x: hidden !important;  padding-bottom: 100px;">

			

	<? include("../assets/functions/autologoff.php"); ?>

	<div id="main">
		
		<? //include_once("../assets/functions/lowreswarningB.html"); ?>
		<div style="position: fixed; right: 10px; bottom: 15px; z-index: 100;">
			<button class="pull-right" style="width: 70px; height: 35px; text-align: center; font-size: 11px; border: 1px #3a66a5 solid; background-color: rgba(60,60,60,0.8); border-radius:15px; color: white" id="PBLogout" onclick="CheckBeforeLogout();" title="Esci">esci<img style="width: 20px; padding: 2px; " src="../assets/img/Icone/white/Logout2.svg" title="Esci"></button>
		</div>
		<div class="fixedheader" style=" background-image: url('../assets/img/background4.jpg'); background-size: cover ; border-bottom: 1px solid grey; z-index: 100;   position:fixed;  width:100%;  top:0;  left:0;">
			<style>
								
				.buttonresponsive {
					width: 130px;
				}
				.responsive12345 {
					width: 175px;
				}
				
				@media screen and (max-width: 1024px) {
					  .buttonresponsive {width: 80px !important; font-size: 12px;}
					  .responsive12345 {width: 115px !important; }
				}

			</style>
	
			<div class="col-md-6 col-sm-12 col-md-offset-3" style="z-index: 200;  margin-top: 3px; text-align: center; ">
				<input value="< Figli" class="btn btn-primary btn-cons buttonresponsive" id="btn_proceed" style="border-radius:15px; background: grey; " onclick="CheckBeforeForm3();" readonly></input>
				<img class="responsive12345" title="Status" style="text-align: center;cursor: pointer" src="../assets/img/12345/4.png">
				<input value="Salva >" class="btn btn-primary btn-cons buttonresponsive" id="btn_proceed" style="border-radius:15px; background: grey; " onclick="CheckBeforeForm5();" readonly></input>
			</div>

			<div class="col-md-8 col-sm-12 col-md-offset-2" style="text-align: center; font-size: 14px; margin-bottom: 20px; ">
				<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 24px; color: #3c3c3c;" >
					 ALTRE DICHIARAZIONI
				</div>
			</div>
<!-- HIDDEN VALUES ******************************************************************** -->

			<div class="row">
				<div class="col-md-12" style="text-align: center; font-size: 16px; margin-left: 40px;">
					<input id="ID_fam_hidden" 			name="ID_fam_hidden" 		value="<?=$_SESSION['ID_fam'];?>" 							hidden>
					<input id="n_fratelli_hidden" 		name="n_fratelli_hidden" 	value="<?=$_SESSION['num_fratelli'];?>" 					hidden>
					<input id="ISC_mostra_sceltareligione" 								value="<?=$_SESSION['ISC_mostra_sceltareligione'];?>" 	hidden>
					<input id="ISC_mostra_allegatoA" 									value="<?=$_SESSION['ISC_mostra_allegatoA'];?>" 		hidden>
					<input id="ISC_mostra_regolinterno" 								value="<?=$_SESSION['ISC_mostra_regolinterno'];?>" 		hidden>
					<input id="ISC_mostra_regolpediatrico" 								value="<?=$_SESSION['ISC_mostra_regolpediatrico'];?>" 	hidden>
					<input id="ISC_mostra_dietespeciali" 								value="<?=$_SESSION['ISC_mostra_dietespeciali'];?>" 	hidden>					


					<?$ISC_mostra_sceltareligione=		$_SESSION['ISC_mostra_sceltareligione'];?>
					<?$ISC_mostra_allegatoA=			$_SESSION['ISC_mostra_allegatoA'];?>
					<?$ISC_mostra_regolinterno=			$_SESSION['ISC_mostra_regolinterno'];?>
					<?$ISC_mostra_regolpediatrico=		$_SESSION['ISC_mostra_regolpediatrico'];?>
					<?$ISC_mostra_dietespeciali=		$_SESSION['ISC_mostra_dietespeciali'];?>

				</div>
			</div>
		</div>
<!-- ESTRAZIONE DATI ******************************************************************** -->

			<?

		$sql = "SELECT cognome_fam, cognomemadre_fam, nomemadre_fam, datanascitamadre_fam, comunenascitamadre_fam, provnascitamadre_fam, paesenascitamadre_fam, cittadinanzamadre_fam, ruolomadre_fam, cognomepadre_fam, nomepadre_fam, datanascitapadre_fam, comunenascitapadre_fam, provnascitapadre_fam, paesenascitapadre_fam, cittadinanzapadre_fam, ruolopadre_fam, ckpresavisione1_fam,  ckpresavisione2_fam, ckpresavisione3_fam, ckpresavisione4_fam, ckpresavisione5_fam, ckpresavisione6_fam, ckpresavisione7_fam, ckmadreesclusadanucleo_fam, ckpadreesclusodanucleo_fam ".
		"FROM tab_famiglie WHERE `ID_fam`= ?";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "i", $_SESSION['ID_fam']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $cognome_fam, $cognomemadre_fam, $nomemadre_fam, $datanascitamadre_fam, $comunenascitamadre_fam, $provnascitamadre_fam, $paesenascitamadre_fam, $cittadinanzamadre_fam, $ruolomadre_fam, $cognomepadre_fam, $nomepadre_fam, $datanascitapadre_fam, $comunenascitapadre_fam, $provnascitapadre_fam, $paesenascitapadre_fam, $cittadinanzapadre_fam, $ruolopadre_fam, $ckpresavisione1_fam,  $ckpresavisione2_fam, $ckpresavisione3_fam, $ckpresavisione4_fam, $ckpresavisione5_fam, $ckpresavisione6_fam, $ckpresavisione7_fam, $ckmadreesclusadanucleo_fam, $ckpadreesclusodanucleo_fam);
		while (mysqli_stmt_fetch($stmt)) {
		}?>
		<form id="formiscrizione" style="margin-top: 100px; ">
<!--SECONDA PARTE-->
			<div class="row" style="text-align: justify; margin-left: 2px; margin-right: 2px; font-size: 14px; line-height: 2">
				<div class="col-md-6 col-md-offset-3">
					I genitori dichiarano che il nucleo familiare è così composto (indicare tutti i componenti)<br>
					Spuntare la casella di controllo qualora il genitore non sia presente.
				</div>
			</div>
			<div class="row" style="text-align: center; font-size: 12px; margin-top: 20px; margin-left: 1px; margin-right: 5px;  ">
				<div class="col-md-6 col-md-offset-3">
					<table id="tabellaComposizioneFamiglia" style="display: inline-block;">
						<thead style="font-size: 10px;">
							<tr>
								<th style="width: 25px">
									
								</th>
								<th style="width:20%">
									<input class="tablelabel0 w100" type="text" value = "NOME" disabled>
								</th>
								<th style="width:20%">
									<input class="tablelabel0 w100" type="text" value = "COGNOME" disabled>
								</th>
								<th style="width:40%">
									<input class="tablelabel0 w100" type="text" value = "Luogo e Data di Nascita" disabled>
								</th>
								<th style="width:20%">
									<input class="tablelabel0 w100" type="text" value = "PARENTELA" disabled>
								</th>
								<th style="width: 25px">
									
								</th>
							</tr>
						</thead>

	
						<tbody>	
							<tr>
								<td>
									
								</td>
								<td>
									<input class="tablecell6 disab <?if ($ckpadreesclusodanucleo_fam == 1) {echo ("linethrough");}?>" type="text" id="nomepadre_fam" name="padre" value = "<?=$nomepadre_fam?>" readonly>
								</td>
								<td>
									<input class="tablecell6 disab <?if ($ckpadreesclusodanucleo_fam == 1) {echo ("linethrough");}?>" type="text" id="cognomepadre_fam" name="padre" value = "<?=$cognomepadre_fam?>" readonly>
								</td>
								<td>
									<input class="tablecell6 disab <?if ($ckpadreesclusodanucleo_fam == 1) {echo ("linethrough");}?>" type="text" id="luogodatanascitapadre_fam" name="padre" value = "<? echo($comunenascitapadre_fam."-".$provnascitapadre_fam."-".(date('d/m/Y', strtotime(str_replace('-','/', $datanascitapadre_fam))))); ?>" readonly>
								</td>
								<td>
									<input class="tablecell6 disab <?if ($ckpadreesclusodanucleo_fam == 1) {echo ("linethrough");}?>" type="text" id="lblpadre" name="padre" value = "<?=$ruolopadre_fam?>" readonly>
								</td>
								<td>
									<input class="tablelabel6 " type="checkbox" id="ckEscludiPadre" onclick="checkEscludiPadre()" title="Escludi/Includi dal nucleo familiare" <?if ($ckpadreesclusodanucleo_fam == 1) {echo ("checked");}?>>
								</td>
							</tr>
							<tr>
								<td>
									
								</td>
								<td>
									<input class="tablecell6 disab <?if ($ckmadreesclusadanucleo_fam == 1) {echo ("linethrough");}?>" type="text" id="nomemadre_fam" name="madre" value = "<?=$nomemadre_fam?>" readonly>
								</td>
								<td>
									<input class="tablecell6 disab <?if ($ckmadreesclusadanucleo_fam == 1) {echo ("linethrough");}?>" type="text" id="cognomemadre_fam" name="madre" value = "<?=$cognomemadre_fam?>" readonly>
								</td>
								<td>
									<input class="tablecell6 disab <?if ($ckmadreesclusadanucleo_fam == 1) {echo ("linethrough");}?>" type="text" id="luogodatanascitamadre_fam" name="madre" value = "<?echo($comunenascitamadre_fam."-".$provnascitamadre_fam."-".(date('d/m/Y', strtotime(str_replace('-','/', $datanascitamadre_fam))))); ?>" readonly>
								</td>
								<td>
									<input class="tablecell6 disab <?if ($ckmadreesclusadanucleo_fam == 1) {echo ("linethrough");}?>" type="text" id="lblmadre" name="madre" value = "<?=$ruolomadre_fam?>" readonly>
								</td>
								<td>
									<input class="tablelabel6 " type="checkbox" id="ckEscludiMadre" onclick="checkEscludiMadre()" title="Escludi/Includi dal nucleo familiare" <?if ($ckmadreesclusadanucleo_fam == 1) {echo ("checked");}?>>
								</td>
							</tr>
							<?

							$sql = "SELECT ID_alu, nome_alu, cognome_alu, mf_alu, datanascita_alu, comunenascita_alu, provnascita_alu, paesenascita_alu  ".
							"FROM tab_famiglie LEFT JOIN tab_anagraficaalunni ON ID_fam = ID_fam_alu WHERE `ID_fam`= ?";
							$stmt = mysqli_prepare($mysqli, $sql);
							mysqli_stmt_bind_param($stmt, "i", $_SESSION['ID_fam']);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_bind_result($stmt, $ID_alu, $nome_alu, $cognome_alu, $mf_alu, $datanascita_alu, $comunenascita_alu, $provnascita_alu, $paesenascita_alu);
							while (mysqli_stmt_fetch($stmt)) {?>
								<tr>
									<td>
										
									</td>
									<td>
										<input class="tablecell6 disab" type="text" id="nome_alu<?=$ID_alu?>" name="nome_alu<?=$ID_alu?>" value ="<?=$nome_alu?>" readonly>
									</td>
									<td>
										<input class="tablecell6 disab" type="text" id="cognome_alu<?=$ID_alu?>" name="cognome_alu<?=$ID_alu?>" value = "<?=$cognome_alu?>" readonly>
									</td>
									<td>
										<input class="tablecell6 disab" type="text" id="luogodatanascita_alu" name="luogodatanascita_alu" value = "<? echo($comunenascita_alu."-".$provnascita_alu."-".(date('d/m/Y', strtotime(str_replace('-','/', $datanascita_alu))))); ?>" readonly>
									</td>
									<td>
										<input class="tablecell6 disab" type="text" id="lblfiglio" name="lblfiglio" value = "<?if ($mf_alu=="M"){echo "figlio";} else {echo "figlia";}?>" readonly>
									</td>
									<td>
									
									</td>
								</tr>
							<?}?>
							<?

							$sql = "SELECT ID_cfa, nome_cfa, cognome_cfa, dataluogonascita_cfa, gradoparentela_cfa FROM tab_composizionefam WHERE `ID_fam_cfa`= ?";
							$stmt = mysqli_prepare($mysqli, $sql);
							mysqli_stmt_bind_param($stmt, "i", $_SESSION['ID_fam']);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_bind_result($stmt, $ID_cfa, $nome_cfa, $cognome_cfa, $dataluogonascita_cfa, $gradoparentela_cfa);
							while (mysqli_stmt_fetch($stmt)) {?>
								
								<tr>
									<td>
									<img title="Elimina Componente" class="iconaStd" src="../assets/img/Icone/times-circle-solid.svg" onclick = "elimina_cfa(<?=$ID_cfa?>);">
									</td>
									<td>
										<input class="tablecell6 disab" type="text" id="nome_cfa<?=$ID_cfa?>" name="nome_cfa<?=$ID_cfa?>" value ="<?=$nome_cfa?>" readonly>
									</td>
									<td>
										<input class="tablecell6 disab" type="text" id="cognome_cfa<?=$ID_alu?>" name="cognome_alu<?=$ID_alu?>" value = "<?=$cognome_cfa?>" readonly>
									</td>
									<td>
										<input class="tablecell6 disab" type="text" id="dataluogonascita_cfa<?=$ID_alu?>" name="dataluogonascita_cfa" value = "<?echo($dataluogonascita_cfa);?>" readonly>
									</td>
									<td>
										<input class="tablecell6 disab" type="text" id="gradoparentela_cfa<?=$ID_alu?>" name="gradoparentela_cfa" value = "<?echo($gradoparentela_cfa);?>" readonly>
									</td>
									<td>
									
									</td>
								</tr>
							<?}?>
							<tr id="aggiungihtml">
								<td>
									<img id="plusaggiungi" title="Aggiungi nuovo Componente" class="iconaStd" src='../assets/img/Icone/circle-plus.svg' onclick="aggiungi_cfa();">
								</td>
								<td id="scrittaaggiungi">
									 < Aggiungi componente
									 <input id="inmodifica" value = "0" hidden>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!--PRIMA PARTE-->
			<div class="row" style="text-align: justify; margin-left: 2px; margin-right: 2px; font-size: 14px; line-height: 2">
				<div class="col-md-6 col-md-offset-3">
					<br>
					Al fine dell’ammissione del/i proprio/i figlio/i i genitori dichiarano inoltre:
					<br>
					<?if ($ISC_mostra_allegatoA == 1) {?>
						<div class="col-md-12 col-sm-12" >
							<span style="padding-left: 2px; padding-right: 2px;" id="blockckpresavisione1"><input type="checkbox" class="presavisione" id="ckpresavisione1" name="ckpresavisione1" <?if ($ckpresavisione1_fam == 1) {echo "checked";}?>></span>	che hanno preso visione dei Principi che regolano il Percorso Pedagogico (<a href="downloadAllegato.php?nomeallegato=A_<?=$codscuola?>"  target="_blank">allegato A</a>)
						</div>
					<?}?>

					<div class="col-md-12 col-sm-12" >
						<span style="padding-left: 2px; padding-right: 2px;" id="blockckpresavisione7"><input type="checkbox" class="presavisione" id="ckpresavisione7" name="ckpresavisione7" <?if ($ckpresavisione7_fam == 1) {echo "checked";}?>></span> che hanno preso visione del <a href="<?=$linkPTOF?>"  target="_blank"><?=$POF_PTOF_PSD?></a>
					</div>
					
					<?if ($ISC_mostra_regolinterno == 1) {?>
						<div class="col-md-12 col-sm-12">
							<span style="padding-left: 2px; padding-right: 2px;" id="blockckpresavisione2"><input type="checkbox" class="presavisione" id="ckpresavisione2" name="ckpresavisione2" <?if ($ckpresavisione2_fam == 1) {echo "checked";}?>></span> che hanno preso visione del Regolamento Interno (<a href="downloadAllegato.php?nomeallegato=B_<?=$codscuola?>"  target="_blank">allegato B</a>) e lo condividono.
						</div>
					<?}?>

					<?if ($ISC_mostra_regolpediatrico == 1) {?>
						<div class="col-md-12 col-sm-12">
							<span style="padding-left: 2px; padding-right: 2px;" id="blockckpresavisione3"><input type="checkbox" class="presavisione" id="ckpresavisione3" name="ckpresavisione3" <?if ($ckpresavisione3_fam == 1) {echo "checked";}?>></span> che hanno preso visione de<?=$fraseAllegatoC?> (<a href="downloadAllegato.php?nomeallegato=C_<?=$codscuola?>""  target="_blank">allegato C</a>) e lo condividono.
						</div>
					<?}?>
					<?if ($ISC_mostra_dietespeciali == 1) {?>
						<div class="col-md-12 col-sm-12">
							<span style="padding-left: 2px; padding-right: 2px;" id="blockckpresavisione4"><input type="checkbox" class="presavisione" id="ckpresavisione4" name="ckpresavisione5" <?if ($ckpresavisione4_fam == 1) {echo "checked";}?>></span> che nel caso il/i proprio/i figlio/i fosse/ro affetto/i da allergie, intolleranze o patologie che richiedano la somministrazione di farmaci e/o diete speciali ne daranno tempestiva comunicazione alla segreteria tramite la compilazione del <a href="downloadAllegato.php?nomeallegato=E_<?=$codscuola?>"  target="_blank">MODULO DI RICHIESTA</a> (corredato da certificato medico specialistico)
						</div>
					<?} else  {?>
						<div class="col-md-12 col-sm-12">
							<span style="padding-left: 2px; padding-right: 2px;" id="blockckpresavisione4"><input type="checkbox" class="presavisione" id="ckpresavisione4" name="ckpresavisione5" <?if ($ckpresavisione4_fam == 1) {echo "checked";}?>></span> che nel caso il/i proprio/i figlio/i fosse/ro affetto/i da allergie ad alimenti, farmaci, insetti, metalli o altro ne daranno tempestiva comunicazione alla segreteria allegando certificato medico specialistico
						</div>
					<?}?> 
					<div class="col-md-12 col-sm-12">
						<span style="padding-left: 2px; padding-right: 2px;" id="blockckpresavisione5"><input type="checkbox" class="presavisione" id="ckpresavisione5" name="ckpresavisione5" <?if ($ckpresavisione5_fam == 1) {echo "checked";}?>></span> che si impegnano a comunicare qualsiasi variazione riguardante i dati comunicati nel presente modulo entro e non oltre 30 giorni dalla variazione
					</div>
					
					<?
					//il parametro mostrasceltareligione usato per gli alunni implica che, nel caso in cui venga mostrata la scelta, qui non si veda il flag di presa visione che la religione non viene insegnata: per questo qui funziona "al contrario" (!=1)
					if ($ISC_mostra_sceltareligione != 1) {?>
						<div class="col-md-12 col-sm-12">
							<span style="padding-left: 2px; padding-right: 2px;" id="blockckpresavisione6"><input type="checkbox" class="presavisione" id="ckpresavisione6" name="ckpresavisione6" <?if ($ckpresavisione6_fam == 1) {echo "checked";}?>></span> l’intenzione di non avvalersi, per il presente anno scolastico, dell’insegnamento della religione cattolica.
						</div>
					<?}?>

					<br>

				</div>
			</div>
			
		</form>
		<!--<div class="row">
			<div  class="col-md-4 col-sm-12 col-md-offset-4">
				<div class="col-md-6 col-sm-6" style="text-align: center; font-size: 14px;">
					<input value="< Dati dei figli" class="btn btn-primary btn-cons" id="btn_proceed" style="width: 100%; margin-top: 20px; border-radius:15px; background: grey; " onclick="CheckBeforeForm3();" readonly></input>
				</div>
				<div class="col-md-6 col-sm-6" style="text-align: center; font-size: 14px;">
					<input value="Procedi >" class="btn btn-primary btn-cons" id="btn_proceed" style="width: 100%; margin-top: 20px; border-radius:15px; background: grey; " onclick="GoForm5();" readonly></input>
				</div>
			</div>
		</div>-->


	</div>
	
	
	<div class="modal" id="modalCheckBeforeForm3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">ATTENZIONE!</span>
					<div id="remove-content1" style="text-align: center;"> <!-- START REMOVE CONTENT -->
						<br>
						Tornare allo step precedente
						<br>(Dati dei figli)
						<br>implica che le modifiche correnti
						<br>ai dati compilati in questo modulo
						<br>non verranno salvate.
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer">
						<div class="col-md-6 col-sm-12">
							<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="margin-top: 5px; width: 90%; border-radius:15px;" data-dismiss="modal" onclick="GoBack();">< Dati dei figli</button>
						</div>
						<div class="col-md-6 col-sm-12">	
							<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="margin-top: 5px; width: 90%; border-radius:15px;" data-dismiss="modal" onclick="">Annulla</button>
						</div>
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
						<br>Siete sicuri di voler uscire?
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer">
						<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="width:40%; border-radius:15px;" data-dismiss="modal" >Annulla</button>
						<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="width:40%; border-radius:15px;" data-dismiss="modal" onclick="Logout();">Sì</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="modalAvvisoCampi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">ATTENZIONE</span>
					<div id="avvisoremove-content1" style="text-align: center;"> <!-- START REMOVE CONTENT -->
						<br>Si prega di compilare tutti e quattro i campi
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer">
						<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="width:40%; border-radius:15px;" data-dismiss="modal" >OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="modalAvvisoCampi2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">ATTENZIONE</span>
					<div id="avvisoremove-content1" style="text-align: center;"> <!-- START REMOVE CONTENT -->
						<br>E' necessario confermare di aver preso visione delle dichiarazioni rilasciate;
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer">
						<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="width:40%; border-radius:15px;" data-dismiss="modal" >OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="modalAvvisoCampi3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">ATTENZIONE</span>
					<div id="avvisoremove-content1" style="text-align: center;"> <!-- START REMOVE CONTENT -->
						<br>prima di procedere salvare il componente in fase di inserimento<br>tramite il pulsante apposito, ora evidenziato.
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer">
						<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="width:40%; border-radius:15px;" data-dismiss="modal" >OK</button>
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
	});
	
	function elimina_cfa(ID_cfa) {
		postData = {ID_cfa: ID_cfa};
		$.ajax({
			url : "qry_deletecfa.php",
			type: "POST",
			data : postData,
			dataType: "json",
			success:function(){
				location.reload(true);
			}
		});
	}
	
	
	function aggiungi_cfa() {
		appendhtml = "<td><input class='tablecell6 disab' type='text' id='nome_cfa_new' maxlength='50' name='nome_cfa_new' value =''></td><td><input class='tablecell6 disab' type='text' id='cognome_cfa_new' name='cognome_alu_new' maxlength='50' value = ''></td><td><input class='tablecell6 disab' type='text' id='dataluogonascita_cfa_new' name='dataluogonascita_cfa_new' value = ''></td><td><input class='tablecell6 disab' type='text' id='gradoparentela_cfa_new' name='gradoparentela_cfa_new' value = ''></td><td></td><td id='pulsantinosalva'><img  title='salva nuovo componente' style='width: 20px; cursor: pointer' src='../assets/img/Icone/save-regular.svg' onclick='savenew_cfa();'>salva</td>";
		$('#aggiungihtml').append(appendhtml);
		$('#inmodifica').val("1");
		$('#plusaggiungi').css('visibility','hidden');
		$('#scrittaaggiungi').hide();
	}
	
	function savenew_cfa() {
		ID_fam_cfa = $('#ID_fam_hidden').val();
		nome_cfa_new = $('#nome_cfa_new').val();
		cognome_cfa_new = $('#cognome_cfa_new').val();
		dataluogonascita_cfa_new = $('#dataluogonascita_cfa_new').val();
		gradoparentela_cfa_new = $('#gradoparentela_cfa_new').val();

		if ((nome_cfa_new == "") || (cognome_cfa_new == "") || (dataluogonascita_cfa_new == "") || (gradoparentela_cfa_new =="")) {
			$('#modalAvvisoCampi').modal('show');
		} else {
			postData = {ID_fam_cfa: ID_fam_cfa, nome_cfa_new: nome_cfa_new, cognome_cfa_new: cognome_cfa_new, dataluogonascita_cfa_new: dataluogonascita_cfa_new, gradoparentela_cfa_new: gradoparentela_cfa_new};
			$.ajax({
				url : "qry_addcfa.php",
				type: "POST",
				data : postData,
				dataType: "json",
				success:function(){
					$('#inmodifica').val("0");
					location.reload(true);
				}
			});
		}
	}
	
	function CheckBeforeForm3(){
		$('#modalCheckBeforeForm3').modal('show');
	}
	
	function GoBack(){
		let url = "FormIscrizione3.php";
		let form = $('<form id="tmpform" action="' + url + '"method="post">' + '<input type="text" name ="num_fratello" value ="1" ></form>');
		$('body').append(form);
		console.log ($('#n_fratelli_hidden').val());
		form.submit();
		var element =  document.getElementById('tmpform');
		element.remove();
	}
	
	function CheckBeforeForm5(){
		if (($('#inmodifica').val()) == "1"){
			$('#pulsantinosalva').css("border", "1px solid red");
			$('#modalAvvisoCampi3').modal('show');
		} else {
			let missingfields = 0;
			let campo = ["ckpresavisione1", "ckpresavisione2", "ckpresavisione3", "ckpresavisione4", "ckpresavisione5", "ckpresavisione6", "ckpresavisione7"];
			
			if ($('#ISC_mostra_sceltareligione').val() == 1) {
				controllacampo6 = 0; //se la religione viene mostrata come opzione nella scheda dell'alunno, qui non devo mostrarla nè controllare che sia compilata
			} else {
				controllacampo6 = 1; //se la religione NON viene mostrata come opzione nella scheda dell'alunno, qui devo mostrarla e controllare che sia compilata
			};
			
			let controllacampo = [ $('#ISC_mostra_allegatoA').val(),$('#ISC_mostra_regolinterno').val(),$('#ISC_mostra_regolpediatrico').val(),1,1,controllacampo6, 1 ];


			for (i = 0; i <= 6; i++) {
				if (controllacampo[i] == 1) { 
					if ($('#'+campo[i]).is(':checked') == false){
						$('#block'+campo[i]).css("border", "1px solid red");
						//campomissing[missingfields]=campodesc[i];
						missingfields++;
						//console.log (camponame+" Y: #"+campo[i]+"Y "+ ($('#'+campo[i]+"Y").is(':checked'))+" N: #"+campo[i]+"N "+($('#'+campo[i]+"N").is(':checked')));
					} else {
						$('#block'+campo[i]).css("border", "0px");
						//console.log (camponame+" ok");
					}
				}
			}
			if (missingfields != 0)	{
				$('#modalAvvisoCampi2').modal('show');
			} else {
				GoForm5();
			}
			
		}
		
	}
	
	function GoForm5() {
		idle = 1;
		postData = {ID_fam: idle};
		console.log (postData);
		$.ajax({
			url : "qry_updateckPresaVisione.php",
			type: "POST",
			data : postData,
			dataType: "json",
			success:function(data){
				console.log (data.sql);

				updateStatusFamiglia(80, "FormIscrizione5.php");
			}
		});
	}

	function updateStatusFamiglia(percentage, pagina){
		postData = {status: percentage};
		console.log (postData);
		$.ajax({
			url : "qry_updateStatusFam.php",
			type: "POST",
			data : postData,
			dataType: "json",
			success:function(data){
				console.log (data.sql);
				window.location.href = pagina;
			}
		});
	}


	
	function CheckBeforeLogout(){
		$('#modalCheckBeforeLogout').modal('show');
	}
	function Logout() {
		window.location.href = "Logout.php";
	}

	function checkEscludiPadre() {

		if ($("#ckEscludiPadre").is(":checked")) {
			$('[name="padre"]').css("text-decoration", "line-through");
			ckpadreesclusodanucleo_fam = 1;
		} else {
			$('[name="padre"]').css("text-decoration", "none");
			ckpadreesclusodanucleo_fam = 0;
		}

		//ID_fam = $('#ID_fam_hidden').val();

		postData = {genitore: "padre", ckpadreesclusodanucleo_fam: ckpadreesclusodanucleo_fam};
		console.log (postData);

		$.ajax({
			url : "qry_updateckGenitoreEsclusoNucleo.php",
			type: "POST",
			data : postData,
			dataType: "json",
			success:function(data){
				console.log (data.sql);
			}
		});


	}

	function checkEscludiMadre() {
		if ($("#ckEscludiMadre").is(":checked")) {
			$('[name="madre"]').css("text-decoration", "line-through");
			ckmadreesclusadanucleo_fam = 1;
		} else {
			$('[name="madre"]').css("text-decoration", "none");
			ckmadreesclusadanucleo_fam = 0;
		}

		//ID_fam = $('#ID_fam_hidden').val();

		postData = {genitore: "madre", ckmadreesclusadanucleo_fam: ckmadreesclusadanucleo_fam};
		console.log (postData);

		$.ajax({
			url : "qry_updateckGenitoreEsclusoNucleo.php",
			type: "POST",
			data : postData,
			dataType: "json",
			success:function(data){
				console.log (data.sql);
			}
		});
	}
</script>
