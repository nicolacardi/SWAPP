<?
	include_once("../database/databaseBii.php");
	include_once("../assets/functions/functions.php");
	include_once("../assets/functions/ifloggedinIscrizioni.php");
	include_once("diciture.php");
	include_once("dicitureInformativaPrivacy.php");

	include_once ('../modal01Msg_OK.html');
	include_once ('../modal02Msg_OKCancel.html');


?>

<!DOCTYPE html>
<html style="overflow-x: hidden; width: 100%;  height: 100%; ">
<head>
	<title>Scheda Madre</title>
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

	<? $_SESSION['page'] = "Scheda Iscrizione - Madre";?>

</head>
 
<body class="adaptpaddingbottom" style="background-image: url('../assets/img/background4.jpg'); width: auto !important; background-size: cover; overflow-x: hidden !important;  padding-bottom: 100px;">

<!-- ESTRAZIONE DATI ******************************************************************** -->

	<? $ISC_mostra_soci = $_SESSION['ISC_mostra_soci'];?>
	<input type="text" id="codscuola" value ="<?=$codscuola?>" hidden>

	<?
	$countries = array("Italia", "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antigua e Barbuda", "Antille Olandesi", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belgio", "Belize", "Benin", "Bermuda", "Bhutan", "Bielorussia", "Bolivia", "Bosnia Herzegowina", "Botswana", "Bouvet Island", "Brasile", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambogia", "Camerun", "Canada", "Capo Verde", "Cayman", "Chad", "Cile", "Cina", "Città del Vaticano", "Colombia", "Comoros", "Congo", "Congo, Rep. Democratica del", "Corea, Repubblica popolare democratica di", "Corea, Repubblica della", "Costa Rica", "Costa d'Avorio", "Croazia", "Cuba", "Cipro", "Danimarca", "Djibouti", "Dominica", "East Timor", "Ecuador", "Egitto", "El Salvador", "Eritrea", "Estonia", "Etiopia", "Fiji", "Filippines", "Finlandia", "Francia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germania", "Ghana", "Giappone",  "Gibilterra", "Giordania", "Grecia", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guiana Francese", "Guinea", "Guinea-Bissau", "Guinea Equatoriale", "Guyana", "Haiti", "Honduras", "Islanda", "India", "Indonesia", "Iran (Repubblica Islamica dell')", "Iraq", "Irlanda", "Isole Christmas", "Isole Cocos (Keeling)", "Isole Cook", "Isole Falkland (Malvinas)", "Isole Faroe", "Isole Heard and Mc Donald", "Isole Marshall", "Isole Solomon", "Isole Svalbard e Jan Mayen", "Isole Turks and Caicos", "Isole Vergini (British)", "Isole Vergini (U.S.)", "Isole Wallis e Futuna","Israele", "Jamaica", "Kazakhstan", "Kenia", "Kiribati", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lesotho", "Libano", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lituania", "Lussemburgo",  "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malesia", "Maldive", "Mali", "Malta", "Marocco", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Messico", "Micronesia, Federazione della", "Moldova, Repubblica della", "Monaco", "Mongolia", "Montserrat", "Mozambico", "Myanmar", "Namibia", "Nauru", "Nepal",  "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norvegia",  "Nuova Caledonia", "Nuova Zelanda", "Olanda", "Oman", "Pakistan", "Palau", "Panama", "Papua Nuova Guinea", "Paraguay", "Peru", "Pitcairn", "Polonia", "Polinesia Francese", "Portogallo", "Puerto Rico", "Qatar", "Repubblica Ceca", "Repubblica Centroafricana", "Republica Dominicana", "Reunion", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Repubblica della)", "Slovenia", "Somalia",  "South Georgia and the South Sandwich Islands", "Spagna", "Sri Lanka", "Stati Uniti d'America", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname",  "Sudafrica", "Svezia", "Svizzera","Swaziland",  "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, Repubblica della", "Thailandia", "Togo", "Tokelau", "Tonga", "Trinidad e Tobago", "Tunisia", "Turchia", "Turkmenistan",  "Tuvalu", "Ucraina", "Uganda",  "Ungheria", "United Arab Emirates", "UK",  "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
	$countriesN = count($countries);

	$annoiscrizioni = $_SESSION['anno_iscrizioni'];

	$sql = "SELECT `cognome_fam`, ".
	//"sociopadre_fam, cognomepadre_fam, nomepadre_fam, datanascitapadre_fam, comunenascitapadre_fam, provnascitapadre_fam, paesenascitapadre_fam, cfpadre_fam, indirizzopadre_fam, comunepadre_fam, CAPpadre_fam, provpadre_fam, paesepadre_fam, telefonopadre_fam, altrotelpadre_fam, emailpadre_fam, titolopadre_fam, profpadre_fam ".
	"sociopadre_fam, sociomadre_fam, cognomemadre_fam, nomemadre_fam, datanascitamadre_fam, comunenascitamadre_fam, provnascitamadre_fam, paesenascitamadre_fam, cfmadre_fam, indirizzomadre_fam, comunemadre_fam, CAPmadre_fam, provmadre_fam, paesemadre_fam, telefonomadre_fam, altrotelmadre_fam, emailmadre_fam, titolomadre_fam, profmadre_fam, ckautorizzazionemadre_fam, ckcarpoolingmadre_fam ".
	"FROM `tab_famiglie` WHERE `ID_fam`= ?";
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_bind_param($stmt, "i", $_SESSION['ID_fam']);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $cognome_fam, $sociopadre_fam, $sociomadre_fam, $cognomemadre_fam, $nomemadre_fam, $datanascitamadre_fam, $comunenascitamadre_fam, $provnascitamadre_fam, $paesenascitamadre_fam, $cfmadre_fam, $indirizzomadre_fam, $comunemadre_fam, $CAPmadre_fam, $provmadre_fam, $paesemadre_fam, $telefonomadre_fam, $altrotelmadre_fam, $emailmadre_fam, $titolomadre_fam, $profmadre_fam, $ckautorizzazionemadre_fam, $ckcarpoolingmadre_fam);
			while (mysqli_stmt_fetch($stmt)) {
			}?>
			

	<? include("../assets/functions/autologoff.php"); ?>
<!-- HEADER e HIDDEN VALUES ************************************************************* -->

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
	
			<div class="col-md-6 col-sm-12 col-md-offset-3" style="z-index: 200; margin-top: 3px; text-align: center; ">
				<input value="< Padre" class="btn btn-primary btn-cons buttonresponsive" id="btn_back" style="border-radius:30px; background: grey; " onclick="CheckBeforeForm1();" readonly></input>
				<img class="responsive12345" title="Status" style="text-align: center; cursor: pointer" src="../assets/img/12345/2.png">
				<input value="Salva >" class="btn btn-primary btn-cons buttonresponsive" id="btn_proceed" style="border-radius:15px; background: grey; " onclick="CheckBeforeForm3();" readonly></input>
			</div>


			<div class="col-md-8 col-sm-12 col-md-offset-2" style="text-align: center; font-size: 14px;">
				<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 24px; color: #3c3c3c;" >
					Dati della Madre
				</div>
			</div>
			<div class="col-md-12" style="text-align: center; color: #3c3c3c; margin-bottom: 0px;" >
				<span style="font-size: 12px;">(o tutore/affidatario se presente)</span>
			</div>
			<div class="row">
				<div class="col-md-12" style="text-align: center; font-size: 16px; margin-left: 40px;">
					<input id="ID_fam_hidden" name="ID_fam_hidden" value="<?=$_SESSION['ID_fam'];?>" hidden>
				</div>
			</div>
		</div>
		<form id="formiscrizione" style="margin-top: 100px; ">
			<div class="row" style="text-align: center; font-size: 14px; <?if ($ISC_mostra_soci == 0) {echo("display:none");}?>"">

					<input type="checkbox"  id="sociomadre_fam" name="sociomadre_fam" <? if ($sociomadre_fam == 1) { echo ('checked');} ?> >
					<label for="sociomadre_fam" style="margin-bottom: 0px;" >Socia della <?=$formagiuridica?></label>

					<input type="checkbox"  id="sociopadre_fam" name="sociopadre_fam" <? if ($sociopadre_fam == 1) { echo ('checked');} ?> hidden>
					 					 
					<input id="ISC_mostra_carpooling" 								value="<?=$_SESSION['ISC_mostra_carpooling'];?>" 		hidden>
					<?$ISC_mostra_carpooling=$_SESSION['ISC_mostra_carpooling'];?>

			</div>
<!-- DATI ANAGRAFICI ******************************************************************** -->
			<div class="col-md-2 col-sm-6 col-md-offset-4" style="text-align: center; font-size: 14px;">
				<div class="row">
					Nome
				</div>
				<div class="row">
					<input class="tablecell5" type="text"  id="nomemadre_fam" name="nomemadre_fam" maxlength="50" value = "<?=$nomemadre_fam?>">
				</div>
			</div>
			<div class="col-md-2 col-sm-6 " style="text-align: center; font-size: 14px;">
				<div class="row">
					Cognome
				</div>
				<div class="row">
					<input class="tablecell5" type="text"  id="cognomemadre_fam" name="cognomemadre_fam" maxlength="50" value = "<?=$cognomemadre_fam?>">
				</div>
			</div>
			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px; border-top: 1px solid grey; margin-top: 10px;  ">
				NATA
			</div>
			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px; padding-bottom: 5px; padding-left:2px; padding-right: 2px;">				
				<div class="col-md-9 col-sm-9" style="text-align: center; font-size: 14px;">
					<div class="row">
						Comune
					</div>
					<div class="row">
						<input class="tablecell5 search-comune" type="text"  id="comunenascitamadre_fam" name="comunenascitamadre_fam" maxlength="50" value = "<?=$comunenascitamadre_fam?>">
					</div>
					<div class="col-md-12 DropDownContainer">
						<div class="showcomuneB" name="showComuneNascita_fam" id="showComuneNascita_fam" ></div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3" style="text-align: center; font-size: 14px;">
					<div class="row">
						Prov
					</div>
					<div class="row">
						<input title="Se non nota indicare -" class="tablecell5" type="text"  id="provnascitamadre_fam" name="provnascitamadre_fam" maxlength="4" value = "<?=$provnascitamadre_fam?>">
					</div>
				</div>
				<div class="col-md-8 col-sm-8" style="text-align: center; font-size: 14px;">
					<div class="row">
						Paese
					</div>
					<div class="row">
						<select style="width: 98%" id= "paesenascitamadre_fam" name="paesenascitamadre_fam">
							<option value="">-selezionare un paese-</option>	
							<? for ($x = 0; $x < $countriesN; $x++) {
								if(strtoupper($paesenascitamadre_fam)==strtoupper($countries[$x])){
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
						<input class="tablecell5 datepicker" type="text"  id="datanascitamadre_fam" name="datanascitamadre_fam" maxlength="10" value = "<?if($datanascitamadre_fam!='0000-00-00' && $datanascitamadre_fam!='1900-01-01' && $datanascitamadre_fam!= NULL) {echo(date('d/m/Y', strtotime(str_replace('-','/', $datanascitamadre_fam))));}?>">
					</div>
				</div>
				<div class="col-md-12 col-sm-12" style="text-align: center; font-size: 14px;">
					<div class="row">
						Codice Fiscale
					</div>
					<div class="row">
						<input class="tablecell5" type="text"  id="cfmadre_fam" name="cfmadre_fam" maxlength = "16" onchange="makeuppercase(cfmadre_fam)" value = "<?=$cfmadre_fam?>" >
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px; border-top: 1px solid grey; margin-top: 10px; ">
				<div class="col-md-6 col-sm-12" style="margin-top: 5px; ">
					RESIDENTE
				</div>
				<div class="col-md-6 col-sm-12" style="text-align: center; font-size: 14px;">
					<input value="Copia res. del padre" class="btn btn-primary btn-cons" id="btn_copiarespadre" style="padding: 0px; height: 25px; margin-top: 5px; margin-bottom: 2px; width: 100%; border-radius:15px; background: grey; " onclick="CopiaResPadre();" readonly></input>
				</div>
			</div>
			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px; padding-bottom: 5px; padding-left:2px; padding-right: 2px; border-bottom: 1px solid grey; ">
				<div class="col-md-12 col-sm-12" style="text-align: center; font-size: 14px;">
					<div class="row">
						Indirizzo (Via e n. civico)
					</div>
					<div class="row">
						<input class="tablecell5" type="text"  id="indirizzomadre_fam" name="indirizzomadre_fam" maxlength="50" value = "<?=$indirizzomadre_fam?>">
					</div>
				</div>
				<div class="col-md-9 col-sm-9" style="text-align: center; font-size: 14px;">
					<div class="row">
						Comune
					</div>
					<div class="row">
						<input class="tablecell5 search-comune" type="text"  id="comunemadre_fam" name="comunemadre_fam" maxlength="50" value = "<?=$comunemadre_fam?>">
					</div>
					<div class="col-md-12 DropDownContainer">
						<div class="showcomuneB" name="showComune_fam" id="showComune_fam" ></div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3" style="text-align: center; font-size: 14px;">
					<div class="row">
						Prov
					</div>
					<div class="row">
						<input title="Se non nota indicare -" class="tablecell5" type="text"  id="provmadre_fam" name="provmadre_fam" maxlength="4" value = "<?=$provmadre_fam?>">
					</div>
				</div>
				<div class="col-md-8 col-sm-8" style="text-align: center; font-size: 14px;">
					<div class="row">
						Paese
					</div>
					<div class="row">
						<select style="width: 98%" id= "paesemadre_fam" name="paesemadre_fam">
							<option value="">-selezionare un paese-</option>	
							<? for ($x = 0; $x < $countriesN; $x++) {
								if(strtoupper($paesemadre_fam)==strtoupper($countries[$x])){
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
						<input class="tablecell5" type="text"  id="CAPmadre_fam" name="CAPmadre_fam" maxlength="5" value = "<?=$CAPmadre_fam?>">
					</div>
				</div>
			</div>
			<div class="col-md-2 col-sm-6 col-md-offset-4" style="text-align: center; font-size: 14px;">
				<div class="row">
					Telefono
				</div>
				<div class="row">
					<input class="tablecell5" type="text"  id="telefonomadre_fam" name="telefonomadre_fam" maxlength="20" value = "<?=$telefonomadre_fam?>">
				</div>
			</div>
			<div class="col-md-2 col-sm-6 " style="text-align: center; font-size: 14px;">
				<div class="row">
					Altro telefono
				</div>
				<div class="row">
					<input class="tablecell5" type="text"  id="altrotelmadre_fam" name="altrotelmadre_fam" maxlength="20" value = "<?=$altrotelmadre_fam?>">
				</div>
			</div>
			<div class="col-md-3 col-sm-6 col-md-offset-4" style="text-align: center; font-size: 14px;">
				<div class="row">
					indirizzo e-mail
				</div>
				<div class="row">
					<input class="tablecell5" type="text"  id="emailmadre_fam" name="emailmadre_fam" maxlength= "80" value = "<?=$emailmadre_fam?>">
				</div>
			</div>
			<div class="col-md-1 col-sm-6" style="text-align: center; font-size: 14px;">
				<div class="row">
					titolo di studio *
				</div>
				<div class="row">
					<select name="titolomadre_fam"  style="margin-left: 0px"  id="titolomadre_fam">
						<option value="">-selez.titolo-</option>
						<option value="nessuno" <?if ($titolomadre_fam =='nessuno'){echo ('selected');}?>>nessuno</option>
						<option value="lic.elementare" <?if ($titolomadre_fam =='lic.elementare'){echo ('selected');}?>>lic.elementare</option>
						<option value="lic.media" <?if ($titolomadre_fam =='lic.media'){echo ('selected');}?>>lic.media</option>
						<option value="diploma" <?if ($titolomadre_fam =='diploma'){echo ('selected');}?>>diploma</option>
						<option value="laurea" <?if ($titolomadre_fam =='laurea'){echo ('selected');}?>>laurea</option>
						<option value="altro" <?if ($titolomadre_fam =='altro'){echo ('selected');}?>>altro</option>
					</select>
				</div>
			</div>

			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px;">
				<div class="row">
					professione *
				</div>
				<div class="row">
					<input class="tablecell5" type="text"  id="profmadre_fam" name="profmadre_fam" maxlength="50" value = "<?=$profmadre_fam?>">
				</div>
			</div>
			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px;">
				<div class="row">
					(* dati facoltativi)
				</div>
			</div>

<!-- CAR POOLING ************************************************************************ -->
				<?if ($ISC_mostra_carpooling == 1) {?>
					<div class="col-md-4 col-sm-12 col-md-offset-4 center fs14 mt10" style="border-top: 1px solid grey; border-bottom: 1px solid grey; padding: 5px 2px 10px 2px;">
						<span class="fs16 mb10">PROGETTO CAR POOLING</span>
						<br>Autorizzo la pubblicazione dell'indirizzo di residenza della madre,
						<br>del numero di telefono e/o email
						<div class="col-md-12 col-sm-12 col-xs-12" id="lblckcarpoolingmadre_fam" style="padding-bottom: 2px;">
							<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
								<input type="radio" class="ckcarpoolingmadre_fam" name="ckcarpoolingmadre_fam" value="1" <?if ($ckcarpoolingmadre_fam == 1) {echo "checked";}?>>&nbsp;Autorizzo
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 center fs12" style="z-index: 100;">
								<input type="radio" class="ckcarpoolingmadre_fam ml20" name="ckcarpoolingmadre_fam" value="-1" <?if ($ckcarpoolingmadre_fam == -1) {echo "checked";}?>>&nbsp;Non Autorizzo
							</div>
						</div>
						<div class="col-md-12 mb15 center fs12">
							<img title="Informazioni" class="iconaStd" src='../assets/img/Icone/info.svg' onclick="showModalCarPooling();" style="position: absolute;  margin-top: -50px; width: 30px; right: 0px;">
						</div>
					</div>
				<?}?>

<!-- TRATTAMENTO DEI DATI *************************************************************** -->				
			<div class="col-md-12" style="text-align: center; margin-top: 10px; font-size:12px;">
				<input type="checkbox"  id="ckautorizzazionemadre_fam" name="ckautorizzazionemadre_fam" <?if ($ckautorizzazionemadre_fam == 1) {echo ("checked");}?>>
				<label id ="lblaccettazioneprivacy" for="ckautorizzazionemadre_fam" style="margin-bottom: 1px;">Autorizzazione al trattamento dei dati personali</label>
			</div>
			<div class="col-md-4 col-sm-12 col-md-offset-4" style="text-align: center; font-size: 14px;">
				
				<textarea style="width: 100%; font-size: 10px; overflow-x: hidden" rows="5" readonly>- INFORMATIVA AI SENSI DELL'ART.13 DEL REGOLAMENTO UE 2016/679 -&#013;&#013;<?=$informativaprivacy?>
				</textarea>

				<!-- <textarea style="width: 100%; font-size: 10px; " rows="5" readonly>- INFORMATIVA AI SENSI DELL'ART.13 DEL REGOLAMENTO UE 2016/679 -&#013;&#013;Nel ringraziarLa per averci fornito i Suoi dati personali, portiamo a Sua conoscenza le finalità e le modalità del trattamento cui essi sono destinati.&#013;Secondo quanto previsto dagli artt. 13 e 14 del REG. UE 2016/679  recante disposizioni sulla tutela della persona e di altri soggetti, rispetto al trattamento di dati personali questa Istituzione Scolastica, rappresentata dal presidente pro-tempore, in qualità di Titolare del trattamento dei dati personali, per espletare le sue funzioni istituzionali e, in particolare, per gestire le attività di istruzione, educative e formative stabilite dal ".$POF_PTOF_PSDext.", deve acquisire i dati personali che Vi riguardano, inclusi quei dati che il REG. UE 2016/679 definisce “dati personali relativi all'orientamento religioso, opinioni politiche e relativi alla salute”.&#013;Vi informiamo pertanto che, per le esigenze di gestione sopra indicate, possono essere oggetto di trattamento le seguenti categorie di dati:&#013-	dati relativi agli alunni, idonei a rilevare lo stato di salute, raccolti in riferimento a certificazioni di malattia, infortunio, esposizione a fattori di rischio, appartenenza a categorie protette, idoneità allo svolgimento di determinate attività, sorveglianza sanitaria;&#013;-	dati relativi agli alunni idonei a rilevare opinioni politiche o adesioni sindacali ed associative, derivanti da richieste di organizzazione o partecipazione ad attività opzionali, facoltative o stabilite autonomamente dagli organismi rappresentativi studenteschi;&#013;-	dati relativi agli alunni idonei a rilevare le convinzioni religiose o filosofiche ovvero l’adesione a organizzazioni di carattere religioso o filosofico,  o quali la fruizione di permessi e festività aventi tali carattere;&#013;Vi informiamo inoltre che il trattamento dei vostri dati personali avrà le seguenti finalità:&#013;-	partecipazione degli alunni alle attività organizzate in attuazione del ".$POF_PTOF_PSDext.";&#013;-	adempimento di obblighi derivanti da leggi, contratti, regolamenti in materia di igiene e sicurezza, in materia fiscale, in materia assicurativa;&#013;-	tutela dei diritti in sede giudiziaria.&#013;Vi forniamo a tal fine le seguenti ulteriori informazioni:&#013;-	Il trattamento dei dati personali sarà improntato a principi di correttezza, liceità e trasparenza e di tutela della Sua riservatezza e dei Suoi diritti anche in applicazione dell’art. 5 del REG. UE 2016/679;&#013;-	I dati personali verranno trattati anche con l’ausilio di strumenti elettronici o comunque automatizzati con le modalità e le cautele previste dal predetto REG. UE 2016/679 e conservati per il tempo necessario all’espletamento delle attività istituzionali e amministrative riferibili alle predette finalità;&#013;-	Sono adottate dalla scuola le misure minime per la sicurezza dei dati personali previste dal REG. UE 2016/679;&#013;-	Il titolare del trattamento è il presidente pro-tempore della <?//=$ragionesocialescuola?>;&#013;-	Gli incaricati al trattamento dati sono i docenti, gli assistenti amministrativi della Scuola, i collaboratori e i gestori espressamente autorizzati all'assolvimento di tali compiti, identificati ai sensi di legge, ed edotti dei vincoli imposti dal REG. UE 2016/679;&#013;-	I dati oggetto di trattamento potranno essere comunicati ai seguenti soggetti esterni all’istituzione scolastica per fini funzionali: Ufficio Scolastico Provinciale e Regionale, Comuni, ASL competente per territorio, Autorità di polizia del territorio.&#013;Vi ricordiamo infine:&#013;-	che il conferimento dei dati richiesti potrebbe essere indispensabile a questa istituzione scolastica per l'assolvimento dei suoi obblighi istituzionali;&#013;-	che, ai sensi dell’art. 2-ter del D. lgs. 196/2003, in alcuni casi il trattamento può essere effettuato anche senza il consenso dell’interessato;&#013;-	Le ricordiamo che gode dei diritti di cui agli artt. 15 e segg. del Regolamento UE 2016/679, fra cui il diritto di chiedere l’accesso ai dati personali e la rettifica o la cancellazione degli stessi o la limitazione del trattamento dei dati che la riguardano o di opporsi al loro trattamento; ha inoltre il diritto di proporre reclamo all’autorità di controllo competente in materia, Garante per la protezione dei dati personali.&#013;&#013;Il Titolare del trattamento dati &#013;<?//=$titolaretrattamento?>
				</textarea> -->

			</div>
		</form>
		<!--<div class="row">
			<div  class="col-md-4 col-sm-12 col-md-offset-4">
				<div class="col-md-6 col-sm-6" style="text-align: center; font-size: 14px;">
					<input value="< Dati del Padre" class="btn btn-primary btn-cons" id="btn_proceed" style="width: 100%; margin-top: 20px; border-radius:15px; background: grey; " onclick="CheckBeforeForm1();" readonly></input>
				</div>
				<div class="col-md-6 col-sm-6" style="text-align: center; font-size: 14px;">
					<input value="Salva e Procedi >" class="btn btn-primary btn-cons" id="btn_proceed" style="width: 100%; margin-top: 20px; border-radius:15px; background: grey; " onclick="CheckBeforeForm3();" readonly></input>
				</div>
			</div>
		</div>-->


	</div>
	
	<div class="modal" id="modalAvvisoCampi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
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
						<button type="button" id="btn_cancelUscita" class="btnBlu" style="width:40%;" data-dismiss="modal" onclick="">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal" id="modalCheckBeforeForm1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">ATTENZIONE!</span>
					<div id="remove-content1" style="text-align: center;"> <!-- START REMOVE CONTENT -->
						<br>
						Tornare allo step precedente
						<br>(Dati del padre)
						<br>implica che le modifiche correnti
						<br>ai dati compilati in questo modulo<br>
						non verranno salvate.
					</div> <!-- END REMOVE CONTENT -->
					<div class="row modal-footer white">
						<div class="col-md-6 col-sm-12">
							<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="margin-top: 5px; width: 90%; border-radius:15px;" data-dismiss="modal" onclick="GoBack();">< Dati del padre</button>
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
	

	$('body').click(function () {
		$('.showcomuneB').hide();
	});



	function CheckBeforeForm1(){
		$('#modalCheckBeforeForm1').modal('show');
	}
	
	function GoBack(){
		window.location.href = "FormIscrizione1.php";
	}

	function CheckBeforeForm3(){
		//verifica che i dati obbligatori ci siano tutti
		let campo = ["comunenascitamadre_fam", "provnascitamadre_fam", "paesenascitamadre_fam", "cfmadre_fam", "indirizzomadre_fam", "comunemadre_fam", "provmadre_fam", "paesemadre_fam", "CAPmadre_fam", "telefonomadre_fam", "emailmadre_fam", "ckautorizzazionemadre_fam"];
		let campodesc = ["Comune di Nascita", "Provincia di Nascita", "Paese di Nascita", "Codice Fiscale", "Via e N. Civico", "Comune di Residenza", "Provincia di Residenza", "Paese di Residenza", "CAP di residenza", "Telefono", "Indirizzo e-mail", "Autorizzazione Privacy"];
		let campomissing = [];
		let missingfields = 0;
		for (i = 0; i < 11; i++) { 
			if ($('#'+campo[i]).val()=="") {
				$('#'+campo[i]).css("border", "1px solid red");
				campomissing[missingfields]=campodesc[i];
				missingfields++;
			} else {
				$('#'+campo[i]).css("border", "1px solid grey");
			}
		}
		//accettazione privacy è una checkbox va dunque gestita diversamente dalle input
		if ($('#ckautorizzazionemadre_fam').is(':checked') == false ) {
			$('#lblaccettazioneprivacy').css("border", "1px solid red");
			campomissing[missingfields]="accettazione privacy";
			missingfields++;
		} else {
			$('#lblaccettazioneprivacy').css("border", "1px solid grey");
		}

		//progetto carpooling
		if ($('#ISC_mostra_carpooling').val() == 1) {
			if ($('.ckcarpoolingmadre_fam').is(':checked') == false){
				$('#lblckcarpoolingmadre_fam').css("border", "1px solid red");
				campomissing[missingfields]="carpoooling";
				missingfields++;
				//console.log (camponame+" Y: #"+campo[i]+"Y "+ ($('#'+campo[i]+"Y").is(':checked'))+" N: #"+campo[i]+"N "+($('#'+campo[i]+"N").is(':checked')));
			} else {
				$('#lblckcarpoolingmadre_fam').css("border", "0px");
				//console.log (camponame+" ok");
			}
		}

		//diversamente va verificata la data
		datavalida = moment($('#datanascitamadre_fam').val(), 'DD/MM/YYYY', true).isValid(); 
		if ((!(datavalida)) || ($('#datanascitamadre_fam').val()=="")) {
			$('#datanascitamadre_fam').css("border", "1px solid red");
			campomissing[missingfields]="Data di nascita";
			missingfields++;	
		} else {
			$('#datanascitamadre_fam').css("border", "1px solid grey");
		}
		
		cflength = $('#cfmadre_fam').val().length;
				
		if (cflength!= 16) {
			$('#cfmadre_fam').css("border", "1px solid red");
			campomissing[missingfields]="Codice Fiscale";
			missingfields++;	
		} else {
			$('#cfmadre_fam').css("border", "1px solid grey");
		}
		
		
		if ((missingfields == 0) || (($('#nomemadre_fam').val()=="-") && ($('#cognomemadre_fam').val()=="-"))) {
			VerificaSoci();
		} else {
			$('#modalAvvisoCampi').modal('show');
		}
	}
	
	function VerificaSoci(){
		codscuola = $('#codscuola').val();
		sociopadre_fam = $('#sociopadre_fam').is(':checked') ;
		sociomadre_fam = $('#sociomadre_fam').is(':checked') ;
		
		//a Padova c'è una politica diversa che a Cittadella
		//a Padova e' preferibile che uno solo dei due sia socio
		//a Cittadella si vuole incentivare ad essere entrambi soci
		//istituire due parametri
		//1. ISC_un_socio 0=non richiesto 1=obbligatorio
		//2. ISC_due_soci 0=vietato 1=sconsigliato 2=proposto 3=obbligatorio
		ISC_primo_socio = <?=$_SESSION['ISC_primo_socio']?>;
		ISC_secondo_socio = <?=$_SESSION['ISC_secondo_socio']?>;

		if (ISC_primo_socio == 1 && ((sociopadre_fam == false ) && (sociomadre_fam == false))) {
			//se nessuno dei due è socio e ISC_primo_socio == 1, viene richiesto che uno lo sia
			$('#titolo01Msg_OK').html('ATTENZIONE!');
			$('#msg01Msg_OK').html("Sembra che nè il padre nè la madre siano stati indicati come soci.<br>Per poter usufruire dei servizi scolastici<br>è obbligatorio per almeno uno dei due genitori");
			$('#modal01Msg_OK').modal('show');
			
			return;
		}

		if (ISC_secondo_socio == 1 && ((sociopadre_fam == true ) && (sociomadre_fam == true))) {
			//se entrambi sono soci e ISC_secondo_socio == 1, viene sconsigliato che entrambi lo siano
			$('#titolo02Msg_OKCancel').html('ATTENZIONE!');
			$('#msg02Msg_OKCancel').html("<br>Sembra che sia il padre sia la madre siano stati indicati come soci.<br>Per poter usufruire dei servizi scolastici è sufficiente che uno solo dei due genitori<br>sia socio della cooperativa Steiner Waldorf.");
			$("#btn_OK02Msg_OKCancel").html("Procedi con entrambi i soci");
			$("#btn_OK02Msg_OKCancel").attr("onclick","SaveAndGoNext()");
			$('#modal02Msg_OKCancel').modal('show');
			
			return;
		}	

		if (ISC_secondo_socio == 3 && ((sociopadre_fam == false ) || (sociomadre_fam == false))) {
			//se non sono entrambi soci e ISC_secondo_socio == 3, viene proposto che entrambi lo siano
			$('#titolo02Msg_OKCancel').html('ATTENZIONE!');
			$('#msg02Msg_OKCancel').html("<br>Sembra che uno dei due genitori<br>non sia socio.<br>E' preferibile, per la copertura assicurativa<br>delle attività sociali,<br>che entrambi i genitori siano soci<br>nell'anno <?=$annoiscrizioni?><br><span style='font-size: small'>(La quota sociale di adesione è di <br>euro 10,00 a genitore<br>da versare entro il 30/09)</span>");
			$("#btn_OK02Msg_OKCancel").html("Procedi con un solo socio");
			$("#btn_OK02Msg_OKCancel").attr("onclick","SaveAndGoNext()");
			$('#modal02Msg_OKCancel').modal('show');
			return;
		}	


		SaveAndGoNext();

		
	}

	function SaveAndGoNext (){
			//Salva e procedi a Form2
			let postData = $("#formiscrizione").serializeArray();
			
			let ckaccettazione = $("#ckautorizzazionemadre_fam").is(":checked");
			if (ckaccettazione) {
				const index = postData.findIndex(postData => postData.name==='ckautorizzazionemadre_fam');
				postData[index].value = 1; //con queste due righe si va a sostituire un valore in un associative array di tipo object (quello che si genera con il serialize)
			} else {
				postData.push( {name: "ckautorizzazionemadre_fam", value: 0}); //in questo caso la cosa è complicata dal fatto che quando si ha a che fare con delle checkbox, il serialize inserisce un valore SOLO quando è selezionato, altrimenti non inserisce nulla, ecco perchè se è false si fa un push, se è un true si usa il metodo di cui sopra.
			}
			
			let sociomadre = $("#sociomadre_fam").is(":checked");
			if (sociomadre) {
				const index = postData.findIndex(postData => postData.name==='sociomadre_fam');
				postData[index].value = 1; //con queste due righe si va a sostituire un valore in un associative array di tipo object (quello che si genera con il serialize)
			} else {
				postData.push( {name: "sociomadre_fam", value: 0}); //in questo caso la cosa è complicata dal fatto che quando si ha a che fare con delle checkbox, il serialize inserisce un valore SOLO quando è selezionato, altrimenti non inserisce nulla, ecco perchè se è false si fa un push, se è un true si usa il metodo di cui sopra.
			}

			postData.push( {name: "padremadre", value: "madre"});
			console.log (postData);
			
			$.ajax({
				url : "qry_updatePadreMadre.php", //qui andrà indicato il file che fa l'update della password nel database
				type: "POST",
				data : postData,
				dataType: "json",
				success:function(data){
					updateStatusFamiglia(40, "FormIscrizione3.php");

					//console.log (data.sql);
					//console.log (data.array);
					//console.log (data.array2);
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
				//in questo solo caso devo fare una redirect con POST, utilizzo un form fittizio e lo invio
				let form = $('<form id="tmpform" action="' + pagina + '"method="post">' + '<input type="text" name ="num_fratello" value ="1" ></form>');
				$('body').append(form);
				form.submit();
				var element =  document.getElementById('tmpform');
				element.remove();
			}
		});
	}
	
//******************** funzioni per la ricerca ajax del Comune, CAP, Prov, Paese *************************************************

	$('#comunenascitamadre_fam').on("keyup input", function(){
		$('#showComuneNascita_fam').show();
	});

	$('#comunemadre_fam').on("keyup input", function(){
		$('#showComune_fam').show();
	});

	$('.search-comune').on("keyup input", function(){
		campo = $(this).attr("name");
		let inputVal = $(this).val();
		switch (campo) {
			case "comunenascitamadre_fam":
				resultDropdown = $("#showComuneNascita_fam");
				resultProv = $("#provnascitamadre_fam");
			break;
			case "comunemadre_fam":
				resultDropdown = $("#showComune_fam");
				resultProv = $("#provmadre_fam");
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
			case "showComuneNascita_fam":
				$("#comunenascitamadre_fam").val(comuneselected);
				$("#provnascitamadre_fam").val(provselected);
				$("#paesenascitamadre_fam").val(paeseselected);
			break;
			case "showComune_fam":
				$("#comunemadre_fam").val(comuneselected);
				$("#provmadre_fam").val(provselected);
				$("#paesemadre_fam").val(paeseselected);
				$("#CAPmadre_fam").val(CAPselected);
			break;
		}
			$(this).parent().empty();
	});

	function CopiaResPadre() {

		postData = {copiada: "padre"};
		console.log (postData);
		$.ajax({
			url : "qry_CopiaResidenza.php",
			type: "POST",
			data : postData,
			dataType: "json",
			success:function(data){
				$("#comunemadre_fam").val(data.comune);
				$("#provmadre_fam").val(data.prov);
				$("#CAPmadre_fam").val(data.CAP);
				$("#paesemadre_fam").val(data.paese);
				$("#indirizzomadre_fam").val(data.indirizzo);
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

	function makeuppercase (controllo) {
		str = $(controllo).val();
		str2 = str.toUpperCase();
		$(controllo).val(str2);
	}

	function showModalCarPooling() {
		$('#titolo01Msg_OK').html('PROGETTO CAR-POOLING');
		$('#msg01Msg_OK').html("Nell'ottica di un maggior rispetto per l'ambiente<br>e contribuire a diminuire il numero di veicoli circolanti<br>la scuola desidera incentivare l'aggregazione spontanea tra le famiglie.<br><br>A questo scopo produrrà una mappa con dei segnaposto,<br>uno per ciascun indirizzo che sarà stato autorizzato alla pubblicazione.<br>NB:Sarà incluso anche il contatto telefonico/e-mail.<br>La mappa sarà condivisa con tutti e soli i genitori che avranno dato autorizzazione.<br><br>Ogni famiglia potrà così individuare altre famiglie della comunità scolastica<br>che abitano nella propria zona ed in autonomia contattarle<br>per condividere un passaggio per i propri figli.<br><br>L'autorizzazione è revocabile in qualunque momento.<br>Il car pooling nascerà dalla spontanea aggregazione<br>delle famiglie e non è un servizio offerto dalla scuola.");
		$('#modal01Msg_OK').modal('show');
	}
</script>
