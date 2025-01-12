


<?	include_once("database/databaseii.php");
include_once("assets/functions/functions.php");
/* ora costruisco la clausola ORDER BY sulla base di tutti i valori di ord */
$ID_alu_doc = $ID_alu;
if ($ID_alu_doc == '') {$ID_alu_doc = $_POST['ID_alu_doc'];}
if (isset ($_POST['ord1'])){
	$ord1 = $_POST['ord1'];
	$ordsql = orderbysql( $ord1, 'titolo_doc', $ordsql);
} 
if (isset ($_POST['ord2'])){
	$ord2 = $_POST['ord2'];
	$ordsql = orderbysql( $ord2, 'tipo_doc', $ordsql);
} 
if (isset ($_POST['ord3'])){
	$ord3 = $_POST['ord3'];
	$ordsql = orderbysql( $ord3, 'descrizione_doc', $ordsql);
} 
if (isset ($_POST['ord4'])){
	$ord3 = $_POST['ord4'];
	$ordsql = orderbysql( $ord3, 'data_doc', $ordsql);
} 


function orderbysql ($ord, $campo, $ordsq) {
	switch ($ord) {
		case '--' :
			break;
		case 'az' :
			$ordsq = $ordsq . ' , '. $campo. ' '. 'ASC ' ;
			break;
		case 'za':
			$ordsq = $ordsq . ' , '. $campo. ' '. 'DESC ' ;
			break;
	}
	return $ordsq;
}
if ($ordsql == '') {
	$ordsql = ' ORDER BY ID_doc';
} else {
	$ordsql = ' ORDER BY ' .  substr($ordsql, 2) ;
}

$where = ' WHERE ID_alu_doc = '.$ID_alu_doc;

$sql = "SELECT ID_doc, ID_alu_doc, titolo_doc, tipo_doc, descrizione_doc, data_doc, desc_tip FROM tab_documenti LEFT JOIN tab_tipidoc ON tipo_doc = ID_tip ".$where.$ordsql;
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_doc, $ID_alu_doc, $titolo_doc, $tipo_doc, $descrizione_doc, $data_doc, $desc_tip );
$riga =  0;

while (mysqli_stmt_fetch($stmt))

{ 	$riga++;?>


	<tr>
		<td style="width:22px;">
			<img title='Cancella Documento <?//=$login_usr?>' style="width: 20px; cursor: pointer" src='assets/img/Icone/times-circle-solid.svg'' onclick="showModalDeleteThisRecord(<?=$ID_doc?>);">
		</td>
		<td style="width:22px;">
		</td>
		<td style="width:45px;">
			<button  id="goto<?=$ID_doc?>" style="width: 30px; font-size: 12px;"><?=$riga?></button>
		</td>
		<td>
			<input class="tablecell6 disab w200px" type="text"  id="titolo_doc<?=$ID_doc?>" value = "<?=$titolo_doc?>" disabled>
		</td>
		<td>
			<input class="tablecell6 disab" style="width: 100px;" type="text" id="desc_tip<?=$ID_doc?>" value = "<?=$desc_tip?>" disabled >
		</td>
		<td>
			<input class="tablecell6 disab" style="padding-left: 4px; padding-right: 5px; text-align: left; width: 300px; font-size: 10px; height: 24px;" type="text" id="descrizione_doc<?=$ID_doc?>" title = "<?=utf8_decode($descrizione_doc)?>" value = "<?=utf8_decode($descrizione_doc)?>" onchange="setValoreDoc(<?=$ID_doc?>)">
			
		</td>
		<td>
			<input class="tablecell6 disab" style="padding-left: 4px; padding-right: 5px; text-align: left; width: 100px; font-size: 10px; height: 24px;" type="text" id="data_doc<?=$ID_doc?>" title = "<?=utf8_decode($data_doc)?>" value = "<?=utf8_decode($data_doc)?>" disabled>
			
		</td>

		<td style="text-align: center;">
                <i class="fa fa-download" style="cursor: pointer; color: green" 
                   title="Scarica PDF" 
                   onclick="downloadFile(<?= $ID_doc ?>)"></i>
        </td>
	</tr>
<?}?>


