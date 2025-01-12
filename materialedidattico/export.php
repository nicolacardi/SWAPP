<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" type="image/png" href="img/favicon2.png"/>
<title>Gestionale Materiale Didattico</title>

</head>

<body>

<!---------------------------------------------------------------CASO REPORT CARICHI----------------------------------------------->

<?php
require 'core.inc.php';
require 'connect.inc.php';

if (isset($_POST["carichi"]) && isset($_POST["optcarichi"])) {
	
    $filename = "CarichiMagazzino.xls";
    header ("Content-Type: application/vnd.ms-excel");
    header ("Content-Disposition: inline; filename=$filename");

	$wherecondition = "";
	echo '<table border="1">';		
	switch ($_POST["optcarichi"]) {
		case "tutti":
			$wherecondition = "";
		break;
		case "perfornitore":
			$wherecondition =" AND `fornitori`.`FOR_ID`= '".$_POST["FOR_RAGSOCCOMBO"]."' ";
		break;
		case "perdata":
			$wherecondition =" AND (`TIME` > '".$_POST["DADATA"]."') AND (`TIME` < '".$_POST["ADATA"]."')";
		break;
	} //fine switch

	//$query = "SELECT `log`.`USER_ID`, `log`.`TIME` , `log`.`OPERAZIONE`, `log`.`QUANTITA`, `log`.`ART_ID`, `log`.`ART_DESC`, `log`.`FOR_ID`, `log`.`FOR_RAGSOC`, `log`.`PXTOT` FROM `log` WHERE `OPERAZIONE`='carico' ".$wherecondition;
	
	$query = "SELECT `s_carichi`.`TIME` , `s_carichi`.`S_CA_TYPE`, `s_carichi`.`S_CA_QTY_CARICO`, `s_carichi`.`ART_ID`, `articoli`.`ART_DESC`, `s_carichi`.`FOR_ID`, `fornitori`.`FOR_RAGSOC`, `s_carichi`.`ARTFOR_PXTOT`, `s_carichi`.`S_CA_PXTOT` FROM ((`s_carichi` INNER JOIN `articoli` ON `s_carichi`.`ART_ID` = `articoli`.`ART_ID`) INNER JOIN `fornitori` ON `s_carichi`.`FOR_ID` = `fornitori`.`FOR_ID`) WHERE `S_CA_TYPE`='carico' ".$wherecondition;
	
	echo '<tr>
	
		<td> DATA e ORA</td>
		<td> QUANTITA di CONFEZIONI</td>
		<td> DESCRIZIONE ARTICOLO</td>
		<td> FORNITORE</td>
		<td> PREZZO A CONFEZIONE</td>
		<td> PREZZO TOTALE</td>

	</tr>';
	$stmt = mysqli_prepare($mysqli, $query);
	//mysqli_stmt_bind_param($stmt, "s", $login_usr);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $time, $s_ca_type, $s_ca_qty_carico, $art_id, $art_desc, $for_id, $for_ragsoc, $artfor_pxtot, $s_ca_pxtot);
	mysqli_stmt_store_result($stmt);


	while (mysqli_stmt_fetch($stmt)) {
	echo '<tr>
		<td>'.$time.'</td>
		<td>'.$s_ca_qty_carico.'</td>
		<td>'.$art_desc.'</td>
		<td>'.$for_ragsoc.'</td>
		<td>'.$artfor_pxtot.'</td>
		<td>'.$s_ca_pxtot.'</td>
	</tr>';
	} //fine while
	
echo '</table>';

} // fine if (isset($_POST["carichi"]) && isset($_POST["optcarichi"])) 
?>


<!---------------------------------------------------------------CASO REPORT SCARICHI---------------------------------------------->

<?php


