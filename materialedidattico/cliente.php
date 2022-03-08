<?session_start()?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" type="image/png" href="img/favicon2.png"/>
<title>Gestionale Materiale Didattico</title>
<link rel="stylesheet" href="css/reset.css"/>
<link rel="stylesheet" href="css/main.css"/>
<link href="https://fonts.googleapis.com/css?family=Titillium+Web:300" rel="stylesheet">
</head>


<body style="background-size: cover;" background="img/bg2b.jpg">

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/funzioni_jquery.js"></script>
<script type="text/javascript" src="js/clock.js"></script>
<?php
require 'core.inc.php';
require 'connect.inc.php';

if (!loggedin()) {
echo "<h3><br>E' richiesto il login</h3><br>";
echo '<h3><a href="index.php">Pagina di Login</a></h3>';
die();
}
?>

<div id="logo">
<h6><a onclick="return confirm('LOGOUT: Sei sicuro di voler uscire?')" href="logout.php"><img src="img/user2.png"></a><br /><?php $username = getuserfield ('username'); echo $username;?> <br /></h6>
<h6><div id="clockbox"></div></h6>
</div>

<div id="mySidenav" class="sidenav">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>


            <a href="articoli.php">Elenco Articoli</a>
            <a style="font-size:xx-small; margin-left: 20px;" href="console.php" >Articoli Sotto Scorta</a>
            <a href="fornitori.php">Elenco Fornitori</a>
            <a href="clienti.php">Elenco Clienti</a>
            <a href="movimenti.php">Movimenti Magazzino</a>
            <a href="download.php">Report</a>
            <br />
            <a style="border-top: 1px solid #CCC" href="logout.php">Log Out</a>

</div>

<div class="header">
<span id="openNav" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
</div>


<main>

<?php

if (loggedin()) {
	
	
	//questa prima parte attribuisce i valori (utilizzando la chiave GET[cli_id] alle variabili, che poi vengono usate nel form  come values
	if (isset($_GET['cli_id'])){
		
		$cli_id = ($_GET['cli_id']);
		
		//query per estrarre articolo in questione
		
		$query = "SELECT `CLI_ID`, `CLI_NOME`, `CLI_COGNOME`, `CLI_NOMECOGNOME`, `CLI_CLASSE`, `CLI_TEL`, `CLI_EMAIL` FROM `clienti` WHERE `CLI_ID`='".$cli_id."'"; 
		$stmt = mysqli_prepare($mysqli, $query);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $cli_id, $cli_nome, $cli_cognome, $cli_nomecognome, $cli_classe, $cli_tel, $cli_email);
		mysqli_stmt_store_result($stmt);
		if (mysqli_stmt_num_rows($stmt) >=1) {
			while (mysqli_stmt_fetch($stmt)) {
			}
		} else {
		echo "più di un record?";
		}
	}
}



