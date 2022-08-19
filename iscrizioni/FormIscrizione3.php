<?
	include_once("../database/databaseBii.php");
	include_once("../assets/functions/functions.php");
	include_once("../assets/functions/ifloggedinIscrizioni.php");
	include_once("diciture.php");
	include_once("dicitureInformativaPrivacy.php");
	include_once ("../modal01Msg_OK.html");
?>

<!DOCTYPE html>
<html style="overflow-x: hidden; width: 100%;  height: 100%; ">
<!-- header-->
	<head>
		<title>Scheda Alunno</title>
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

		<? $_SESSION['page'] = "Scheda Iscrizione 3 - Alunni";?>
	</head>


<body style="background-image: url('../assets/img/background4.jpg'); width: auto !important; background-size: cover; overflow-x: hidden !important;  padding-bottom: 100px;">
<!-- ESTRAZIONE DATI ******************************************************************** -->
	<?include_once("diciture.php");?>


	<?
	$countries = array("Italia", "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antigua e Barbuda", "Antille Olandesi", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belgio", "Belize", "Benin", "Bermuda", "Bhutan", "Bielorussia", "Bolivia", "Bosnia Herzegowina", "Botswana", "Bouvet Island", "Brasile", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambogia", "Camerun", "Canada", "Capo Verde", "Cayman", "Chad", "Cile", "Cina", "Città del Vaticano", "Colombia", "Comoros", "Congo", "Congo, Rep. Democratica del", "Corea, Repubblica popolare democratica di", "Corea, Repubblica della", "Costa Rica", "Costa d'Avorio", "Croazia", "Cuba", "Cipro", "Danimarca", "Djibouti", "Dominica", "East Timor", "Ecuador", "Egitto", "El Salvador", "Eritrea", "Estonia", "Etiopia", "Fiji", "Filippines", "Finlandia", "Francia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germania", "Ghana", "Giappone",  "Gibilterra", "Giordania", "Grecia", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guiana Francese", "Guinea", "Guinea-Bissau", "Guinea Equatoriale", "Guyana", "Haiti", "Honduras", "Islanda", "India", "Indonesia", "Iran (Repubblica Islamica dell')", "Iraq", "Irlanda", "Isole Christmas", "Isole Cocos (Keeling)", "Isole Cook", "Isole Falkland (Malvinas)", "Isole Faroe", "Isole Heard and Mc Donald", "Isole Marshall", "Isole Solomon", "Isole Svalbard e Jan Mayen", "Isole Turks and Caicos", "Isole Vergini (British)", "Isole Vergini (U.S.)", "Isole Wallis e Futuna","Israele", "Jamaica", "Kazakhstan", "Kenia", "Kiribati", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lesotho", "Libano", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lituania", "Lussemburgo",  "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malesia", "Maldive", "Mali", "Malta", "Marocco", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Messico", "Micronesia, Federazione della", "Moldova, Repubblica della", "Monaco", "Mongolia", "Montserrat", "Mozambico", "Myanmar", "Namibia", "Nauru", "Nepal",  "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norvegia",  "Nuova Caledonia", "Nuova Zelanda", "Olanda", "Oman", "Pakistan", "Palau", "Panama", "Papua Nuova Guinea", "Paraguay", "Peru", "Pitcairn", "Polonia", "Polinesia Francese", "Portogallo", "Puerto Rico", "Qatar", "Repubblica Ceca", "Repubblica Centroafricana", "Republica Dominicana", "Reunion", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Repubblica della)", "Slovenia", "Somalia",  "South Georgia and the South Sandwich Islands", "Spagna", "Sri Lanka", "Stati Uniti d'America", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname",  "Sudafrica", "Svezia", "Svizzera","Swaziland",  "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, Repubblica della", "Thailandia", "Togo", "Tokelau", "Tonga", "Trinidad e Tobago", "Tunisia", "Turchia", "Turkmenistan",  "Tuvalu", "Ucraina", "Uganda",  "Ungheria", "United Arab Emirates", "UK",  "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
	$countriesN = count($countries);
	$classi = array("ASILO"=>"SCUOLA MATERNA", "I"=>"PRIMA ELEMENTARE", "II"=>"SECONDA ELEMENTARE", "III"=>"TERZA ELEMENTARE", "IV"=>"QUARTA ELEMENTARE", "V"=>"QUINTA ELEMENTARE", "VI"=>"PRIMA MEDIA (VI)", "VII"=>"SECONDA MEDIA (VII)", "VIII"=>"TERZA MEDIA (VIII)", "NIDO"=>"ASILO NIDO");

	$classiV = array("ASILO"=>"<5", "I"=>"<5", "II"=>"<5", "III"=>"<5", "IV"=>"<5", "V"=>">5", "VI"=>">5", "VII"=>">5", "VIII"=>">5", "NIDO"=>"<5");

	$classiI_IV = array("ASILO"=>"0", "I"=>"1", "II"=>"1", "III"=>"1", "IV"=>"1", "V"=>"0", "VI"=>"0", "VII"=>"0", "VIII"=>"0", "NIDO"=>"0");


	$num_fratello = $_POST['num_fratello'];
	
	$sql = "SELECT `ID_alu`, `mf_alu`, `nome_alu`, `cognome_alu`, datanascita_alu, comunenascita_alu, provnascita_alu, paesenascita_alu, cittadinanza_alu, cf_alu, indirizzo_alu, citta_alu, CAP_alu, prov_alu, paese_alu, disabilita_alu, DSA_alu, ckprivacy1_alu, ckprivacy2_alu, ckprivacy3_alu, ckautfoto_alu, ckautmateriale_alu, ckautuscite_alu, ckautuscitaautonoma_alu, ckdoposcuola_alu, ckreligione_alu, altreligione_alu, ckmensa_alu, cktrasportopubblico_alu, scuolaprovenienza_alu, indirizzoscproven_alu, noniscritto_alu, classe_cla, annoscolastico_cla FROM (`tab_famiglie` JOIN `tab_anagraficaalunni` ON `ID_fam_alu` = `ID_fam`) JOIN tab_classialunni ON ID_alu = ID_alu_cla WHERE `ID_fam`= ? ORDER BY datanascita_alu ASC";
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_bind_param($stmt, "i", $_SESSION['ID_fam']);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $ID_aluTMP, $mf_aluTMP, $nome_aluTMP, $cognome_aluTMP, $datanascita_aluTMP, $comunenascita_aluTMP, $provnascita_aluTMP, $paesenascita_aluTMP, $cittadinanza_aluTMP, $cf_aluTMP, $indirizzo_aluTMP, $citta_aluTMP, $CAP_aluTMP, $prov_aluTMP, $paese_aluTMP, $disabilita_aluTMP, $DSA_aluTMP, $ckprivacy1_aluTMP, $ckprivacy2_aluTMP, $ckprivacy3_aluTMP, $ckautfoto_aluTMP, $ckautmateriale_aluTMP, $ckautuscite_aluTMP, $ckautuscitaautonoma_aluTMP, $ckdoposcuola_aluTMP, $ckreligione_aluTMP, $altreligione_aluTMP, $ckmensa_aluTMP, $cktrasportopubblico_aluTMP, $scuolaprovenienza_aluTMP, $indirizzoscproven_aluTMP, $noniscritto_aluTMP, $classe_claTMP, $annoscolastico_cla);
			$nn = 0;
			while (mysqli_stmt_fetch($stmt)) {
				$nn++;
				if (($num_fratello) == $nn){
					$ID_alu = $ID_aluTMP;
					$mf_alu = $mf_aluTMP;
					$nome_alu = $nome_aluTMP;
					$cognome_alu = $cognome_aluTMP;
					$datanascita_alu = $datanascita_aluTMP;
					$comunenascita_alu = $comunenascita_aluTMP;
					$provnascita_alu = $provnascita_aluTMP;
					$paesenascita_alu = $paesenascita_aluTMP;
					$cittadinanza_alu = $cittadinanza_aluTMP;
					$cf_alu = $cf_aluTMP;
					$indirizzo_alu = $indirizzo_aluTMP;
					$citta_alu = $citta_aluTMP;
					$CAP_alu = $CAP_aluTMP;
					$prov_alu = $prov_aluTMP;
					$paese_alu = $paese_aluTMP;
					$disabilita_alu = $disabilita_aluTMP;
					$DSA_alu = $DSA_aluTMP;
					$ckprivacy1_alu = $ckprivacy1_aluTMP;
					$ckprivacy2_alu = $ckprivacy2_aluTMP;
					$ckprivacy3_alu = $ckprivacy3_aluTMP;
					$ckautfoto_alu = $ckautfoto_aluTMP;
					$ckautmateriale_alu = $ckautmateriale_aluTMP;
					$ckautuscite_alu = $ckautuscite_aluTMP;
					$ckautuscitaautonoma_alu = $ckautuscitaautonoma_aluTMP;
					$ckdoposcuola_alu = $ckdoposcuola_aluTMP;
					$ckreligione_alu = $ckreligione_aluTMP;
					$altreligione_alu = $altreligione_aluTMP;
					$ckmensa_alu = $ckmensa_aluTMP;
					$cktrasportopubblico_alu = $cktrasportopubblico_aluTMP;
					$scuolaprovenienza_alu = $scuolaprovenienza_aluTMP;
					$indirizzoscproven_alu = $indirizzoscproven_aluTMP;
					$noniscritto_alu = $noniscritto_aluTMP;
					$classe_cla = $classe_claTMP;
					$n = $nn ;
					$_SESSION['annoscolastico'] = $annoscolastico_cla;
				}
			}
			$_SESSION['num_fratelli'] = $nn;
	?>
			
<!-- HEADER e HIDDEN VALUES ************************************************************* -->

	<?include("../assets/functions/autologoff.php"); ?>

	<div id="main">
		<div style="position: fixed; right: 10px; bottom: 15px; z-index: 200;">
			<button class="pull-right" style="width: 70px; height: 35px; text-align: center; font-size: 11px; border: 1px #3a66a5 solid; background-color: rgba(60,60,60,0.8); border-radius:15px; color: white" id="PBLogout" onclick="CheckBeforeLogout();" title="Esci">esci<img style="width: 20px; padding: 2px; " src="../assets/img/Icone/white/Logout2.svg" title="Esci"></button>
		</div>

		<div class="fixedheader" style=" background-image: url('../assets/img/background4.jpg'); background-size: cover ; border-bottom: 1px solid grey; z-index: 200;   position:fixed;  width:100%;  top:0;  left:0;">
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

			<div class="col-md-6 col-sm-12 col-md-offset-3" style="z-index: 200; margin-top: 3px; text-align: center; ">
				<input value="< Madre" class="btn btn-primary btn-cons buttonresponsive" id="btn_back" style="border-radius:15px; background: grey;" onclick="CheckBeforeForm2();" readonly></input>
				<img class="responsive12345" title="Status" style="text-align: center;cursor: pointer" src="../assets/img/12345/3<?if($nn!=1){echo($n);}?>.png">
				<input value="Salva >" class="btn btn-primary btn-cons buttonresponsive" id="btn_proceed" style="border-radius:15px; background: grey; " onclick="CheckBeforeFormNext();" readonly></input>
			</div>

			<? //include_once("../assets/functions/lowreswarningB.html"); ?>
			<div class="col-md-8 col-sm-12 col-md-offset-2" style="text-align: center; font-size: 24px; color: #3c3c3c;">
				<?
				if ($nn != 1) {
					$contatore = array("idle", "prim", "second", "terz", "quart", "quint");
					if ($mf_alu == "M"){$art=" "; $frase = "o figlio";} else {$art="la "; $frase = "a figlia";}
					echo ("Dati del".$art.$contatore[$n].$frase);
				} else {
					if ($mf_alu == "M"){$frase = " figlio";} else {$frase = "la figlia";}
					echo ("Dati del".$frase);
				}
				?>
			</div>
			<div class="col-md-8 col-sm-12 col-md-offset-2" style="text-align: center; font-size: 14px; color: #3c3c3c;">
				<?
				echo ("Iscrizione alla ".$classi[$classe_cla]);
				?>
			</div>
			<div class="row">
				<div class="col-md-12" style="text-align: center; font-size: 16px; margin-left: 40px;">
					<input id="nomescuola_hidden" 					value ="<?=$nomescuola?>" 			hidden>
					<input id="indirizzoscuola_hidden" 				value ="<?=$indirizzoscuola?>" 		hidden>
					<input id="ID_fam_hidden" 						value="<?=$_SESSION['ID_fam'];?>" 	hidden>
					<input id="ID_alu_hidden" 						value="<?=$ID_alu;?>" 				hidden>
					<input id="n_fratello_hidden" 					value="<?=$n;?>" 					hidden>
					<input id="n_fratelli_hidden" 					value="<?=$nn;?>" 					hidden>
					<input id="testoarticolomensa_hidden" 			value="<?=$testoarticolomensa;?>" 	hidden>
					
					<input id="mostrareligione_hidden" 				value="<?=$_SESSION['ISC_mostra_sceltareligione'];?>" 		hidden>
					<input id="mostratrasporto_hidden" 				value="<?=$_SESSION['ISC_mostra_trasportopubblico'];?>" 	hidden>

					<!-- la mensa dipende anche dal fatto che l'alunno NON sia in ASILO ...andrebbe parametrizzato-->
					<input id="mostramensa_hidden" 					
					value="<?
					if ($_SESSION['ISC_mostra_mensa'] && $classe_cla != "ASILO") {
						echo (1);
					} else {
						echo (0);
					};
					//=$_SESSION['ISC_mostra_mensa'];
					?>"	hidden>


					<!-- uscita autonoma dipende anche dal fatto che l'alunno sia in classe > 5 ...andrebbe parametrizzato-->
					<input id="mostrauscitaautonoma_hidden" 		
					value="<?
					if ($_SESSION['ISC_mostra_uscitaautonoma'] && $classiV[$classe_cla] == ">5") {
						echo (1);
					} else {
						echo (0);
					};
					?>" hidden>

					<!-- doposcuola dipende anche dal fatto che l'alunno sia in classe I-IV ...andrebbe parametrizzato-->
					<input id="mostradoposcuola_hidden" 		
					value="<?
					if ($_SESSION['ISC_mostra_doposcuola'] && $classiI_IV[$classe_cla] == "1") {
						echo (1);
					} else {
						echo (0);
					};
					?>" hidden>



					<?
					$mostrareligione=		$_SESSION['ISC_mostra_sceltareligione'];
					$mostratrasporto=		$_SESSION['ISC_mostra_trasportopubblico'];
					//$mostramensa=			$_SESSION['ISC_mostra_mensa'];

					//mensa dipende anche dal fatto che l'alunno sia in classe > 5 ...andrebbe parametrizzato

					if ($classe_cla == "ASILO") {
						$mostramensa =	0; }
					else {
						$mostramensa = $_SESSION['ISC_mostra_mensa'];
					}

					//uscita autonoma dipende anche dal fatto che l'alunno sia in classe > 5 ...andrebbe parametrizzato

					if ($classiV[$classe_cla] == "<5") {
						$mostrauscitaautonoma =	0; }
					else {
						$mostrauscitaautonoma = $_SESSION['ISC_mostra_uscitaautonoma'];
					}

					//doposcuola dipende anche dal fatto che l'alunno sia in classe I-IV ...andrebbe parametrizzato

					if ($classiI_IV[$classe_cla] == "0") {
						$mostradoposcuola =	0; }
					else {
						$mostradoposcuola = $_SESSION['ISC_mostra_doposcuola'];
					}
					?>

				</div>
			</div>
		</div>
		
<!-- DATI ANAGRAFICI ******************************************************************** -->
		<form id="formiscrizione" style="margin-top: 100px; ">
			<div class="col-md-2 col-sm-6 col-md-offset-4" style="text-align: center; font-size: 14px;">
				<div class="row">
					Nome
				</div>
				<div class="row">
					<input class="tablecell5" type="text"  id="nome_alu" name="nome_alu" maxlength="50" value = "<?=$nome_alu?>">
				</div>
			</div>
			<div class="col-md-2 col-sm-6 " style="text-align: center; font-size: 14px;">
				<div class="row">
					Cognome
				</div>
				<div class="row">
					<input class="tablecell5" type="text"  id="cognome_alu" name="cognome_alu" maxlength="50" value = "<?=$cognome_alu?>">
				</div>
			</div>
			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px;">
				<?if ($mf_alu == "M") {$iscriverloa = "iscriverlo";} else {$iscriverloa= "iscriverla";}?>
				<input type="checkbox" style="margin-left: 20px;" id="ckNonIscritto" name="ckNonIscritto" <? if ($noniscritto_alu == 1) {echo ("checked");}?> >
				<label for="ckNonIscritto" style="margin-bottom: 0px;" >&nbsp;Non Intendiamo <?=$iscriverloa?> quest'anno</label>
			</div>
			<div class="col-md-4 col-sm-12 col-md-offset-4" style="margin-top: 10px; text-align: center; font-size: 14px; border-top: 1px solid grey; ">
				<? if ($mf_alu== "M") { echo("NATO"); } else { echo("NATA"); } ?>
			</div>
			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px; padding-bottom: 5px; padding-left:2px; padding-right: 2px;">				
				<div class="col-md-9 col-sm-9" style="text-align: center; font-size: 14px;">
					<div class="row">
						Comune
					</div>
					<div class="row">
						<input class="tablecell5 search-comune" type="text"  id="comunenascita_alu" name="comunenascita_alu" maxlength="50" value = "<?=$comunenascita_alu?>">
					</div>
					<div class="col-md-12 DropDownContainer">
						<div class="showcomuneB" name="showComuneNascita_alu" id="showComuneNascita_alu" ></div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3" style="text-align: center; font-size: 14px;">
					<div class="row">
						Prov
					</div>
					<div class="row">
						<input title="Se non nota indicare -" class="tablecell5" type="text"  id="provnascita_alu" name="provnascita_alu" maxlength="4" value = "<?=$provnascita_alu?>">
					</div>
				</div>
				<div class="col-md-8 col-sm-8" style="text-align: center; font-size: 14px;">
					<div class="row">
						Paese
					</div>
					<div class="row">
						<select style="width: 98%" id= "paesenascita_alu" name="paesenascita_alu">
							<option value="">-selezionare un paese-</option>	
							<? for ($x = 0; $x < $countriesN; $x++) {
								if(strtoupper($paesenascita_alu)==strtoupper($countries[$x])){
									echo "<option value='".strtoupper($countries[$x])."' selected>".strtoupper($countries[$x])."</option>";
								} else {
									echo "<option value='".strtoupper($countries[$x])."' >".strtoupper($countries[$x])."</option>";
								}
								
							}?>
						</select>
						<!--<input class="tablecell5" type="text"  id="paesenascitamadre_fam" name="paesenascitamadre_fam" value = "<?//=$paesenascitamadre_fam?>">-->
					</div>
				</div>
				<div class="col-md-4 col-sm-4" style="text-align: center; font-size: 14px;">
					<div class="row">
						Data
					</div>
					<div class="row">
						<input class="tablecell5 datepicker" type="text"  id="datanascita_alu" name="datanascita_alu" maxlength="10" value = "<?if($datanascita_alu!='0000-00-00' && $datanascita_alu!='1900-01-01' && $datanascita_alu!= NULL) {echo(date('d/m/Y', strtotime(str_replace('-','/', $datanascita_alu))));}?>">
					</div>
				</div>
				<div class="col-md-12 col-sm-12" style="text-align: center; font-size: 14px;">
					<div class="row">
						Cittadinanza
					</div>
					<div class="row">
						<input class="tablecell5" type="text"  id="cittadinanza_alu" name="cittadinanza_alu" maxlength = "16" onchange="makeuppercase(cittadinanza_alu)" value = "<?=$cittadinanza_alu?>" >
					</div>
				</div>
				<div class="col-md-12 col-sm-12" style="text-align: center; font-size: 14px;">
					<div class="row">
						Codice Fiscale
					</div>
					<div class="row">
						<input class="tablecell5" type="text"  id="cf_alu" name="cf_alu" maxlength = "16" onchange="makeuppercase(cf_alu)" value = "<?=$cf_alu?>" >
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px; border-top: 1px solid grey; margin-top: 10px; ">
				<div class="col-md-12 col-sm-12" style="display: flex; text-align: center; font-size: 10px;">
					<input value="copia da padre" class="btn btn-primary btn-cons" id="btn_copiadapadre" style="height: 25px; padding: 0px; margin-top: 5px; margin-bottom: 2px; margin-right: 10px; width: 80%; border-radius:15px; background: grey; " onclick="CopiaResPadreMadre('padre');" readonly></input> RESIDENTE <input value="copia da madre" class="btn btn-primary btn-cons" id="btn_copiadamadre" style="height: 25px; padding: 0px; margin-top: 5px; margin-bottom: 2px; margin-left: 10px; width: 80%; border-radius:15px; background: grey; " onclick="CopiaResPadreMadre('madre');" readonly></input>
				</div>
			</div>
			
			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px; padding-bottom: 5px; padding-left:2px; padding-right: 2px;">
				<div class="col-md-12 col-sm-12" style="text-align: center; font-size: 14px;">
					<div class="row">
						Indirizzo (Via e n. civico)
					</div>
					<div class="row">
						<input class="tablecell5" type="text"  id="indirizzo_alu" name="indirizzo_alu" maxlength="50" value = "<?=$indirizzo_alu?>">
					</div>
				</div>
				<div class="col-md-9 col-sm-9" style="text-align: center; font-size: 14px;">
					<div class="row">
						Comune
					</div>
					<div class="row">
						<input class="tablecell5 search-comune" type="text"  id="citta_alu" name="citta_alu" maxlength="50" value = "<?=$citta_alu?>">
					</div>
					<div class="col-md-12 DropDownContainer">
						<div class="showcomuneB" name="showComune_alu" id="showComune_alu" ></div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3" style="text-align: center; font-size: 14px;">
					<div class="row">
						Prov
					</div>
					<div class="row">
						<input title="Se non nota indicare -" class="tablecell5" type="text"  id="prov_alu" name="prov_alu" maxlength="4" value = "<?=$prov_alu?>">
					</div>
				</div>
				<div class="col-md-8 col-sm-8" style="text-align: center; font-size: 14px;">
					<div class="row">
						Paese
					</div>
					<div class="row">
						<select style="width: 98%" id= "paese_alu" name="paese_alu">
							<option value="">-selezionare un paese-</option>	
							<? for ($x = 0; $x < $countriesN; $x++) {
								if(strtoupper($paese_alu)==strtoupper($countries[$x])){
									echo "<option value='".strtoupper($countries[$x])."' selected>".strtoupper($countries[$x])."</option>";
								} else {
									echo "<option value='".strtoupper($countries[$x])."' >".strtoupper($countries[$x])."</option>";
								}
								
							}?>
						</select>
					</div>
				</div>
				<div class="col-md-4 col-sm-4" style="text-align: center; font-size: 14px;">
					<div class="row">
						CAP
					</div>
					<div class="row">
						<input class="tablecell5" type="text"  id="CAP_alu" name="CAP_alu" maxlength="5" value = "<?=$CAP_alu?>">
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px; border-top: 1px solid grey; margin-top: 10px; ">
				<div class="col-md-12 col-sm-12" style="display: flex; text-align: center; font-size: 14px;">
						<div class="col-md-6 col-sm-6" style="text-align: center; font-size:14px;">
							PROVIENE DALLA SCUOLA
						</div>
						<div class="col-md-6 col-sm-6" style="text-align: center; font-size:12px;">
							<input type="checkbox" style="margin-left: 20px; margin-top: 10px;" id="ckscuolawaldorf" name="ckscuolawaldorf" onclick="PopolaScuolaProvenienza()">&nbsp;Nessuna Scuola
							<!-- <input type="checkbox" style="margin-left: 20px;" id="ckscuolawaldorf" name="ckscuolawaldorf" onclick="PopolaScuolaProvenienza()" <?//if($scuolaprovenienza_alu==$nomescuola) {echo ("checked");}?>>&nbsp;<?//=$nickscuola?> -->
						</div>

				</div>
			</div>

			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px; padding-bottom: 5px; padding-left:2px; padding-right: 2px;">
				<div class="col-md-12 col-sm-12" style="text-align: center; font-size: 14px;">
					<div class="row">
						Nome Scuola
					</div>
					<div class="row">
						<input class="tablecell5" type="text"  id="scuolaprovenienza_alu" name="scuolaprovenienza_alu" maxlength="50" value = "<?=$scuolaprovenienza_alu?>">
					</div>
				</div>
				<div class="col-md-12 col-sm-12" style="text-align: center; font-size: 14px;">
					<div class="row">
						Indirizzo Scuola
					</div>
					<div class="row">
						<input class="tablecell5" type="text"  id="indirizzoscproven_alu" name="indirizzoscproven_alu" maxlength="50" value = "<?=$indirizzoscproven_alu?>">
					</div>
				</div>
			</div>

			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; border-top: 1px solid grey; margin-top: 10px; ">
				<div class="col-md-6 col-sm-12" style="display: flex; text-align: center; font-size:12px;">
					<input type="checkbox"  id="disabilita_alu" name="disabilita_alu" <?if ($disabilita_alu == 1) {echo ("checked");}?>>
					<label id ="lbldisabilita_alu" for="lbldisabilita_alu" style="margin-bottom: 1px;">&nbsp;Alunno/a con Disabilità</label>
				</div>
				<div class="col-md-6 col-sm-12" style="display: flex; text-align: center; font-size:12px;">
					<input type="checkbox"  id="DSA_alu" name="DSA_alu" <?if ($DSA_alu == 1) {echo ("checked");}?>>
					<label id ="lblDSA_alu" for="lblDSA_alu" style="margin-bottom: 1px;">&nbsp;Alunno/a con DSA</label>
				</div>
				<div class="col-md-12 col-sm-12" style="display: flex; text-align: center; font-size:12px; margin-top: 10px; ">
					Ai sensi della legge 104/1992 e della legge 170/2010, in caso di alunno, rispettivamente con disabilità o disturbi specifici di
					apprendimento (DSA), la domanda andrà perfezionata consegnando copia della certificazione entro 10 giorni dalla chiusura delle iscrizioni.
				</div>
			</div>

<!-- SCELTE ***************************************************************************** -->
	<?if ($mostrareligione==1 || $mostratrasporto==1 || $mostrauscitaautonoma ==1 || $mostramensa ==1  || $mostradoposcuola) {?>
			<div class="col-md-4 col-sm-12 col-md-offset-4 center fs14 mt10" style="border-top: 1px solid grey; padding: 5px 2px 0px 2px;">
				<span class="fs16 mb10">SCELTE</span>
				<div style="<?if ($mostrareligione!=1) {echo("display: none;");}?>">
					<br>ESERCIZIO DEL DIRITTO DI SCEGLIERE SE <br>AVVALERSI O NON AVVALERSI<br>DELL’INSEGNAMENTO DELLA RELIGIONE CATTOLICA
					<img title="Informazioni" class="iconaStd" src='../assets/img/Icone/info.svg' onclick="showModalInsegnamentoReligione();" style="position: absolute;  margin-top: -10px; width: 30px; right: 0px;">
					<div class="col-md-12 col-sm-12 col-xs-12 bb-dashed" id="lblckreligione_alu" style="padding-bottom: 2px;"  onchange="mostraNascodniAltReligione();">
						<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
							<input type="radio" class="ckreligione_alu" name="ckreligione_alu" value="1" <?if ($ckreligione_alu == 1) {echo "checked";}?> onclick="showMsgReligione(); return false; ">&nbsp;mi avvalgo
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
							<input type="radio" class="ckreligione_alu ml20" name="ckreligione_alu" value="-1" <?if ($ckreligione_alu == -1) {echo "checked";}?>>&nbsp;non mi avvalgo
						</div>
					</div>
					<div id="altreligioneBlock_alu" class="mt10 bb-dashed" style="margin-top: 10px!important; <?if ($ckreligione_alu == 1 || $ckreligione_alu == NULL) {echo("display: none");}?>">
						In alternativa alle ore di religione indicare la propria scelta:
						<select class="mb10 mt5 w50" id= "altReligioneSelect" name="altreligione_alu" onclick="showMsgReligione(); return false; ">
								<option value="1" <?if ($altreligione_alu ==1){echo("selected");}?> >Attività didattiche e Formative</option>	
								<option value="2" <?if ($altreligione_alu ==2){echo("selected");}?> >Attività di studio e/o ricerca individuali con assistenza docenti</option>
								<option value="3" <?if ($altreligione_alu ==3){echo("selected");}?> >Non frequenza della scuola nelle ore di insegnamento della religione cattolica</option>
								
						</select>
					</div>
				</div>
				
				<div style="<?if ($mostramensa!=1) {echo("display: none;");}?>">
					<br><br>MENSA SCOLASTICA
					<img title="Informazioni" class="iconaStd ml20" src='../assets/img/Icone/info.svg' onclick="showModalMensa();" style="position: absolute; margin-top: -10px; width: 30px; right: 0px;">
					<div class="col-md-12 col-sm-12 col-xs-12 bb-dashed" id="lblckmensa_alu" style="padding-bottom: 2px;">
						<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
							<input type="radio" class="ckmensa_alu" name="ckmensa_alu" value="1" <?if ($ckmensa_alu == 1) {echo "checked";}?>>&nbsp;mi avvalgo
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
							<input type="radio" class="ckmensa_alu ml20" name="ckmensa_alu" value="-1" <?if ($ckmensa_alu == -1) {echo "checked";}?>>&nbsp;non mi avvalgo
						</div>
					</div>
				</div>
				<div style="<?if ($mostrauscitaautonoma!=1 ) {echo("display: none;");}?>">
				
					<br><br>AUTORIZZAZIONE ALL'USCITA AUTONOMA
					<img title="Autorizzazione Uscita Autonoma" class="iconaStd ml20" src='../assets/img/Icone/info.svg' onclick="showModalUscitaAutonoma();" style="position: absolute; margin-top: -10px; width: 30px; right: 0px;">
					<div class="col-md-12 col-sm-12 col-xs-12 bb-dashed" id="lblckautuscitaautonoma_alu" style="padding-bottom: 2px;">
						<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
							<input type="radio" class="ckautuscitaautonoma_alu" name="ckautuscitaautonoma_alu" value="1" <?if ($ckautuscitaautonoma_alu == 1) {echo "checked";}?>>&nbsp;autorizzo
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
							<input type="radio" class="ckautuscitaautonoma_alu ml20" name="ckautuscitaautonoma_alu" value="-1" <?if ($ckautuscitaautonoma_alu == -1) {echo "checked";}?>>&nbsp;non autorizzo
						</div>
					</div>
				</div>
				<div style="<?if ($mostradoposcuola!=1 ) {echo("display: none;");}?>">
				
					<br><br>RICHIESTA DOPOSCUOLA
					<img title="Richiesta Doposcuola" class="iconaStd ml20" src='../assets/img/Icone/info.svg' onclick="showModalDoposcuola();" style="position: absolute; margin-top: -10px; width: 30px; right: 0px;">
					<div class="col-md-12 col-sm-12 col-xs-12" id="lblckdoposcuola_alu" style="padding-bottom: 2px;">
						<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
							<input type="radio" class="ckdoposcuola_alu" name="ckdoposcuola_alu" value="1" <?if ($ckdoposcuola_alu == 1) {echo "checked";}?>>&nbsp;richiedo
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
							<input type="radio" class="ckdoposcuola_alu ml20" name="ckdoposcuola_alu" value="-1" <?if ($ckdoposcuola_alu == -1) {echo "checked";}?>>&nbsp;non richiedo
						</div>
					</div>
				</div>
				<div style="<?if ($mostratrasporto!=1) {echo("display: none;");}?>">
				
					<br><br>RICHIESTA DI<br>TRASPORTO SCOLASTICO PUBBLICO
					<div class="col-md-12 col-sm-12 col-xs-12" id="lblcktrasportopubblico_alu" style="padding-bottom: 2px;">
						<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
							<input type="radio" class="cktrasportopubblico_alu" name="cktrasportopubblico_alu" value="1" <?if ($cktrasportopubblico_alu == 1) {echo "checked";}?>>&nbsp;richiedo
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
							<input type="radio" class="cktrasportopubblico_alu ml20" name="cktrasportopubblico_alu" value="-1" <?if ($cktrasportopubblico_alu == -1) {echo "checked";}?>>&nbsp;non richiedo
						</div>

					</div>
					<div class="col-md-12 mb15 center fs12">
						In caso di richiesta si prega di<br> completare il modulo nella sezione corrispondente.
					</div>
				</div>
				


			</div>
	<?}?>
<!-- DICHIARAZIONI ********************************************************************** -->

			<div class="col-md-4 col-sm-12 col-md-offset-4 center fs14 mt10" style="border-top: 1px solid grey; padding: 5px 2px 0px 2px;">
				<span class="fs16 mb10">DICHIARAZIONI ed AUTORIZZAZIONI</span>
				<br><br>DICHIARAZIONI DI CONSENSO <br>AL TRATTAMENTO DEI DATI PERSONALI

				<textarea class="fs10 w100" style="overflow-x: hidden" rows="5" readonly>- INFORMATIVA AI SENSI DELL'ART.13 DEL REGOLAMENTO UE 2016/679 -&#013;&#013;<?=$informativaprivacy?>
				</textarea>

				<!-- <textarea style="width: 100%; margin-top: 5px; font-size: 10px; " rows="5" readonly>
					- INFORMATIVA AI SENSI DELL'ART.13 DEL REGOLAMENTO UE 2016/679 -&#013;&#013;Nel ringraziarLa per averci fornito i Suoi dati personali, portiamo a Sua conoscenza le finalità e le modalità del trattamento cui essi sono destinati.&#013;Secondo quanto previsto dagli artt. 13 e 14 del REG. UE 2016/679  recante disposizioni sulla tutela della persona e di altri soggetti, rispetto al trattamento di dati personali questa Istituzione Scolastica, rappresentata dal presidente pro-tempore, in qualità di Titolare del trattamento dei dati personali, per espletare le sue funzioni istituzionali e, in particolare, per gestire le attività di istruzione, educative e formative stabilite dal ".$POF_PTOF_PSDext.", deve acquisire i dati personali che Vi riguardano, inclusi quei dati che il REG. UE 2016/679 definisce “dati personali relativi all'orientamento religioso, opinioni politiche e relativi alla salute”.&#013;Vi informiamo pertanto che, per le esigenze di gestione sopra indicate, possono essere oggetto di trattamento le seguenti categorie di dati:&#013-	dati relativi agli alunni, idonei a rilevare lo stato di salute, raccolti in riferimento a certificazioni di malattia, infortunio, esposizione a fattori di rischio, appartenenza a categorie protette, idoneità allo svolgimento di determinate attività, sorveglianza sanitaria;&#013;-	dati relativi agli alunni idonei a rilevare opinioni politiche o adesioni sindacali ed associative, derivanti da richieste di organizzazione o partecipazione ad attività opzionali, facoltative o stabilite autonomamente dagli organismi rappresentativi studenteschi;&#013;-	dati relativi agli alunni idonei a rilevare le convinzioni religiose o filosofiche ovvero l’adesione a organizzazioni di carattere religioso o filosofico,  o quali la fruizione di permessi e festività aventi tali carattere;&#013;Vi informiamo inoltre che il trattamento dei vostri dati personali avrà le seguenti finalità:&#013;-	partecipazione degli alunni alle attività organizzate in attuazione del ".$POF_PTOF_PSDext.";&#013;-	adempimento di obblighi derivanti da leggi, contratti, regolamenti in materia di igiene e sicurezza, in materia fiscale, in materia assicurativa;&#013;-	tutela dei diritti in sede giudiziaria.&#013;Vi forniamo a tal fine le seguenti ulteriori informazioni:&#013;-	Il trattamento dei dati personali sarà improntato a principi di correttezza, liceità e trasparenza e di tutela della Sua riservatezza e dei Suoi diritti anche in applicazione dell’art. 5 del REG. UE 2016/679;&#013;-	I dati personali verranno trattati anche con l’ausilio di strumenti elettronici o comunque automatizzati con le modalità e le cautele previste dal predetto REG. UE 2016/679 e conservati per il tempo necessario all’espletamento delle attività istituzionali e amministrative riferibili alle predette finalità;&#013;-	Sono adottate dalla scuola le misure minime per la sicurezza dei dati personali previste dal REG. UE 2016/679;&#013;-	Il titolare del trattamento è il presidente pro-tempore della <?//=$ragionesocialescuola?>;&#013;-	Gli incaricati al trattamento dati sono i docenti, gli assistenti amministrativi della Scuola, i collaboratori e i gestori espressamente autorizzati all'assolvimento di tali compiti, identificati ai sensi di legge, ed edotti dei vincoli imposti dal REG. UE 2016/679;&#013;-	I dati oggetto di trattamento potranno essere comunicati ai seguenti soggetti esterni all’istituzione scolastica per fini funzionali: Ufficio Scolastico Provinciale e Regionale, Comuni, ASL competente per territorio, Autorità di polizia del territorio.&#013;Vi ricordiamo infine:&#013;-	che il conferimento dei dati richiesti potrebbe essere indispensabile a questa istituzione scolastica per l'assolvimento dei suoi obblighi istituzionali;&#013;-	che, ai sensi dell’art. 2-ter del D. lgs. 196/2003, in alcuni casi il trattamento può essere effettuato anche senza il consenso dell’interessato;&#013;-	Le ricordiamo che gode dei diritti di cui agli artt. 15 e segg. del Regolamento UE 2016/679, fra cui il diritto di chiedere l’accesso ai dati personali e la rettifica o la cancellazione degli stessi o la limitazione del trattamento dei dati che la riguardano o di opporsi al loro trattamento; ha inoltre il diritto di proporre reclamo all’autorità di controllo competente in materia, Garante per la protezione dei dati personali.&#013;&#013;Il Titolare del trattamento dati &#013;<?//=$titolaretrattamento?></textarea> -->

				<div class="col-md-12 center fs12" id="bloccotreconsensi">
					<!--<input type="checkbox"  id="ckaccettazioneprivacy" name="ckaccettazioneprivacy">
					<label id ="lblaccettazioneprivacy" for="ckaccettazioneprivacy" style="margin-bottom: 0px;">Autorizzazione al trattamento dei dati personali <? //if ($mf_alu== "M") { echo("del figlio"); } else { echo("della figlia"); } ?></label>-->
					<div class="col-md-12 mb15 center fs14" style="text-decoration: underline;">
						<strong>I seguenti tre consensi <br>sono necessari<br>per dare seguito<br>all’iscrizione dell’alunno/a</strong>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12" id="lblckprivacy1_alu" style="padding-bottom: 2px;">
						<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
							<input type="radio" class="ckprivacy1_alu" name="ckprivacy1_alu" value="1" <?if ($ckprivacy1_alu == 1) {echo "checked";}?>>&nbsp;Presto il consenso
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
							<input type="radio" class="ckprivacy1_alu ml20" name="ckprivacy1_alu" value="-1" <?if ($ckprivacy1_alu == -1) {echo "checked";}?>>&nbsp;Nego il consenso
						</div>
					</div>
					<div class="col-md-12 mb15 center fs12">
						al trattamento dei dati personali al fine di permettere di<br>gestire le attività di<br>istruzione, educative e formative<br>stabilite dal <?=$POF_PTOF_PSDext?>
					</div>

					<div class="col-md-12 col-sm-12 col-xs-12" id="lblckprivacy2_alu" style="padding-bottom: 2px;">
						<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
							<input type="radio" class="ckprivacy2_alu" name="ckprivacy2_alu" value="1" <?if ($ckprivacy2_alu == 1) {echo "checked";}?>>&nbsp;Presto il consenso
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
							<input type="radio" class="ckprivacy2_alu ml20" name="ckprivacy2_alu" value="-1" <?if ($ckprivacy2_alu == -1) {echo "checked";}?>>&nbsp;Nego il consenso
						</div>
					</div>
					<div class="col-md-12 mb15 center fs12">
						al trattamento dei dati identificativi <br> degli orientamenti religiosi, politici<br> e relativi alla salute al solo fine di<br>permettere di gestire le attività di<br>istruzione, educative e formative<br>stabilite dal <?=$POF_PTOF_PSDext?>
						<img title="Informazioni" class="iconaStd" src='../assets/img/Icone/info.svg' onclick="showModalInfoTrattamento();" style="position: absolute;  margin-top: -40px; width: 30px; right: 0px;">
					</div>
					
					<div class="col-md-12 col-sm-12 col-xs-12" id="lblckprivacy3_alu" style="padding-bottom: 2px;">
						<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
							<input type="radio" class="ckprivacy3_alu" name="ckprivacy3_alu" value="1" <?if ($ckprivacy3_alu == 1) {echo "checked";}?>>&nbsp;Presto il consenso
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6" style="z-index: 100; text-align: center; font-size:12px;">
							<input type="radio" class="ckprivacy3_alu ml20" name="ckprivacy3_alu" value="-1" <?if ($ckprivacy3_alu == -1) {echo "checked";}?>>&nbsp;Nego il consenso
						</div>
					</div>
					<div class="col-md-12 center fs12">
						per l’invio di comunicazioni elettroniche<br>anche tramite SMS, MMS ecc. e/o posta elettronica E-MAIL<br>e/o fax ai recapiti da me forniti<br>per finalità informative
					</div>
					
				</div>
			</div>
			


			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px; margin-top: 10px; border-top: 1px solid grey; padding-bottom: 20px; padding-left:2px; padding-right: 2px;">
				UTILIZZO DELLE RIPRESE VIDEO E DELLE IMMAGINI FOTOGRAFICHE
				<textarea style="width: 100%; margin-top: 5px; font-size: 10px; " rows="5" readonly>
					LIBERATORIA PER UTILIZZO DI RIPRESE VIDEO E IMMAGINI FOTOGRAFICHE&#013;&#013;Informativa per la pubblicazione dei dati&#013;Ai sensi degli artt. 10 e 320 cod. civ. e degli artt. 96 e 97 legge 22.4.1941, n. 633, Legge sul diritto d’autore, unitamente all’art. 13 del D. Lgs. n. 196/2003 e degli artt. 13-14 Regolamento UE n. 676/2016, si informa che i dati personali conferiti con la liberatoria allegata saranno trattati con modalità cartacee e telematiche nel rispetto della vigente normativa e dei principi di correttezza, liceità, trasparenza e riservatezza; in tale ottica i dati forniti, ivi inclusi ritratti contenuti nelle fotografie, potranno essere utilizzati per la pubblicazione su sito internet, su carta stampata e/o su qualsiasi altro mezzo di diffusione, nonché conservate negli archivi informatici, con finalità a carattere  meramente collegato alle attività svolte.&#013;La richiesta ha ad oggetto un dato biometrico normativamente definito dall’art. 4, punto 14 del Regolamento UE n. 676/2016.&#013;A scopo di completezza si specifica che, in materia di privacy, rappresenta giurisprudenza consolidata il ritenere che una grave ed oggettiva imperfezione fisica o una deformazione del volto, possano essere considerate elementi sufficienti a legittimare il diniego del consenso all'inserimento della foto.&#013;Con riferimento alle foto e/o alle riprese audio/video scattate e/o riprese dalla Società <?=$ragionesocialescuola?> si richiede di autorizzare  la stessa a titolo gratuito, anche ai sensi degli artt. 10 e 320 cod. civ. e degli artt. 96 e 97 legge 22.4.1941, n. 633, Legge sul diritto d’autore, all’acquisizione di immagini e riprese video per la pubblicazione su sito internet, su carta stampata e/o su qualsiasi altro mezzo di diffusione, nonché alla conservazione di queste nei propri archivi informatici, con finalità a carattere meramente collegato alle attività svolte.</textarea>
				<div class="col-md-12 col-sm-12 col-xs-12" id="lblckautfoto_alu" style="text-align: center; font-size:12px; padding-bottom: 2px; ">
					<div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center; font-size:12px;">
						<input type="radio" class="ckautfoto_alu" name="ckautfoto_alu" value="1" <?if ($ckautfoto_alu == 1) {echo "checked";}?>>&nbsp;Autorizzo
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center; font-size:12px;">
						<input type="radio" style="margin-left: 20px;" class="ckautfoto_alu" name="ckautfoto_alu" value="-1" <?if ($ckautfoto_alu == -1) {echo "checked";}?>>&nbsp;Non Autorizzo
					</div>
				</div>
			</div>
			
			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px; margin-top: 10px; border-top: 1px solid grey; padding-bottom: 25px; padding-left:2px; padding-right: 2px;">
				UTILIZZO DEL MATERIALE PRODOTTO DALL'ALUNNO
				<textarea style="width: 100%; margin-top: 5px; font-size: 10px; " rows="5" readonly>
					LIBERATORIA PER UTILIZZO DI MATERIALE PRODOTTO DALL'ALUNNO&#013;&#013;Considerato che nello svolgimento delle attività per documentare i percorsi ed i progressi svolti ci si può trovare nella condizione di utilizzare elaborati di vario tipo (relazioni, disegni, temi, fotografie, filmati, registrazioni, ...)&#013;Si chiede di autorizzare l’Istituto a servirsi di tale documentazione a testimonianza e a corredo di quanto si realizza, nel rispetto della normativa sulla privacy.La presente autorizzazione, qualora fornita, potrà essere revocata in ogni tempo con comunicazione scritta da inviare via posta comune o e-mail.</textarea>
				<div class="col-md-12 col-sm-12 col-xs-12" id="lblckautmateriale_alu" style="text-align: center; font-size:12px; padding-bottom: 2px; ">
					<div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center; font-size:12px;">
						<input type="radio" class="ckautmateriale_alu" name="ckautmateriale_alu" value="1" <?if ($ckautmateriale_alu == 1) {echo "checked";}?>>&nbsp;Autorizzo
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center; font-size:12px;">
						<input type="radio" style="margin-left: 20px;" class="ckautmateriale_alu" name="ckautmateriale_alu" value="-1" <?if ($ckautmateriale_alu == -1) {echo "checked";}?>>&nbsp;Non Autorizzo
					</div>
				</div>
			</div>
			
			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px; margin-top: 10px; border-top: 1px solid grey; padding-bottom: 25px; padding-left:2px; padding-right: 2px;">
				AUTORIZZAZIONE ALLE USCITE DIDATTICHE
				<textarea style="width: 100%; margin-top: 5px; font-size: 10px; " rows="5" readonly>
					AUTORIZZAZIONE ALLE USCITE DIDATTICHE&#013;&#013;Si chiede di autorizzare le uscite didattiche sul territorio cittadino all’interno dell’orario scolastico. Tali uscite saranno man mano presentate ai genitori nell’ambito delle riunioni di classe. Sarà cura degli insegnanti dare avviso dell’uscita mediante brevi comunicazioni sul diario alcuni giorni prima delle visite previste. </textarea>
				<div class="col-md-12 col-sm-12 col-xs-12" id="lblckautuscite_alu" style="text-align: center; font-size:12px; padding-bottom: 2px; ">
					<div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center; font-size:12px;">
						<input type="radio" class="ckautuscite_alu" name="ckautuscite_alu" value="1" <?if ($ckautuscite_alu == 1) {echo "checked";}?>>&nbsp;Autorizzo
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center; font-size:12px;">
						<input type="radio" style="margin-left: 20px;" class="ckautuscite_alu" name="ckautuscite_alu" value="-1" <?if ($ckautuscite_alu == -1) {echo "checked";}?>>&nbsp;Non Autorizzo
					</div>
				</div>
			</div>
		</form>
		<div class="row">

		</div>


	</div>

<!-- MODALI ***************************************************************************** -->

	<div class="modal" id="modalAvvisoCampi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white" >   
					<span class="titoloModal">ATTENZIONE!</span>
					<div id="remove-content1" style="text-align: center;"> <!-- START REMOVE CONTENT -->
						<br>
						I campi evidenziati in rosso sono mancanti 
						<br>
						o compilati in maniera non corretta.
						<br>
						Per procedere è necessario correggere.
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer">
						<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="width:40%; border-radius:15px;" data-dismiss="modal" onclick="">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal" id="modalAvvisoConsensi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
						<span class="titoloModal">ATTENZIONE!</span>
						<div id="remove-content1" style="text-align: center;"> <!-- START REMOVE CONTENT -->
							<br>
							La negazione di uno qualsiasi dei tre consensi richiesti
							<br>
							per il trattamento dei dati impedisce 'de facto'
							<br>
							alla scuola di erogare il servizio scolastico.
							<br>
							Tali consensi sono necessari per dare corso all'iscrizione.
						</div> <!-- END REMOVE CONTENT -->
						<div class="modal-footer">
							<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="width:40%; border-radius:15px;" data-dismiss="modal" onclick="">OK</button>
						</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal" id="modalAvvisoNessunIscritto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
						<span class="titoloModal">ATTENZIONE!</span>
						<div id="remove-content1" style="text-align: center;"> <!-- START REMOVE CONTENT -->
							<br>
							Almeno uno dei figli va iscritto tramite questo portale
							<br>
							Modificare la propria scelta per proseguire.
						</div> <!-- END REMOVE CONTENT -->
						<div class="modal-footer">
							<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="width:40%; border-radius:15px;" data-dismiss="modal" onclick="">OK</button>
						</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="modalCheckBeforeForm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">ATTENZIONE!</span>
					<div id="remove-content1" style="text-align: center;"> <!-- START REMOVE CONTENT -->
						<br>
						Tornare allo step precedente
						<br>(Dati della madre)
						<br>implica che le modifiche correnti
						<br>ai dati compilati in questo modulo
						<br>non verranno salvate.
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer">
						<div class="col-md-6 col-sm-12">
							<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="margin-top: 5px; width: 90%; border-radius:15px; height: 34px; font-size: 11px; " data-dismiss="modal" onclick="GoBack();">< Dati della madre</button>
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

	$('body').click(function () {
		$('.showcomuneB').hide();
	});


	function CheckBeforeForm2(){
		$('#modalCheckBeforeForm2').modal('show');
	}
	
	function GoBack(){
		window.location.href = "FormIscrizione2.php";
	}
	
	
	
	function CheckBeforeFormNext(){
		if ($('#ckNonIscritto').is(":checked")) {
			let NonIscritto = 1;
			console.log ("non iscritto");
			SaveAndGoNext(); //attenzione: va salvato diversamente dal caso standard
		} else {
			let NonIscritto = 0;
			//verifica che i dati obbligatori ci siano tutti
			let campo = ["comunenascita_alu", "provnascita_alu", "paesenascita_alu", "cittadinanza_alu", "cf_alu", "indirizzo_alu", "citta_alu", "prov_alu", "paese_alu", "CAP_alu", "ckprivacy1_alu", "ckprivacy2_alu", "ckprivacy3_alu", "ckautfoto_alu", "ckautmateriale_alu", "ckautuscite_alu", "datanascita_alu", "scuolaprovenienza_alu", "indirizzoscproven_alu", "ckautuscitaautonoma_alu", "ckreligione_alu", "ckmensa_alu", "cktrasportopubblico_alu", "ckdoposcuola_alu"  ];
			let campodesc = ["Comune di Nascita", "Provincia di Nascita", "Paese di Nascita", "Cittadinanza", "Codice Fiscale", "Via e N. Civico", "Comune di Residenza", "Provincia di Residenza", "Paese di Residenza", "CAP di residenza", "Privacy1", "Privacy2", "Privacy3", "Autorizzazione uso Foto e Video", "Autorizzazione Materiale Prodotto", "Autorizzazione Uscite Didattiche", "Data di nascita Alunno", "Scuola di provenienza", "Indirizzo Scuola di provenienza", "Uscita Autonoma", "Scelta Insegnamento Religione", "Mensa", "Trasporto Pubblico", "Doposcuola"];
			//ci sono dei campi che in alcuni casi non vanno controllati: dipende dai parametri di iscrizione
			let controllacampo = [ 1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,$('#mostrauscitaautonoma_hidden').val(),$('#mostrareligione_hidden').val(),$('#mostramensa_hidden').val(),$('#mostratrasporto_hidden').val(), $('#mostradoposcuola_hidden').val()];
			let campomissing = [];
			let missingfields = 0;
			
			for (i = 0; i <= 23; i++) {
				//solo i campi da controllare vengono controllati in base alla matrice controllacampo, che include i valori dei parametri
				if (controllacampo[i] == 1) {  
					camponame = campo[i];
					//console.log (camponame);
					if ((camponame.substring(0, 2)) == "ck") {
						if ($('.'+campo[i]).is(':checked') == false){
							$('#lbl'+campo[i]).css("border", "1px solid red");
							campomissing[missingfields]=campodesc[i];
							missingfields++;
							//console.log (camponame+" Y: #"+campo[i]+"Y "+ ($('#'+campo[i]+"Y").is(':checked'))+" N: #"+campo[i]+"N "+($('#'+campo[i]+"N").is(':checked')));
						} else {
							$('#lbl'+campo[i]).css("border", "0px");
							//console.log (camponame+" ok");
						}
					} else if ((camponame.substring(0, 4)) == "data") {
						datavalida = moment($('#'+campo[i]).val(), 'DD/MM/YYYY', true).isValid(); 
						if ((!(datavalida)) || ($('#'+campo[i]).val()=="")) {
							$('#'+campo[i]).css("border", "1px solid red");
							campomissing[missingfields]=campodesc[i];
							missingfields++;
							//console.log (camponame+" missing or not ok");
						} else {
							$('#'+campo[i]).css("border", "1px solid grey");
							//console.log (camponame+" ok");
						}
					} else {
						if ($('#'+campo[i]).val()=="") {
							$('#'+campo[i]).css("border", "1px solid red");
							campomissing[missingfields]=campodesc[i];
							missingfields++;
							//console.log (camponame+" missing");
						} else {
							$('#'+campo[i]).css("border", "1px solid grey");
							//console.log (camponame+" ok");
						}
					}
				}
			}
			
			cflength = $('#cf_alu').val().length;
					
			if (cflength!= 16) {
				$('#cf_alu').css("border", "1px solid red");
				campomissing[missingfields]="Codice Fiscale";
				missingfields++;	
			} else {
				$('#cf_alu').css("border", "1px solid grey");
			}
			
			
			if (missingfields == 0) {
				CheckConsensi();
			} else {
				$('#modalAvvisoCampi').modal('show');
			}

		}
	}

	function CheckConsensi(){

		
		let campo = ["ckprivacy1_alu", "ckprivacy2_alu", "ckprivacy3_alu"];
		let consensiOK = 1;
		for (j = 0; j <=2; j++) {
			if ($("input[name='"+campo[j]+"']:checked").val() == -1) {
				consensiOK = 0;
			}
		}
		if (consensiOK == 0) {
			$('#modalAvvisoConsensi').modal('show');
			$('#bloccotreconsensi').css("border", "1px solid red");
		} else {
			$('#bloccotreconsensi').css("border", "0px");
			SaveAndGoNext();
		}
	}
	
	
	function SaveAndGoNext (){
	
			let postData = $("#formiscrizione").serializeArray();
			postData.push( {name: "ID_alu", value: $("#ID_alu_hidden").val() });
			//console.log("FormIscrizione3.php - SaveAndGoNext - postData a qry_UpdateFratello.php");
			//console.log (postData);
			//return;
			$.ajax({
				url : "qry_updateFratello.php",
				type: "POST",
				data : postData,
				dataType: "json",
				success:function(data){
					console.log("FormIscrizione3.php - SaveAndGoNext - ritorno da qry_UpdateFratello.php");
					console.log (data.test);
					console.log (data.array2);
					console.log (data.array);
					console.log ("POST disabilita_alu (Valcampo13): "+data.test2)
					$.ajax({
						url : "qry_checkFratelliNonIscritti.php",
						type: "POST",
						data : postData,
						dataType: "json",
						success:function(data2){
							if (data2.iscritti == 0) {
								$('#modalAvvisoNessunIscritto').modal('show');
							} else {
								//devo stabilire cosa sia "next" se il prossimo fratello oppure il moduloIscrizione4
								//utilizzo a questo scopo i dati inclusi in n_fratello_hidden e n_fratelli_hidden
								let n_fratello = $('#n_fratello_hidden').val();
								let n_fratelli = $('#n_fratelli_hidden').val();
								
								console.log (data.sql);
								console.log (data.array);
								console.log (data.array2);
								if (n_fratello == n_fratelli) {
									//questo è l'ultimo fratello quindi devo fare il redirect a FormIscrizione4
									updateStatusFamiglia(60, "FormIscrizione4.php");
									

								} else {
									let url = "FormIscrizione3.php";
									let form = $('<form id="tmpform" action="' + url + '"method="post">' + '<input type="text" name ="num_fratello" value ="'+ (parseInt(n_fratello)+1)+'" ></form>');
									$('body').append(form);
									form.submit();
									var element =  document.getElementById('tmpform');
									element.remove();

								}
							}
						}
					});	

					
					

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
	
	function PopolaScuolaProvenienza(){
		if ($('#ckscuolawaldorf').is(':checked')) {
			//$('#scuolaprovenienza_alu').val($('#nomescuola_hidden').val());
			//$('#indirizzoscproven_alu').val($('#indirizzoscuola_hidden').val());
			$('#scuolaprovenienza_alu').val("nessuna scuola");
			$('#indirizzoscproven_alu').val("---");
		} else {
			//$('#scuolaprovenienza_alu').val("");
			//$('#indirizzoscproven_alu').val("");
			$('#scuolaprovenienza_alu').val("");
			$('#indirizzoscproven_alu').val("");

		}
	}
//******************** funzioni per la ricerca ajax del Comune, CAP, Prov, Paese *************************************************

	$('#comunenascita_alu').on("keyup input", function(){
		$('#showComuneNascita_alu').show();
	});

	$('#citta_alu').on("keyup input", function(){
		$('#showComune_alu').show();
	});

	$('.search-comune').on("keyup input", function(){
		campo = $(this).attr("name");
		let inputVal = $(this).val();
		switch (campo) {
			case "comunenascita_alu":
				resultDropdown = $("#showComuneNascita_alu");
				resultProv = $("#provnascita_alu");
			break;
			case "citta_alu":
				resultDropdown = $("#showComune_alu");
				resultProv = $("#prov_alu");
			break;
		}
		if(inputVal.length>2){
				$.get("qry_DropDownComune.php", {inputVal: inputVal}).done(function(data){
				if (data=="") { resultProv.val("--"); } //se uno scrive BERLINO o DJAKARTA non viene trovato nulla...e qualcosa voglio scrivere nella Provincia, comunque
				resultDropdown.html(data);
				});
		} else {
			resultDropdown.empty();
		}
	});
	
	$(document).on("click", ".showcomuneB p", function(){
		campo = $(this).parent().attr("name");
		selected = $(this).text();
		ID_cap = selected.substr(0,selected.indexOf("+"));
		comuneselected = $("#comuneselected"+ID_cap).val();
		provselected = $("#provselected"+ID_cap).val();
		paeseselected = "ITALIA";
		CAPselected = $("#CAPselected"+ID_cap).val();
		switch (campo) {
			case "showComuneNascita_alu":
				$("#comunenascita_alu").val(comuneselected);
				$("#provnascita_alu").val(provselected);
				$("#paesenascita_alu").val(paeseselected);
			break;
			case "showComune_alu":
				$("#citta_alu").val(comuneselected);
				$("#prov_alu").val(provselected);
				$("#paese_alu").val(paeseselected);
				$("#CAP_alu").val(CAPselected);
			break;
		}
			$(this).parent().empty();
	});

	function CopiaResPadreMadre(padremadre) {

		postData = {copiada: padremadre};
		//console.log (postData);
		$.ajax({
			url : "qry_CopiaResidenza.php",
			type: "POST",
			data : postData,
			dataType: "json",
			success:function(data){
				$("#citta_alu").val(data.comune);
				$("#prov_alu").val(data.prov);
				$("#CAP_alu").val(data.CAP);
				$("#paese_alu").val(data.paese);
				$("#indirizzo_alu").val(data.indirizzo);
				//console.log (data.sql);
			}
		});
	}
	
	function CheckBeforeLogout(){
		$('#modalCheckBeforeLogout').modal('show');
	}
	function Logout() {
		window.location.href = "Logout.php";
	}

	function NonIscritto () {
		if ($('#ckNonIscritto').is(":checked")) {
			//verifico che non siano tutti i fratelli disiscritti perchè in qs caso blocco tutto
			postData = {name: "ID_alu", value: $("#ID_alu_hidden").val() };
			$.ajax({
				url : "qry_checkFratelliNonIscritti.php",
				type: "POST",
				data : postData,
				dataType: "json",
				success:function(data){
					console.log (data.noniscritti)
				}
			});	
		}
	}

	function makeuppercase (controllo) {
		str = $(controllo).val();
		str2 = str.toUpperCase();
		$(controllo).val(str2);
	}

	function showModalInfoTrattamento() {
		$('#titolo01Msg_OK').html('TRATTAMENTO DEI DATI PERSONALI');
		$('#msg01Msg_OK').html("A fronte di alcune perplessita' sollevate in merito alla richiesta di questo consenso<br>precisiamo che esso viene richiesto ESCLUSIVAMENTE<br> per consentire la gestione delle attivita' didattiche<br>e strutturare una idonea relazione tra docenti ed alunni.<br><br>Per citare un esempio comune i docenti devono essere nelle condizioni<br>di poter ricevere e conservare (a soli fini didattici) il tema di un alunno<br>nel quale siano contenute informazioni di carattere religioso o politico<br>(immaginiamo ad esempio che l'alunno citi il fatto di essere andato a Messa<br>o di non poter mangiare la carne di maiale per motivi religiosi,<br>o che racconti di aver partecipato ad una manifestazione).<br><br>Allo stesso modo il personale scolastico deve essere per esempio nella condizione<br>di poter gestire un'informazione relativa alla dieta di un alunno (e quindi alla sua salute)<br>dato che presenzia al pranzo della classe;<br>così come deve sapere se l'alunno soffre di qualche specifica patologia<br> per la quale deve poter intervenire in caso di bisogno.<br><br>Qualsiasi informazione raccolta non viene dischiusa a terzi<br>come richiesto dalla vigente normativa sulla Privacy.");
		$('#modal01Msg_OK').modal('show');
	}

	function showModalInsegnamentoReligione() {
		$('#titolo01Msg_OK').html('INSEGNAMENTO DELLA RELIGIONE');
		$('#msg01Msg_OK').html("Premesso che lo Stato assicura l'insegnamento della religione cattolica<br>nelle scuole di ogni ordine e grado in conformità all’accordo che apporta modifiche<br> al Concordato Lateranense (art. 9.2),<br> il presente modulo costituisce richiesta dell'autorità scolastica in ordine <br>all'esercizio del diritto di scegliere se avvalersi o non avvalersi<br>dell’insegnamento della religione cattolica.<br>La scelta operata ha effetto per l'intero anno scolastico e per i successivi anni di corso<br>in cui è prevista l'iscrizione d’ufficio,<br>fermo restando il diritto di scegliere ogni anno di avvalersi/non avvalersi<br>dell'insegnamento della religione cattolica.<br>Pertanto, in caso di variazioni, si prega di dare comunicazione in segreteria <br>all’atto del rinnovo delle iscrizioni.");
		$('#modal01Msg_OK').modal('show');
	}

	function showModalUscitaAutonoma() {
		$('#titolo01Msg_OK').html('USCITA AUTONOMA');
		$('#msg01Msg_OK').html("Gli allievi, al termine delle lezioni, vengono accompagnati fuori dalla scuola<br>dai maestri ed affidati ai genitori o a persone autorizzate<br>secondo le modalità indicate dai genitori con delega<br>(e allegata copia del documento d’identità del delegato)<br>e compilando l’apposito modulo di delega<br>che sarà disponibile a settembre in occasione dell’avvio dell’anno scolastico.<br><br>SOLO DALLA QUINTA CLASSE<br> è possibile l’uscita autonoma che prevede questa autorizzazione<br>e la successiva sottoscrizione del modulo apposito");
		$('#modal01Msg_OK').modal('show');
	}

	function showModalDoposcuola() {
		$('#titolo01Msg_OK').html('DOPOSCUOLA');
		$('#msg01Msg_OK').html("Il servizio consiste in attività extra scolastiche,<br>e non nello svolgimento dei compiti assegnati per casa,<br>e sarà attivato al raggiungimento del numero minimo<br>necessario per la copertura dei relativi costi.<br>L'importo pattuito è annuale, indipendentemente dal numero di presenze<br> dell'alunno/a, ferie scolastiche, gite, uscite didattiche, ecc...,<br>può essere pagato in un'unica soluzione <br>o ripartito in 9 rate da ottobre a giugno<br>entro il giorno 5 di ogni mese.");
		$('#modal01Msg_OK').modal('show');
	}

	function showModalMensa() {
		testoarticolomensa = $('#testoarticolomensa_hidden').val();
		$('#titolo01Msg_OK').html('MENSA SCOLASTICA');
		$('#msg01Msg_OK').html("Consapevole/i che il diritto allo studio si realizza anche attraverso<br>la fruizione del servizio di mensa "+testoarticolomensa+"<br>indicare l’intenzione di avvalersi o non avvalersi del servizio mensa.<br>Tale indirizzo, espresso all'atto dell'iscrizione<br>ha effetto per l'intero anno scolastico cui si riferisce.");
		$('#modal01Msg_OK').modal('show');
	}

	function mostraNascodniAltReligione () {
		console.log("fire");

		if ($('input[name="ckreligione_alu"]:checked').val() == -1) {
			$("#altreligioneBlock_alu").show();
		} else {
			$("#altreligioneBlock_alu").hide();
		};
	}

	function showMsgReligione(){
		$('#titolo01Msg_OK').html('SCELTA DELLA RELIGIONE');
		$('#msg01Msg_OK').html("Per modificare questa selezione vi preghiamo di rivolgervi preventivamente in segreteria. GRAZIE.");
		$('#modal01Msg_OK').modal('show');
	}
</script>