if (isset($_POST["scarichi"]) && isset($_POST["optscarichi"])) {
	
    $filename = "ScarichiMagazzino.xls";
    header ("Content-Type: application/vnd.ms-excel");
    header ("Content-Disposition: inline; filename=$filename");

	$wherecondition = "";
	echo '<table border="1">';		
	switch ($_POST["optscarichi"]) {
		case "tutti":
			$wherecondition = "";
		break;
		case "percliente":
			$wherecondition =" AND `s_carichi`.`CLI_ID`= '".$_POST["CLI_NOMECOGNOMECOMBO"]."' ";
		break;
		case "perdata":
			$wherecondition =" AND (`TIME` > '".$_POST["DADATA"]."') AND (`TIME` < '".$_POST["ADATA"]."')";
		break;
	} //fine switch

	//$query = "SELECT `log`.`USER_ID`, `log`.`TIME` , `log`.`OPERAZIONE`, `log`.`QUANTITA`, `log`.`ART_ID`, `log`.`ART_DESC`, `log`.`CLI_ID`, `log`.`CLI_NOMECOGNOME`, `log`.`PXTOT` FROM `log` WHERE `OPERAZIONE`='scarico' ".$wherecondition;
	$query = "SELECT `s_carichi`.`TIME` , `s_carichi`.`S_CA_TYPE`, `s_carichi`.`S_CA_QTY_UNIT_S_CARICO`, `s_carichi`.`ART_ID`, `articoli`.`ART_DESC`, `s_carichi`.`CLI_ID`, `clienti`.`CLI_NOMECOGNOME`, `s_carichi`.`S_CA_PXUNIT`, `s_carichi`.`S_CA_PXTOT`,  `s_carichi`.`S_CA_PAID` FROM ((`s_carichi` INNER JOIN `articoli` ON `s_carichi`.`ART_ID` = `articoli`.`ART_ID`) INNER JOIN `clienti` ON `s_carichi`.`CLI_ID` = `clienti`.`CLI_ID`) WHERE `S_CA_TYPE`='scarico' ".$wherecondition;
	
	echo '<tr>

		<td> DATA e ORA</td>
		<td> UNITA\'SCARICATE</td>
		<td> DESCRIZIONE ARTICOLO</td>
		<td> CLIENTE</td>
		<td> PREZZO UNITARIO</td>
		<td> PREZZO TOTALE</td>
		<td> PAGATO</td>
	</tr>';
	$stmt = mysqli_prepare($mysqli, $query);
	//mysqli_stmt_bind_param($stmt, "s", $login_usr);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $time, $s_ca_type, $s_ca_qty_unit_s_carico, $art_id, $art_desc, $cli_id, $cli_nomecognome, $s_ca_pxunit, $s_ca_pxtot, $s_ca_paid);
	mysqli_stmt_store_result($stmt);
	while (mysqli_stmt_fetch($stmt)) {

		echo '<tr>
			<td>'.$time.'</td>
			<td>'.$s_ca_qty_unit_s_carico.'</td>
			<td>'.$art_desc.'</td>
			<td>'.$cli_nomecognome.'</td>
			<td>'.$s_ca_pxunit.'</td>
			<td>'.$s_ca_pxtot.'</td>
			<td>'.$s_ca_paid.'</td>
		</tr>';
	} //fine while
	
echo '</table>';
}  // fine if (isset($_POST["scarichi"]) && isset($_POST["optscarichi"])) 
?>

<!---------------------------------------------------------------CASO REPORT ARTICOLI----------------------------------------------->


<?php


