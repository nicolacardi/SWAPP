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
	
	
	//questa prima parte attribuisce i valori (utilizzando la chiave GET[for_id] alle variabili, che poi vengono usate nel form  come values
	if (isset($_GET['for_id'])){
		
		$for_id = ($_GET['for_id']);
		
		//query per estrarre articolo in questione
		
		$query = "SELECT `FOR_ID`, `FOR_RAGSOC`, `FOR_PIVA`, `FOR_INDIRIZZO`, `FOR_CITTA`, `FOR_PROV`, `FOR_CAP`, `FOR_TEL`, `FOR_EMAIL`, `NOTE` FROM `fornitori` WHERE `FOR_ID`='".$for_id."'"; 
		$stmt = mysqli_prepare($mysqli, $query);
		//mysqli_stmt_bind_param($stmt, "s", $login_usr);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $for_id, $for_ragsoc, $for_piva, $for_indirizzo, $for_citta, $for_prov, $for_cap, $for_tel, $for_email, $note);
		mysqli_stmt_store_result($stmt);
		if (mysqli_stmt_num_rows($stmt) ==1) {
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
	isset ($_POST['FOR_ID']) &&
	isset ($_POST['FOR_RAGSOC']) &&
	isset ($_POST['FOR_PIVA']) &&
	isset ($_POST['FOR_INDIRIZZO']) &&
	isset ($_POST['FOR_CITTA']) &&
	isset ($_POST['FOR_PROV']) &&
	isset ($_POST['FOR_CAP']) &&
	isset ($_POST['FOR_TEL']) &&
	isset ($_POST['FOR_EMAIL'])&&
	isset ($_POST['NOTE']) ) { //significa: "se è stato premuto il tasto submit"
        //assegna le variabili

		$for_id = $_POST['FOR_ID'];
		$for_ragsoc = $_POST['FOR_RAGSOC'];
		$for_piva = $_POST['FOR_PIVA'];
		$for_indirizzo = $_POST['FOR_INDIRIZZO'];
		$for_citta = $_POST['FOR_CITTA'];
		$for_prov = $_POST['FOR_PROV'];
		$for_cap = $_POST['FOR_CAP'];
		$for_tel = $_POST['FOR_TEL']; 
		$for_email = $_POST['FOR_EMAIL']; 
		$note = $_POST['NOTE']; 
		
		/*if (empty($art_qty_stock)) {$art_qty_stock='0';}	
		if (empty($art_qty_reorder)){$art_qty_reorder='0';}
		if (empty($art_gg_reorder)){$art_gg_reorder='0';}*/
		




		if (
		!empty ($for_ragsoc) ) {
            
			//solo il campo ragione sociale è necessario
			//se FOR_ID è vuoto allora sto creando un articolo nuovo e quindi non devo fare una UPDATE ma una INSERT
			if (empty ($for_id)) {
				$for_cap = $for_cap +0;
                $query4 = "INSERT INTO `fornitori` (`FOR_RAGSOC`, `FOR_PIVA`, `FOR_INDIRIZZO`, `FOR_CITTA`, `FOR_PROV`, `FOR_CAP`, `FOR_TEL`, `FOR_EMAIL`, `NOTE`) VALUES ('".test_input($for_ragsoc)."', '".test_input($for_piva)."', '".test_input($for_indirizzo)."', '".test_input($for_citta)."', '".test_input($for_prov)."', ".test_input($for_cap).",'".test_input($for_tel)."', '".test_input($for_email)."', '".test_input($note)."')";
                echo '<h3 class="info"> Record Inserito</h3>';
                //echo $query4;
                $logsino = getuserfield ('LOG');
                if ($logsino == 1) {
                    //Ora aggiorna anche il Log
                    $query2 ="INSERT INTO `log` ( `USER_ID`, `OPERAZIONE`, `FOR_ID`, `FOR_RAGSOC`) VALUES ( '".$_SESSION['user_id']."', 'aggiunta fornitore', '".$for_id."', '".test_input($for_ragsoc)."' )";
                    $stmt2 = mysqli_prepare($mysqli, $query2);
                    mysqli_stmt_execute($stmt2);
                    //echo $querylog;
                    //fine aggiornamento log
                }
			} else {
                
                
                $query4 = "UPDATE `fornitori` SET `FOR_RAGSOC`='".test_input($for_ragsoc)."', `FOR_PIVA`='".test_input($for_piva)."', `FOR_INDIRIZZO`='".test_input($for_indirizzo)."', `FOR_CITTA`='".test_input($for_citta)."', `FOR_CAP`='".test_input($for_cap)."', `FOR_PROV`='".test_input($for_prov)."', `FOR_TEL`='".test_input($for_tel)."' , `FOR_EMAIL`='".test_input($for_email)."', `NOTE`='".test_input($note)."' WHERE `FOR_ID`='".$for_id."'"; 
                echo '<h3 class="info"> Record Salvato</h3>';
                //echo $query;
                
                //Ora aggiorna anche il Log
                $query3 ="INSERT INTO `log` ( `USER_ID`, `OPERAZIONE`, `FOR_ID`, `FOR_RAGSOC`) VALUES ( '".$_SESSION['user_id']."', 'modifica fornitore', '".$for_id."', '".test_input($for_ragsoc)."' )";
                $stmt3 = mysqli_prepare($mysqli, $query3);
                mysqli_stmt_execute($stmt3);
                //echo $querylog;
                //fine aggiornamento log
                
            }
            
            $stmt4 = mysqli_prepare($mysqli, $query4);
            mysqli_stmt_execute($stmt4);


		} else {
		echo '<h3 class="warn"> è obbligatorio indicare almeno la Ragione Sociale</h3>';
		}
		
	} else {
		echo '<h3 class="warn"> not all set</h3>';
	
	}
}




