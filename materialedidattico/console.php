
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
			<a style="font-size:xx-small; margin-left: 20px;color: white;" href="#" class="active" >Articoli Sotto Scorta</a>
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




	
	//inseriamo qui i warning


		$queryANDpart = " WHERE `ART_QTY_STOCK` <= `ART_QTY_REORDER`";
		$sqlORDERBY = " ORDER BY `ART_DESC` DESC";
		$query = "SELECT `articoli`.`ART_ID`, `articoli`.`ART_COD`, `articoli`.`ART_DESC`, `articoli`.`ART_QTY_STOCK`, `articoli`.`ART_QTY_REORDER`, `fornitori`.`FOR_RAGSOC`, `fornitori`.`FOR_ID`, `tipologie`.`TIP_ID`, `tipologie`.`TIP_DESC` FROM (`articoli` INNER JOIN `fornitori` ON `articoli`.`FOR_ID` = `fornitori`.`FOR_ID`) INNER JOIN `tipologie` ON `articoli`.`TIP_ID` = `tipologie`.`TIP_ID` ".$queryANDpart.$sqlORDERBY;
		$stmt = mysqli_prepare($mysqli, $query);
		//mysqli_stmt_bind_param($stmt, "s", $login_usr);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $art_id, $art_cod, $art_desc, $art_qty_stock, $art_qty_reorder, $for_ragsoc, $for_id, $tip_id, $tip_desc);
		mysqli_stmt_store_result($stmt);
		if (mysqli_stmt_num_rows($stmt) >=1) {
			echo '<table id="lst" style="width:70%" class="tbl">
			
			
			<tr class="row2" style="color: white">
						<th style="width:16%;" id="columnlabel" >CODICE</th>
						<th style="width:28%;" id="columnlabel" >DESCRIZIONE</th>
						<th style="width:16%;" id="columnlabel" >FORNITORE <br /> di DEFAULT</th>
						<th style="width:16%;" id="columnlabel" >TIPOLOGIA</th> 
						<th style="width:8%;" id="columnlabel" >QUANTITA\' <br />A MAGAZZINO</th>
						<th style="width:8%;" id="columnlabel" >SOGLIA <br /> DI RIORDINO</th>
						<th style="width:2%;"></th>
										
					  </tr>';

			echo '<br><br><br><h4 class="warn">ATTENZIONE '.mysqli_stmt_num_rows($stmt).'  Articoli sotto la soglia di riordino <h4><br>';
			
			//se ne trova li mettiamo tutti in un associative array
			while (mysqli_stmt_fetch($stmt)) {
				echo '<tr>
					<td style="display:none";>'.$art_id.'</td>
										
					<td>'.$art_cod.'</td>
					<td>'.$art_desc.'</td>
					<td>'.$for_ragsoc.'</td>
					<td>'.$tip_desc.'</td>
					<td>'.$art_qty_stock.'</td>
					<td>'.$art_qty_reorder.'</td>
					
					<td> <a href="articolo.php?art_id='.$art_id.'"><img src="img/lente.png"></a> </td>
				</tr>';
			} //FINE while
			echo '</table>';
		} else {
			echo '<br><h4 class="info">Nessun articolo sotto la soglia di riordino <h4><br>';
		}




?>	


<script type="text/javascript"> 
$(document).ready(function() { 
	
	//1 fissa le righe in alto
	$('.tbl').fixedtableheader(); 
	//2 chiude il menu
	//closeNav();


	
}); //FINE $(document).ready(function()
</script>




</main>
</body>
</html>