if (isset($_POST["articoli"]) && isset($_POST["optarticoli"])) {
	
    $filename = "Articoli.xls";
    header ("Content-Type: application/vnd.ms-excel");
    header ("Content-Disposition: inline; filename=$filename");

	$wherecondition = "";
	echo '<table border="1">';		
	switch ($_POST["optarticoli"]) {
		case "tutti":
			$wherecondition = "";
		break;
		case "perfornitore":
			$wherecondition =" WHERE `fornitori`.`FOR_ID`= '".$_POST["FOR_RAGSOCCOMBO2"]."' ";
		break;
		case "pertipologia":
			$wherecondition =" WHERE `tipologie`.`TIP_ID`= '".$_POST["TIP_DESCCOMBO"]."' ";
		break;
	} //fine switch

	$query = "SELECT `articoli`.`ART_COD`, `articoli`.`ART_DESC` , `articoli`.`ART_QTY_STOCK`, `tipologie`.`TIP_DESC`, `fornitori`.`FOR_RAGSOC` FROM (`articoli` INNER JOIN `tipologie` ON `articoli`.`TIP_ID` = `tipologie`.`TIP_ID`) INNER JOIN `fornitori` ON `articoli`.`FOR_ID` = `fornitori`.`FOR_ID` ".$wherecondition;
	
	echo '<tr>

		<td> CODICE INTERNO</td>
		<td> DESCRIZIONE ARTICOLO</td>
		<td> QUANTITA a STOCK</td>
		<td> FORNITORE</td>
		<td> TIPOLOGIA</td>
		

	</tr>';
	$stmt = mysqli_prepare($mysqli, $query);
	//mysqli_stmt_bind_param($stmt, "s", $login_usr);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $art_cod, $art_desc, $art_qty_stock, $tip_desc, $for_ragsoc);
	mysqli_stmt_store_result($stmt);

	while (mysqli_stmt_fetch($stmt)) {
	echo '<tr>
		<td>'.$art_cod.'</td>
		<td>'.$art_desc.'</td>
		<td>'.$art_qty_stock.'</td>
		<td>'.$for_ragsoc.'</td>
		<td>'.$tip_desc.'</td>

	</tr>';
	} //fine while
	
echo '</table>';
}  // fine if (isset($_POST["scarichi"]) && isset($_POST["optscarichi"])) 
?>






<!---------------------------------------------------------------CASO REPORT FORNITORI----------------------------------------------->


<?php


if (isset($_POST["fornitori"])) {
	
    $filename = "Fornitori.xls";
    header ("Content-Type: application/vnd.ms-excel");
    header ("Content-Disposition: inline; filename=$filename");

	$wherecondition = "";
	echo '<table border="1">';		
	

	$query = "SELECT `fornitori`.`FOR_RAGSOC`, `fornitori`.`FOR_PIVA` , `fornitori`.`FOR_INDIRIZZO`, `fornitori`.`FOR_CITTA`, `fornitori`.`FOR_PROV`, `fornitori`.`FOR_CAP`, `fornitori`.`FOR_TEL`, `fornitori`.`FOR_EMAIL` FROM `fornitori` ".$wherecondition;
	
	echo '<tr>

		<td> RAGIONE SOCIALE</td>
		<td> PARTITA IVA</td>
		<td> INDIRIZZO</td>
		<td> CITTA</td>
		<td> PROV</td>
		<td> TEL</td>
		<td> EMAIL</td>
		

	</tr>';
	$stmt = mysqli_prepare($mysqli, $query);
	//mysqli_stmt_bind_param($stmt, "s", $login_usr);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $for_ragsoc, $for_piva, $for_indirizzo, $for_citta, $for_prov, $for_cap, $for_tel, $for_email);
	mysqli_stmt_store_result($stmt);

	while (mysqli_stmt_fetch($stmt)) {
		echo '<tr>
		<td>'.$for_ragsoc.'</td>
		<td>'.$for_piva.'</td>
		<td>'.$for_indirizzo.'</td>
		<td>'.$for_citta.'</td>
		<td>'.$for_prov.'</td>
		<td>'.$for_tel.'</td>
		<td>'.$for_email.'</td>

	</tr>';
	} //fine while
	
echo '</table>';
}  // fine if (isset($_POST["fornitori"]) && isset($_POST["fornitori"])) 
?>


<!---------------------------------------------------------------CASO REPORT CLIENTI----------------------------------------------->


