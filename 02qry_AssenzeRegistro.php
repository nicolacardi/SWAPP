<?include_once("database/databaseii.php");
$ID_mae_ora = $_POST['ID_mae_ora'];
$ID_alu_ass = $_POST['ID_alu_ora'];

$datagg[1] = $_POST['datalunedi'];
$datagg[2] = date('Y-m-d',strtotime("+1 day", strtotime($datagg[1])));
$datagg[3] = date('Y-m-d',strtotime("+2 day", strtotime($datagg[1])));
$datagg[4] = date('Y-m-d',strtotime("+3 day", strtotime($datagg[1])));
$datagg[5] = date('Y-m-d',strtotime("+4 day", strtotime($datagg[1])));

//$cod_mttA = array();
//$materia_mtt = array();
$giorni = array("lun", "mar", "mer", "gio", "ven");
$materia_oraA = array();
$classe_oraA = array();
$sezione_oraA =array();
$orariA = array("idle", "8.15-9.15", "9.15-10.15", "10.45-11.45", "11.35-12.25", "12.25-13-15", "13.15-14.05", "14.05-14.55");
$dateSeq = array("idle", $datagg[1], $datagg[2], $datagg[3], $datagg[4], $datagg[5]);

//inizializzo le matrici
//5 giorni
for ($j = 1; $j <= 5; $j++) {
	//6 ore
	for ($x = 1; $x <= 7; $x++) {
		$materia_oraA[$j*10+$x] = '-';
		$classe_oraA[$j*10+$x] = '';
		$sezione_oraA[$j*10+$x] = '';
		$assenzeA[$j*10+$x] = '';
	}
}



$sql = "SELECT ID_ass, data_ass, ora_ass FROM tab_assenze WHERE (data_ass BETWEEN ? AND ?) AND ID_alu_ass = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "iss", $datagg[1], $datagg[5], $ID_alu_ass);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_ass, $data_ass, $ora_ass);
while (mysqli_stmt_fetch($stmt)) {
	//inserisco/modifico SOLO i valori dell'array di cui vengono trovati data e ora in tab_assenze
	$j = array_search($data_ass, $dateSeq);
	$x = $ora_ass;
	$assenzeA[$j*10+$x] = 1;
}




$sql = "SELECT ID_ora, data_ora, ora_ora, materia_mtt, classe_ora, sezione_ora, firma_mae_ora FROM tab_orario LEFT JOIN tab_materie ON materia_ora = cod_mtt WHERE (data_ora BETWEEN ? AND ?) AND ID_mae_ora = ? ";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "ssi", $datagg[1], $datagg[5], $ID_mae_ora);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_ora, $data_ora, $ora_ora, $materia_ora, $classe_ora, $sezione_ora, $firma_mae_ora);
while (mysqli_stmt_fetch($stmt)) {
	//metto tutto in una specie di matrice a due dimensioni: giorno+ora
	$j = array_search($data_ora, $dateSeq);
	$x = $ora_ora;
	$ID_oraA[$j*10+$x] = $ID_ora;
	$materia_oraA[$j*10+$x] = $materia_ora;
	$classe_oraA[$j*10+$x] = $classe_ora;
	$sezione_oraA[$j*10+$x] = $sezione_ora;
	$firma_mae_oraA[$j*10+$x] = $firma_mae_ora;
}
for ($x = 1; $x <= 7; $x++) { ?>
<tr>
	<td>
		<input class="tablelabel" style="height: 73px; text-align: center;" type="text" value = "<?=$x?>^ ora  [<?=$orariA[$x]?>]" disabled>
	</td>
	<?
	//una colonna per ogni giorno
	for ($j = 1; $j <= 5; $j++) { ?>
		<td  style="width: 138px; border-bottom: 1px grey solid;">
			<input style="height: 15px; text-align: center; background: transparent; border: transparent; font-size: 10px; " name="materia_ora" id="<? echo ("materia_ora".$j.$x) ?>" value ="<?=$materia_oraA[$j*10+$x]?>" disabled>
			<? if ($materia_oraA[$j*10+$x] != "-") {?>
				<div id="AssentePresente" style="cursor: pointer;" onclick="setAssenza(<?=$ID_alu_ass?>, '<?=$datagg[$j]?>', <?=$x?>);"><i href="" id="Assente<?=$j?><?=$x?>" class="fa fa-user" style="width: 70%; font-size: 18px; <? if ($assenzeA[$j*10+$x]==1) {echo(" color: red");} else {echo(" color: green");}?>"></i></div>
			<?}?>
		</td>
	<?}?>
</tr>
<? } ?>


<script>
	
	function setAssenza (ID_alu_ass, data_ass, ora_ass) {

		postData = { data_ass : data_ass, ora_ass: ora_ass, ID_alu_ass: ID_alu_ass };
		console.log(postData);
		$.ajax({
			type: 'POST',
			url: "02qry_updateAssenza.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log (data.c);
				requeryAssenze();
			}
		});
	}
	
	
</script>