//parte submit
if(isset($_POST['salva'])) {
   // è stato premuto il primo pulsante
   // se manca ART_ID allora trattasi di uno nuovo e quindi non devo fare una UPDATE ma una INSERT!!
	
	if (
	isset ($_POST['CLI_ID']) &&
	isset ($_POST['CLI_NOME']) &&
	isset ($_POST['CLI_COGNOME']) &&
	isset ($_POST['CLI_CLASSE']) &&
	isset ($_POST['CLI_TEL']) &&
	isset ($_POST['CLI_EMAIL'])) { //significa: "se è stato premuto il tasto submit"
		//assegna le variabili
		$cli_id = $_POST['CLI_ID'];
		$cli_nome = $_POST['CLI_NOME'];
		$cli_cognome = $_POST['CLI_COGNOME'];
		$cli_classe = $_POST['CLI_CLASSE'];
		$cli_tel = $_POST['CLI_TEL'];
		$cli_email = $_POST['CLI_EMAIL'];
		
		
		/*if (empty($art_qty_stock)) {$art_qty_stock='0';}	
		if (empty($art_qty_reorder)){$art_qty_reorder='0';}
		if (empty($art_gg_reorder)){$art_gg_reorder='0';}*/
		$testedcli_nome = test_input($cli_nome);
		$testedcli_cognome = test_input($cli_cognome);
		if (
		!empty ($testedcli_nome) &&
		!empty ($testedcli_cognome)
 			) {
			//trova se esite già la stessa coppia nomecognome
			$query2 = "SELECT `CLI_ID` FROM `clienti` WHERE `CLI_NOME` = '".$testedcli_nome."' AND `CLI_COGNOME` = '".$testedcli_cognome."'";
			$stmt2 = mysqli_prepare($mysqli, $query2);
			mysqli_stmt_execute($stmt2);
			//mysqli_stmt_bind_result($stmt2, $cli_id2);
			mysqli_stmt_store_result($stmt2);
			if (mysqli_stmt_num_rows($stmt2) ==0) {
				//solo il campo ragione sociale è necessario
				//se CLI_ID è vuoto allora sto creando un articolo nuovo e quindi non devo fare una UPDATE ma una INSERT
				if (empty ($cli_id)) {
					$query5 = "INSERT INTO `clienti` (`CLI_NOME`, `CLI_COGNOME`, `CLI_CLASSE`, `CLI_TEL`, `CLI_EMAIL`, `CLI_NOMECOGNOME`) VALUES ('".test_input($cli_nome)."', '".test_input($cli_cognome)."', '".test_input($cli_classe)."', '".test_input($cli_tel)."', '".test_input($cli_email)."','".test_input($cli_nome)." ".test_input($cli_cognome)."')";
					echo $query5;
					echo '<h3 class="info"> Record Inserito</h3>';
					
					$logsino = getuserfield ('LOG');
						if ($logsino == 1) {
							//Ora aggiorna anche il Log
							$query3 ="INSERT INTO `log` ( `USER_ID`, `OPERAZIONE`, `CLI_ID`, `CLI_NOMECOGNOME`) VALUES ( '".$_SESSION['user_id']."', 'aggiunta cliente', '".$cli_id."', '".test_input($cli_nome)." ".test_input($cli_cognome)."' )";
							$stmt3 = mysqli_prepare($mysqli, $query3);
							mysqli_stmt_execute($stmt3);
							//echo $querylog;
							//fine aggiornamento log
						}
				} else {
						
					$query5 = "UPDATE `clienti` SET `CLI_NOME`='".test_input($cli_nome)."', `CLI_COGNOME`='".test_input($cli_cognome)."', `CLI_CLASSE`='".test_input($cli_classe)."', `CLI_TEL`='".test_input($cli_tel)."', `CLI_EMAIL`='".test_input($cli_email)."', `CLI_NOMECOGNOME`='".test_input($cli_nome)." ".test_input($cli_cognome)."' WHERE `CLI_ID`='".$cli_id."'"; 
					echo '<h3 class="info"> Record Salvato</h3>';
					//echo $query;
					
					//Ora aggiorna anche il Log
					$query4 ="INSERT INTO `log` ( `USER_ID`, `OPERAZIONE`, `CLI_ID`, `CLI_NOMECOGNOME`) VALUES ( '".$_SESSION['user_id']."', 'modifica cliente', '".$cli_id."', '".test_input($cli_nome)." ".test_input($cli_cognome)."' )";
					$stmt4 = mysqli_prepare($mysqli, $query4);
					mysqli_stmt_execute($stmt4);
					//echo $querylog;
					//fine aggiornamento log
				}
				$stmt5 = mysqli_prepare($mysqli, $query5);
				mysqli_stmt_execute($stmt5);
			} else {
			echo '<h3 class="warn"> IMPOSSIBILE SALVARE: esiste già un cliente con lo stesso nome e cognome</h3>';
			}// fine check che nome e cognome non siano entrambi uguali a quelli di un altro record

		} else {
		echo '<h3 class="warn"> è obbligatorio indicare almeno Nome e Cognome</h3>';
		}
		
	} else {
		echo '<h3 class="warn"> not all set</h3>';
	
	}
}




?>

<div class="moduli">
    <form action="cliente.php" method="POST">
    <input type="hidden" name="CLI_ID" value="<?php if (isset($cli_id)){echo $cli_id;} ?>"></div>
        <br>
        <table id="art" style="width:50%; text-align: center;">
        <tr>
            <td colspan="2">
                <h3>Nome</h3>
            </td>
            <td>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <input class="evident"  type="textarticolo" name="CLI_NOME" maxlength="30" value="<?php if (isset($cli_nome)){echo $cli_nome;} ?>">
            </td>
            <td>
            </td>
        </tr>
        
        <td colspan="2">
                <h3>Cognome</h3>
            </td>
            <td>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <input class="evident"  type="textarticolo" name="CLI_COGNOME" maxlength="30" value="<?php if (isset($cli_cognome)){echo $cli_cognome;} ?>">
            </td>
            <td>
            </td>
        </tr>
        
        <tr>
            <td>
                <h3>Classe</h3>
            </td>
            <td>
                <h3>Telefono</h3>
            </td>
            <td>
                <h3>email</h3>
            </td>
        </tr>
        
        <tr>
            <td>
                <input type="textarticolo" name="CLI_CLASSE" maxlength="2" value="<?php if (isset($cli_classe)){echo $cli_classe;} ?>">
            </td>
            <td>
                <input type="textarticolo" name="CLI_TEL" maxlength="15" value="<?php if (isset($cli_tel)){echo $cli_tel;} ?>">
            </td>
            <td>
                <input type="textarticolo" name="CLI_EMAIL" maxlength="40" value="<?php if (isset($cli_email)){echo $cli_email;} ?>">
            </td>
        </tr>
        
       
            <td>
            </td>
        	<td>
        		<br><br> <input name="salva" id="submit3" type="submit" style="margin: auto;" value="Salva Modifica">
        	</td>
            <td>
            </td>
        </table>
    </form>
</div>

<script type="text/javascript"> 
$(document).ready(function() { 
   openNav();
}); 
</script>
</main>
</body>
</html>