?>

<div class="moduli">
    <form action="fornitore.php" method="POST">
    <input type="hidden" name="FOR_ID" value="<?php if (isset($for_id)){echo $for_id;} ?>"></div>
        <br>
        <table id="art" style="width:50%; text-align: center;">
        <tr>
            <td colspan="2">
                <h3>Ragione Sociale</h3>
            </td>
            <td>
                <h3>Partita Iva</h3>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <input class="evident" type="textarticolo" name="FOR_RAGSOC" maxlength="50" value="<?php if (isset($for_ragsoc)){echo $for_ragsoc;} ?>">
            </td>
            <td>
                <input type="textarticolo" name="FOR_PIVA" maxlength="11" value="<?php if (isset($for_piva)){echo $for_piva;} ?>">
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <h3>Indirizzo</h3>
            </td>
            <td>&nbsp;
                
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <input type="textarticolo" name="FOR_INDIRIZZO" maxlength="50" value="<?php if (isset($for_indirizzo)){echo $for_indirizzo;} ?>">
            </td>
            <td>&nbsp;
                
            </td>
        </tr>
        
        <tr>
            <td style="width: 33%;">
                <h3>Citta'</h3>	            
            </td>
            <td style="width: 33%;">
                <h3>Provincia</h3>
            </td>
            <td style="width: 33%;">
                <h3>CAP</h3>
            </td>
            
        </tr>
        <tr>
            <td>
                <input type="textarticolo" name="FOR_CITTA" maxlength="50" value="<?php if (isset($for_citta)){echo $for_citta;} ?>">
            </td>
            <td>
                <input type="textarticolo" name="FOR_PROV" maxlength="2" value="<?php if (isset($for_prov)){echo $for_prov;} ?>">
            </td>
            <td>
            	<input type="textarticolo" name="FOR_CAP" maxlength="5" value="<?php if (isset($for_cap)){echo $for_cap;} ?>">
            </td>
        </tr>

        <tr>
            <td>
                 <h3>Telefono</h3>
            </td>
            <td>
                <h3>e-mail</h3>
            </td>
            <td>
                
            </td>
        </tr>
        <tr>
            <td>
                <input type="textarticolo" maxlength="15" name="FOR_TEL" value="<?php if (isset ($for_tel)){echo $for_tel;} ?>">
            </td>
            <td>
                <input type="textarticolo" maxlength="40" name="FOR_EMAIL" value="<?php if (isset ($for_email)){echo $for_email;} ?>">
            </td>
            <td>
               
            </td>
        </tr>

    	<tr>
        	<td colspan="3">
            	<h3>Note</h3>
            </td>
        </tr>
            
    	<tr>
        	<td colspan="3">
            	<input type="textarticolo" maxlength="255" name="NOTE" value="<?php if (isset ($note)){echo $note;} ?>">
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