<?php


if (isset($_POST["clienti"])) {
	
    $filename = "Clienti.xls";
    header ("Content-Type: application/vnd.ms-excel");
    header ("Content-Disposition: inline; filename=$filename");

	$wherecondition = "";
	echo '<table border="1">';		
	

	$query = "SELECT `clienti`.`CLI_NOME`, `clienti`.`CLI_COGNOME` , `clienti`.`CLI_NOMECOGNOME`, `clienti`.`CLI_DATANASCITA`, `clienti`.`CLI_CLASSE`, `clienti`.`CLI_TEL`, `clienti`.`CLI_EMAIL` FROM `clienti` ".$wherecondition;
	
		echo '<tr>

		<td> NOME</td>
		<td> COGNOME</td>
		<td> DATA NASCITA</td>
		<td> CLASSE</td>
		<td> TELEFONO</td>
		<td> EMAIL</td>

		

	</tr>';
	$stmt = mysqli_prepare($mysqli, $query);
	//mysqli_stmt_bind_param($stmt, "s", $login_usr);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $cli_nome, $cli_cognome, $cli_nomecognome, $cli_datanascita, $cli_classe, $cli_tel, $cli_email);
	mysqli_stmt_store_result($stmt);

	while (mysqli_stmt_fetch($stmt)) {
	echo '<tr>
		<td>'.$cli_nome.'</td>
		<td>'.$cli_cognome.'</td>
		<td>'.$cli_datanascita.'</td>
		<td>'.$cli_classe.'</td>
		<td>'.$cli_tel.'</td>
		<td>'.$cli_email.'</td>

	</tr>';
	} //fine while
	
echo '</table>';
}  // fine if (isset($_POST["clienti"])) 
?>



<!---------------------------------------------------------------CASO REPORT LOG----------------------------------------------->


<?php


if (isset($_POST["log"])) {
	
    $filename = "Log.xls";
    header ("Content-Type: application/vnd.ms-excel");
    header ("Content-Disposition: inline; filename=$filename");

	$wherecondition = "";
	echo '<table border="1">';		
	

	$query = "SELECT `log`.`USER_ID`, DATE_FORMAT(`log`.`TIME`, '%d %m %Y') as `dataformattata`, `log`.`OPERAZIONE`, `log`.`QUANTITA`, `log`.`ART_DESC`, `log`.`FOR_RAGSOC`, `log`.`CLI_NOMECOGNOME`, `log`.`PXTOT`, `users`.`username` FROM (`log` INNER JOIN `users` ON `log`.`USER_ID` = `users`.`id`) ".$wherecondition;
	//echo $query;
	echo '<tr>

		<td> USERNAME</td>
		<td> DATA</td>
		<td> OPERAZIONE</td>
		<td> QUANTITA\'</td>
		<td> ARTICOLO</td>
		<td> FORNITORE</td>
		<td> CLIENTE</td>

	</tr>';
	$stmt = mysqli_prepare($mysqli, $query);
	//mysqli_stmt_bind_param($stmt, "s", $login_usr);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $user_id, $dataformattata, $operazione, $quantita, $art_desc, $for_ragsoc, $cli_nomecognome, $pxtot, $username);
	mysqli_stmt_store_result($stmt);

	while (mysqli_stmt_fetch($stmt)) {
	echo '<tr>
		<td>'.$username.'</td>
		<td>'.$dataformattata.'</td>
		<td>'.$operazione.'</td>
		<td>'.$quantita.'</td>
		<td>'.$art_desc.'</td>
		<td>'.$for_ragsoc.'</td>
		<td>'.$cli_nomecognome.'</td>
	</tr>';
	} //fine while
	
echo '</table>';
}  // fine if (isset($_POST["clienti"])) 
?>

<!--</table>-->

<body style="background-size: cover;" background="img/bg2.jpg">
</body>
</html>